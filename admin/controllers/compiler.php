<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
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
	 * Import an spreadsheet.
	 *
	 * @return  void
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
			if ($model->builder($version,$componentId,$addBackup,$addRepo,$addPlaceholders,$debugLinenr, $minify))
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
				if (($pos = strpos($model->compiler->filepath, "/tmp/")) !== FALSE)
				{
				    $url = JURI::root() . substr($model->compiler->filepath, $pos + 1);
				}
				// Message of successful build
				$message = '<h1>The ('.$model->compiler->componentFolderName.') Was Successfully Compiled!</h1>';
				$message .= '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installExtention\')">';
				$message .= 'Install '.$model->compiler->componentFolderName.' on this <span class="icon-joomla icon-white"></span>Joomla website.</button></p>';
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
				$message .= '<h2>Path to Zip File</h2>';
				$message .= '<p><b>Path:</b> <code>'.$model->compiler->filepath.'</code><br />';
				$message .= '<b>URL:</b> <code>'.$url.'</code><br /><br />';
				$message .= '<small>Hey! you can also download the file right now!</small><br /><a class="btn btn-success" href="'.$url.'" ><span class="icon-download icon-white"></span>Download</a></p>';
				$message .= '<p><small><b>Remember!</b> This file is in your tmp folder and therefore publicly accessible untill you click [Clear tmp]!</small> </p>';
				$message .= '<p><small>Compilation took <b>'.$model->compiler->secondsCompiled.'</b> seconds to complete.</small> </p>';
				// set redirect
				$this->setRedirect($redirect_url,$message,'message');
				$app->setUserState('com_componentbuilder.extension_name', $model->compiler->componentFolderName);
			} 
			else
			{
				// wipe out the user state when we're going to redirect
				$app->setUserState('com_componentbuilder.redirect_url', '');
				$app->setUserState('com_componentbuilder.message', '');
				$app->setUserState('com_componentbuilder.extension_message', '');
				$app->setUserState('com_componentbuilder.extension_name', '');
				// set redirect
				$this->setRedirect($redirect_url,$message);
			}
			return true;
		}
		return false;
	}

	public function clearTmp()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = 'Could not clear the tmp folder';
		if($user->authorise('core.admin', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			// get tmp folder
			$comConfig = JFactory::getConfig();
			$tmp = $comConfig->get('tmp_path');
			if ($model->emptyFolder($tmp))
			{
				$message = '<b>The tmp folder has been clear successfully!</b>';
				$this->setRedirect($redirect_url,$message,'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url,$message,'error');
		return false;
	}

	public function installExtention()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = 'Could not install component!';
		if($user->authorise('core.admin'))
		{
			// get the model
			$model = $this->getModel('compiler');
			$app = JFactory::getApplication();
			$fileName = $app->getUserState('com_componentbuilder.extension_name');
			if (ComponentbuilderHelper::checkString($fileName))
			{
				$lang = JFactory::getLanguage();
				$extension = 'com_installer';
				$base_dir = JPATH_ADMINISTRATOR;
				$language_tag = 'en-GB';
				$reload = true;
				$lang->load($extension, $base_dir, $language_tag, $reload);
				$message = '('.$fileName.'.zip) file was also removed from tmp!';
				$this->setRedirect($redirect_url,$message,'message');
				return $model->install($fileName.'.zip');
			}
		}
		$this->setRedirect($redirect_url,$message,'error');
		return false;
	}
}
