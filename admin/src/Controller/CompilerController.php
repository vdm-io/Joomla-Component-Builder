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
namespace VDM\Component\Componentbuilder\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\CMS\Version;
use VDM\Joomla\Componentbuilder\File\Factory as FileFactory;
use VDM\Joomla\Componentbuilder\Import\Factory as ImportFactory;
use VDM\Joomla\Abstraction\Console\Import;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CompilerFactory;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use Joomla\CMS\Layout\LayoutHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Compiler Admin Controller
 *
 * @since  1.6
 */
class CompilerController extends AdminController
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
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Compiler', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	/**
	 * Adds option to redirect back to the dashboard.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function dashboard(): void
	{
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder', false));
	}

	/**
	 * Adding this so that the upload factory gets build for Super Powers
	 * FileFactory
	 * Adding this so that the import factory gets build for Super Powers
	 * ImportFactory
	 * Adding this so that the import cli gets build for Super Powers
	 * Import
	 */

	/**
	 * get all the animations used in the compiler
	 *
	 * @return  bool true on success
	 * @since   3.10
	 */
	public function getDynamicContent(): bool
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = $this->app->getIdentity();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_DOWNLOAD_THE_COMPILER_ANIMATIONS');
		// currently only those with permissions can get these images
		if($user->authorise('compiler.compiler_animations', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('Compiler');
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
	 * @return  bool  True on success, false otherwise.
	 * @since   5.1.2
	 */
	public function compiler(): bool
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// Access control (admins only)
		$user = $this->app->getIdentity();
		if (!$user->authorise('core.manage', 'com_componentbuilder'))
		{
			return false;
		}
		$model = $this->getModel('Compiler');
		if (!$model->builder())
		{
			return false;
		}
		// Clear menu cache (same as before) TODO: remove if not needed, lets see
		// $cache = Factory::getCache('mod_menu');
		// $cache->clean();
		$redirectUrl = (string) $this->app->getUserState('com_componentbuilder.redirect_url');
		$message = $this->app->getUserState('com_componentbuilder.message');
		if (empty($redirectUrl) && CompilerFactory::_('Config')->component_id > 0)
		{
			$hasPlugins = UtilitiesArrayHelper::check($model->compiler->filepath['plugins'] ?? [], true);
			$hasModules = UtilitiesArrayHelper::check($model->compiler->filepath['modules'] ?? [], true);
			$redirect = Route::_('index.php?option=com_componentbuilder&view=compiler', false);

			// Build the success payload (messages + UI)
			$success_message = LayoutHelper::render('jcbbuildersuccessmessage', $model);
			// Persist message to user state (as before) with your placeholder flow
			$this->app->setUserState(
				'com_componentbuilder.success_message',
				CompilerFactory::_('Placeholder')->update(
					$success_message, CompilerFactory::_('Compiler.Builder.Content.One')->allActive()
				)
			);
			// Set redirect target and flash message
			$this->setRedirect($redirect, '<h2>' . Text::_('COM_COMPONENTBUILDER_SUCCESSFUL_BUILD') . '</h2>', 'message');
			// Persist names for follow-up UI (unchanged)
			$this->app->setUserState('com_componentbuilder.component_folder_name', $model->compiler->filepath['component-folder'] ?? '');
			if ($hasModules)
			{
				$this->app->setUserState('com_componentbuilder.modules_folder_name', $model->compiler->filepath['modules-folder'] ?? []);
			}
			if ($hasPlugins)
			{
				$this->app->setUserState('com_componentbuilder.plugins_folder_name', $model->compiler->filepath['plugins-folder'] ?? []);
			}
		}
		else
		{
			// Reset state on redirect (unchanged behavior)
			$this->app->setUserState('com_componentbuilder.redirect_url', '');
			$this->app->setUserState('com_componentbuilder.message', '');
			$this->app->setUserState('com_componentbuilder.extension_message', '');
			$this->app->setUserState('com_componentbuilder.component_folder_name', '');
			$this->app->setUserState('com_componentbuilder.modules_folder_name', '');
			$this->app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$this->app->setUserState('com_componentbuilder.success_message', '');
			$this->setRedirect($redirectUrl, $message);
		}
		return true;
	}

	/**
	 * Install All Compiled Extensions
	 *
	 * @return  bool true on success
	 * @since   3.10
	 */
	public function installCompiledExtensions(): bool
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = $this->app->getIdentity();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THESE_EXTENSIONS');
		// currently only those with admin access can install a component via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_EXTENSIONS');
			$_message = ['success' => [], 'error' => []];
			// start file name array
			$fileNames = [];
			$fileNames[] = $this->app->getUserState('com_componentbuilder.component_folder_name', null);
			// check if we have modules
			$fileNames = UtilitiesArrayHelper::merge([$fileNames, $this->app->getUserState('com_componentbuilder.modules_folder_name', [])]);
			// check if we have plugins
			$fileNames = UtilitiesArrayHelper::merge([$fileNames, $this->app->getUserState('com_componentbuilder.plugins_folder_name', [])]);

			// wipe out the user c-m-p since we are done with them all
			$this->app->setUserState('com_componentbuilder.component_folder_name', '');
			$this->app->setUserState('com_componentbuilder.modules_folder_name', '');
			$this->app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$this->app->setUserState('com_componentbuilder.success_message', '');

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
				$this->app->enqueueMessage(implode('<br />', $_message['error']), 'Error');
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
	 * @return  bool true on success
	 * @since   3.10
	 */
	public function installCompiledComponent(): bool
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = $this->app->getIdentity();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_COMPONENT');
		// currently only those with admin access can install a component via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_COMPONENT');
			$fileName = $this->app->getUserState('com_componentbuilder.component_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$this->app->setUserState('com_componentbuilder.component_folder_name', '');
			$this->app->setUserState('com_componentbuilder.modules_folder_name', '');
			$this->app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$this->app->setUserState('com_componentbuilder.success_message', '');

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
	 * @return  bool true on success
	 * @since   3.10
	 */
	public function installCompiledModule(): bool
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = $this->app->getIdentity();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_MODULE');
		// currently only those with admin access can install a molule via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_MODULE');
			$fileNames = $this->app->getUserState('com_componentbuilder.modules_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$this->app->setUserState('com_componentbuilder.component_folder_name', '');
			$this->app->setUserState('com_componentbuilder.modules_folder_name', '');
			$this->app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$this->app->setUserState('com_componentbuilder.success_message', '');

			if (UtilitiesArrayHelper::check($fileNames))
			{
				$moduleId = $this->input->post->get('install_item_id', 0, 'INT');
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
	 * @return  bool true on success
	 * @since   3.10
	 */
	public function installCompiledPlugin(): bool
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = $this->app->getIdentity();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_PLUGIN');
		// currently only those with admin access can install a plugin via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_PLUGIN');
			$fileNames = $this->app->getUserState('com_componentbuilder.plugins_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$this->app->setUserState('com_componentbuilder.component_folder_name', '');
			$this->app->setUserState('com_componentbuilder.modules_folder_name', '');
			$this->app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$this->app->setUserState('com_componentbuilder.success_message', '');

			if (UtilitiesArrayHelper::check($fileNames))
			{
				$pluginId = $this->input->post->get('install_item_id', 0, 'INT');
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
	 * @return  bool true on success
	 * @since   3.10
	 */
	protected function installExtension($fileName): bool
	{
		// check that the model is set
		$compiler_model = $this->getModel('Compiler');

		// set the language if not set
		$installer_lang = $this->app->getLanguage();
		$extension = 'com_installer';
		$base_dir = JPATH_ADMINISTRATOR;
		$language_tag = 'en-GB';
		$reload = true;
		$installer_lang->load($extension, $base_dir, $language_tag, $reload);

		// make sure we have a string
		if (StringHelper::check($fileName))
		{
			return $compiler_model->install($fileName.'.zip');
		}

		return false;
	}

	/**
	 * Clear tmp folder
	 *
	 * @return  true on success
	 * @since  3.0.0
	 */
	public function clearTmp()
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = $this->app->getIdentity();

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

				// wipe out the user c-m-p since we are done with them all
				$this->app->setUserState('com_componentbuilder.component_folder_name', '');
				$this->app->setUserState('com_componentbuilder.modules_folder_name', '');
				$this->app->setUserState('com_componentbuilder.plugins_folder_name', '');
				$this->app->setUserState('com_componentbuilder.success_message', '');

				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}
}
