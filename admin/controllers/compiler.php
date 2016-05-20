<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.1.9
	@build			20th May, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		compiler.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Compiler Controller
 */
class ComponentbuilderControllerCompiler extends JControllerLegacy
{
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
			$jinput 	= JFactory::getApplication()->input;
			$componentId 	= $jinput->post->get('component', 0, 'INT');
			$version	= $jinput->post->get('version', 0, 'INT');
			$addBackup	= $jinput->post->get('backup', 0, 'INT');
			$addGit		= $jinput->post->get('git', 0, 'INT');
			$model		= $this->getModel('compiler');
			if ($model->builder($version,$componentId,$addBackup,$addGit))
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
			$redirect_url	= $app->getUserState('com_componentbuilder.redirect_url');
			$message	= $app->getUserState('com_componentbuilder.message');
			if (empty($redirect_url))
			{
				$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
				// setup the unrealistic numbers
				$counter	= $model->getCount();
				$folders	= $counter['folders'] * 5;
				$files		= $counter['files'] * 5;
				$lines		= $counter['lines'] * 10;
				$seconds	= $folders + $files + $lines;
				$totalHours	= round($seconds / 3600);
				$totalDays	= round($totalHours / 8);
				// setup the more realistic numbers
				$debugging		= $seconds / 4;
				$planning		= $seconds / 7;
				$mapping		= $seconds / 10;
				$office			= $seconds / 6;
				$seconds		= $folders + $files + $lines + $debugging + $planning + $mapping + $office;
				$actualTotalHours	= round($seconds / 3600);
				$actualTotalDays	= round($actualTotalHours / 8);
				$debuggingHours		= round($debugging / 3600);
				$planningHours		= round($planning / 3600);
				$mappingHours		= round($mapping / 3600);
				$officeHours		= round($office / 3600);
				// the actual time spent
				$actualHoursSpent = $actualTotalHours - $totalHours;
				$actualDaysSpent = $actualTotalDays - $totalDays;
				// calculate the projects actual time frame of completion
				$projectWeekTime = round($actualTotalDays / 5,1);
				$projectMonthTime = round($actualTotalDays / 24,1);
				if (($pos = strpos($counter['filePath'], "/tmp/")) !== FALSE)
				{
				    $url = JURI::root() . substr($counter['filePath'], $pos + 1);
				}
				// Message of successful build
				$message = '<h1>The ('.$counter['filename'].') Was Successfully Compiled!</h1>';
				$message .= '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installExtention\')">';
				$message .= 'Install '.$counter['filename'].' on this <span class="icon-joomla icon-white"></span>Joomla website.</button></p>';
				$message .= '<h2>Total time saved</h2>';
				$message .= '<ul>';
				$message .= '<li>Total folders created: <b>'.$counter['folders'].'</b></li>';
				$message .= '<li>Total files created: <b>'.$counter['files'].'</b></li>';
				$message .= '<li>Total lines written: <b>'.$counter['lines'].'</b></li>';
				$message .= '</ul>';
				$message .= '<p><b>'.$totalHours.' Hours</b> or <b>'.$totalDays.' Eight Hour Days</b> <em>(actual time you saved)</em><br />';
				$message .= '<small>(if creating a folder and file took <b>5 seconds</b> and writing one line of code took <b>10 seconds</b>, never making one mistake or taking any coffee break.)</small><br />';
				$message .= '<b>'.$actualHoursSpent.' Hours</b> or <b>'.$actualDaysSpent.' Eight Hour Days</b> <em>(the actual time you spent)</em><br />';
				$message .= '<small>(with the following break down: <b>debugging @'.$debuggingHours.'hours</b> = codingtime / 4; <b>planning @'.$planningHours.'hours</b> = codingtime / 7; <b>mapping @'.$mappingHours.'hours</b> = codingtime / 10; <b>office @'.$officeHours.'hours</b> = codingtime / 6;)</small></p>';
				$message .= '<p><b>'.$actualTotalHours.' Hours</b> or <b>'.$actualTotalDays.' Eight Hour Days</b> <em>(a total of the realistic time frame for this project)</em><br />';
				$message .= '<small>(if creating a folder and file took <b>5 seconds</b> and writing one line of code took <b>10 seconds</b>, with the normal everyday realities at the office, that includes the component planning, mapping & debugging.)</small></p>';
				$message .= '<p>Project duration: <b>'.$projectWeekTime. ' weeks</b> or <b>'.$projectMonthTime.' months</b></p>';
				$message .= '<h2>Path to Zip File</h2>';
				$message .= '<p><b>Path:</b> <code>'.$counter['filePath'].'</code><br />';
				$message .= '<b>URL:</b> <code>'.$url.'</code><br /><br />';
				$message .= '<small>Hey! you can also download the file right now!</small><br /><a class="btn btn-success" href="'.$url.'" ><span class="icon-download icon-white"></span>Download</a></p>';
				$message .= '<p><small><b>Remember!</b> This file is in your tmp folder and therefore publicly accessible untill you click [Clear tmp]!</small> </p>';
				// set redirect
				$this->setRedirect($redirect_url,$message,'message');
				$app->setUserState('com_componentbuilder.extension_name', $counter['filename']);
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
				return $model->install($fileName.'.zip');;
			}
		}
		$this->setRedirect($redirect_url,$message,'error');
		return false;
	}
}
