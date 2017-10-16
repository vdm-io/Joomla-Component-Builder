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

	@version		2.5.8
	@build			16th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		import_joomla_components.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder Import_joomla_components Model
 */
class ComponentbuilderModelImport_joomla_components extends JModelLegacy
{
	// set uploading values
	protected $use_streams = false;
	protected $allow_unsafe = false;
	protected $safeFileOptions = array();
	
	/**
	 * @var object JTable object
	 */
	protected $_table = null;

	/**
	 * @var object JTable object
	 */
	protected $_url = null;

	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_componentbuilder.import_joomla_components';
	
	/**
	 * Import Settings
	 */
	protected $getType 	= NULL;
	protected $dataType	= NULL;
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return  void
	 *
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('administrator');

		$this->setState('message', $app->getUserState('com_componentbuilder.message'));
		$app->setUserState('com_componentbuilder.message', '');

		// Recall the 'Import from Directory' path.
		$path = $app->getUserStateFromRequest($this->_context . '.import_directory', 'import_directory', $app->get('tmp_path'));
		$this->setState('import.directory', $path);
		parent::populateState();
	}
	
	protected $app;
	protected $target 		= false;
	protected $newID 		= array();
	protected $forceUpdate 	= 0;
	protected $hasKey 		= 0;
	protected $sleutle 		= null;
	protected $updateAfter 	= array('field' => array(), 'adminview' => array());
	protected $fieldTypes		= array();
	protected $isMultiple		= array();
	protected $specialValue 	= false;

	/**
	 * Import an spreadsheet from either folder, url or upload.
	 *
	 * @return  boolean result of import
	 *
	 */
	public function import()
	{
		$this->setState('action', 'import');
		$this->app 		= JFactory::getApplication();
		$session 			= JFactory::getSession();
		$package 			= null;
		$continue			= false;
		// get import type
		$this->getType 		= $this->app->input->getString('gettype', NULL);
		// get import type
		$this->dataType		= $session->get('dataType_VDM_IMPORTINTO', NULL);

		if ($package === null)
		{
			if ($this->dataType === 'smart_package')
			{
				$this->allow_unsafe = true;
			}
			switch ($this->getType)
			{
				case 'folder':
					// Remember the 'Import from Directory' path.
					$this->app->getUserStateFromRequest($this->_context . '.import_directory', 'import_directory');
					$package = $this->_getPackageFromFolder();
					break;

				case 'upload':
					$package = $this->_getPackageFromUpload();
					break;

				case 'url':
					$package = $this->_getPackageFromUrl();
					break;

				case 'continue-basic':
				case 'continue-ext':
					$continue 	= true;
					$package	= $session->get('package', null);
					$package	= json_decode($package, true);
					// clear session
					$session->clear('package');
					$session->clear('dataType');
					$session->clear('hasPackage');
					$session->clear('smart_package_info');
					break;

				default:
					$this->app->setUserState('com_componentbuilder.message', JText::_('COM_COMPONENTBUILDER_IMPORT_NO_IMPORT_TYPE_FOUND'));
					return false;
					break;
			}
		}
		// Was the package valid?
		if (!$package || !$package['type'])
		{
			if (in_array($this->getType, array('upload', 'url')))
			{
				$this->remove($package['packagename']);
			}

			$this->app->setUserState('com_componentbuilder.message', JText::_('COM_COMPONENTBUILDER_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE'));
			return false;
		}
		
		// first link data to table headers
		if(!$continue)
		{
			// check if this a smart package, if true then get info
			if ($this->dataType === 'smart_package')
			{
				$this->getInfo($package, $session);
			}
			$package	= json_encode($package);
			$session->set('package', $package);
			$session->set('dataType', $this->dataType);
			$session->set('hasPackage', true);
			return true;
		}

		// set the data
		if ('continue-basic' == $this->getType)
		{
				$headerList = json_decode($session->get($this->dataType.'_VDM_IMPORTHEADERS', false), true);
		}
		else
		{
				$headerList = null;
				// force update
				$this->forceUpdate 	= $this->app->input->getInt('force_update', 0);
				// has a key
				$this->hasKey 		= $this->app->input->getInt('haskey', 0);
				// die sleutle
				$this->sleutle 		= $this->app->input->getString('sleutle', NULL);
		}
		if (!$this->setData($package, $headerList))
		{
			// There was an error importing the package
			$msg = JText::_('COM_COMPONENTBUILDER_IMPORT_ERROR');
			$msgType = 'error';
			$back = $session->get('backto_VDM_IMPORT', NULL);
			if ($back)
			{
				$this->app->setUserState('com_componentbuilder.redirect_url', 'index.php?option=com_componentbuilder&view='.$back);
				$session->clear('backto_VDM_IMPORT');
			}
			$result = false;
		}
		else
		{
			// Package imported sucessfully
			$msg = JText::sprintf('COM_COMPONENTBUILDER_IMPORT_SUCCESS', $package['packagename']);
			$msgType = 'success';
			$back = $session->get('backto_VDM_IMPORT', NULL);
			if ($back)
			{
			    $this->app->setUserState('com_componentbuilder.redirect_url', 'index.php?option=com_componentbuilder&view='.$back);
			    $session->clear('backto_VDM_IMPORT');
			}
			$result = true;
		}

		// Set message to qeue
		$this->app->enqueueMessage($msg, $msgType);

		// remove file after import
		$this->remove($package['packagename']);
		$session->clear($this->getType.'_VDM_IMPORTHEADERS');
		return $result;
	}

	protected function getInfo(&$package, &$session)
	{
		// set the data
		if(isset($package['dir']))
		{
			// set auto loader
			ComponentbuilderHelper::autoLoader('smart');
			// extract the package
			if (JFile::exists($package['dir']))
			{
				// get the zip adapter
				$zip = JArchive::getAdapter('zip');
				// set the directory name
				$dir = JFile::stripExt($package['dir']);
				// unzip the package
				$zip->extract($package['dir'], $dir);
				// check for database file
				$infoFile = $dir . '/info.vdm';
				if (JFile::exists($infoFile))
				{
					// load the data
					if ($info = @file_get_contents($infoFile))
					{
						// remove all line breaks
						$info = str_replace("\n", '', $info);
						// make sure we have base64
						if ($info === base64_encode(base64_decode($info, true)))
						{
							// Get the encryption object.
							$opener = new FOFEncryptAes('V4stD3vel0pmEntMethOd@YoUrS3rv!s', 128);
							$info = rtrim($opener->decryptString($info), "\0");
							$session->set('smart_package_info', $info);
							return true;
						}
					}
				}
				ComponentbuilderHelper::removeFolder($dir);
			}
		}
		return false;
	} 

	/**
	 * Works out an importation spreadsheet from a HTTP upload
	 *
	 * @return spreadsheet definition or false on failure
	 */
	protected function _getPackageFromUpload()
	{		
		// Get the uploaded file information
		$app	= JFactory::getApplication();
		$input	= $app->input;

		// Do not change the filter type 'raw'. We need this to let files containing PHP code to upload. See JInputFiles::get.
		$userfile = $input->files->get('import_package', null, 'raw');
		
		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads'))
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_WARNIMPORTFILE'), 'warning');
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile))
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_NO_FILE_SELECTED'), 'warning');
			return false;
		}

		// Check if there was a problem uploading the file.
		if ($userfile['error'] || $userfile['size'] < 1)
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_WARNIMPORTUPLOADERROR'), 'warning');
			return false;
		}

		// Build the appropriate paths
		$config		= JFactory::getConfig();
		$tmp_dest	= $config->get('tmp_path') . '/' . $userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$p_file = JFile::upload($tmp_src, $tmp_dest, $this->use_streams, $this->allow_unsafe, $this->safeFileOptions);

		// Was the package downloaded?
		if (!$p_file)
		{
			$session = JFactory::getSession();
			$session->clear('package');
			$session->clear('dataType');
			$session->clear('hasPackage');
			// was not uploaded
			return false;
		}

		// check that this is a valid spreadsheet
		$package = $this->check($userfile['name']);

		return $package;
	}

	/**
	 * Import an spreadsheet from a directory
	 *
	 * @return  array  Spreadsheet details or false on failure
	 *
	 */
	protected function _getPackageFromFolder()
	{
		$app	= JFactory::getApplication();
		$input	= $app->input;

		// Get the path to the package to import
		$p_dir = $input->getString('import_directory');
		$p_dir = JPath::clean($p_dir);
		// Did you give us a valid path?
		if (!file_exists($p_dir))
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY'), 'warning');
			return false;
		}

		// Detect the package type
		$type = $this->getType;

		// Did you give us a valid package?
		if (!$type)
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE'), 'warning');
		}
		
		// check the extention
		if(!$this->checkExtension($p_dir))
		{
			// set error message
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE'), 'warning');
			return false;
		}
		
		$package['packagename'] = null;
		$package['dir'] 	= $p_dir;
		$package['type'] 	= $type;

		return $package;
	}

	/**
	 * Import an spreadsheet from a URL
	 *
	 * @return  Package details or false on failure
	 *
	 */
	protected function _getPackageFromUrl()
	{
		$app	= JFactory::getApplication();
		$input	= $app->input;

		// Get the URL of the package to import
		$url = $input->getString('import_url');

		// Did you give us a URL?
		if (!$url)
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_ENTER_A_URL'), 'warning');
			return false;
		}

		// Download the package at the URL given
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file)
		{
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_INVALID_URL'), 'warning');
			return false;
		}

		// check that this is a valid spreadsheet
		$package = $this->check($p_file);

		return $package;
	}
	
	/**
	 * Check a file and verifies it as a spreadsheet file
	 * Supports .csv .xlsx .xls and .ods
	 *
	 * @param   string  $p_filename  The uploaded package filename or import directory
	 *
	 * @return  array  of elements
	 *
	 */
	protected function check($archivename)
	{
		$app	= JFactory::getApplication();
		// Clean the name
		$archivename = JPath::clean($archivename);
		
		// check the extention
		if(!$this->checkExtension($archivename))
		{
			// Cleanup the import files
			$this->remove($archivename);
			$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE'), 'warning');
			return false;
		}
		
		$config			= JFactory::getConfig();
		// set Package Name
		$check['packagename']	= $archivename;
		
		// set directory
		$check['dir']		= $config->get('tmp_path'). '/' .$archivename;
		
		// set type
		$check['type']		= $this->getType;
		
		return $check;
	}
	
	/**
	 * Check the extension
	 *
	 * @param   string  $file    Name of the uploaded file
	 *
	 * @return  boolean  True on success
	 *
	 */
	protected function checkExtension($file)
	{
		// check the extension
		switch(strtolower(pathinfo($file, PATHINFO_EXTENSION)))
		{
			case 'xls':
			case 'ods':
			case 'csv':
			return true;
			break;
			case 'zip':
			if ($this->dataType === 'smart_package')
			{
				return true;
			}
			break;
		}
		return false;
	} 
	
	/**
	 * Clean up temporary uploaded spreadsheet
	 *
	 * @param   string  $package    Name of the uploaded spreadsheet file
	 *
	 * @return  boolean  True on success
	 *
	 */
	protected function remove($package)
	{
		jimport('joomla.filesystem.file');
		
		$config		= JFactory::getConfig();
		$package	= $config->get('tmp_path'). '/' .$package;

		// Is the package file a valid file?
		if (is_file($package))
		{
			JFile::delete($package);
		}
		elseif (is_file(JPath::clean($package)))
		{
			// It might also be just a base filename
			JFile::delete(JPath::clean($package));
		}
	}
	
	/**
	* Set the data from the spreadsheet to the database
	*
	* @param string  $package Paths to the uploaded package file
	*
	* @return  boolean false on failure
	*
	**/
	protected function setData($package, $target_headers)
	{
		$jinput = JFactory::getApplication()->input;
		// set the data based on the type of import being done
		if ('continue-basic' === $this->getType && ComponentbuilderHelper::checkArray($target_headers))
		{
			foreach($target_headers as $header)
			{
				$data['target_headers'][$header] = $jinput->getString($header, null);
			}
			// make sure the file is loaded		
			JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
			// set the data
			if(isset($package['dir']))
			{
				$inputFileType = PHPExcel_IOFactory::identify($package['dir']);
				$excelReader = PHPExcel_IOFactory::createReader($inputFileType);
				$excelReader->setReadDataOnly(true);
				$excelObj = $excelReader->load($package['dir']);
				$data['array'] = $excelObj->getActiveSheet()->toArray(null, true,true,true);
				$excelObj->disconnectWorksheets();
				unset($excelObj);
				return $this->saveBasic($data);
			}
		}
		elseif ('continue-ext' === $this->getType)
		{
			// set the data
			if(isset($package['dir']))
			{
				// set auto loader
				ComponentbuilderHelper::autoLoader('smart');
				// extract the package
				if (JFile::exists($package['dir']))
				{
					// set the directory name
					$dir = JFile::stripExt($package['dir']);
					// check for database file
					$dbFile = $dir . '/db.vdm';
					if (!JFile::exists($dbFile))
					{
						// get the zip adapter
						$zip = JArchive::getAdapter('zip');
						// unzip the package
						$zip->extract($package['dir'], $dir);
					}
					// check again
					if (JFile::exists($dbFile))
					{
						// load the data
						if ($data = @file_get_contents($dbFile))
						{
							// prep the data
							if ($data = $this->extractData($data))
							{
								if (isset($data['joomla_component']) && ComponentbuilderHelper::checkArray($data['joomla_component']))
								{
									// save the smart data
									if ($this->saveSmartComponents($data, $dir))
									{
										ComponentbuilderHelper::removeFolder($dir);
										return true;
									}
								}
							}
						}
					}
					ComponentbuilderHelper::removeFolder($dir);
				}
			}
		}
		return false;
	}

	/**
	* Extract the data from the string
	*
	* @param string  $data The data string
	*
	* @return  object false on failure
	*
	**/
	protected function extractData($data)
	{
		// remove all line breaks
		$data = str_replace("\n", '', $data);
		// make sure we have base64
		if ($data === base64_encode(base64_decode($data, true)))
		{
			// open the data
			if(ComponentbuilderHelper::checkString($this->sleutle) && strlen($this->sleutle) == 32)
			{
				// Get the encryption object.
				$opener = new FOFEncryptAes($this->sleutle, 128);
				$data = rtrim($opener->decryptString($data), "\0");
			}
			else
			{
				$data = base64_decode($data);
			}
			// final check if we have success
			$data = @unserialize($data);
			if ($data !== false)
			{
				return $data;
			}
			$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_HTWODATA_IS_CORRUPTHTWOTHIS_COULD_BE_DUE_TO_KEY_ERROR_OR_BROKEN_PACKAGE'), 'error');
			return false;
		}
		$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_HTWODATA_IS_CORRUPTHTWOTHIS_COULD_BE_DUE_TO_BROKEN_PACKAGE'), 'error');
		return false;
	} 
	
	/**
	* Save the smart components
	*
	* @param array  $data The values to save
	*
	* @return  boolean false on failure
	*
	**/
	protected function saveSmartComponents($data, $dir)
	{
		// get user object
		$this->user = JFactory::getUser();
		// set some defaults
		$this->today = JFactory::getDate()->toSql();
		// we first store the fieldtype
		if (!$this->saveSmartItems($data, 'fieldtype'))
		{
			return false;
		}
		// we then store the field
		if (!$this->saveSmartItems($data, 'field'))
		{
			return false;
		}
		// we then store the admin_view
		if (!$this->saveSmartItems($data, 'admin_view'))
		{
			return false;
		}
		// we then store the admin_fields
		if (!$this->saveSmartItems($data, 'admin_fields'))
		{
			return false;
		}
		// we then store the admin_fields_conditions
		if (!$this->saveSmartItems($data, 'admin_fields_conditions'))
		{
			return false;
		}
		// we then store the snippet
		if (!$this->saveSmartItems($data, 'snippet'))
		{
			return false;
		}
		// we then store the dynamic_get
		if (!$this->saveSmartItems($data, 'dynamic_get'))
		{
			return false;
		}
		// we then store the custom_admin_view
		if (!$this->saveSmartItems($data, 'custom_admin_view'))
		{
			return false;
		}
		// we then store the site_view
		if (!$this->saveSmartItems($data, 'site_view'))
		{
			return false;
		}
		// we then store the template
		if (!$this->saveSmartItems($data, 'template'))
		{
			return false;
		}
		// we then store the layout
		if (!$this->saveSmartItems($data, 'layout'))
		{
			return false;
		}
		// we then store the components
		if (!$this->saveSmartItems($data, 'joomla_component'))
		{
			return false;
		}
		// we then store the languages
		if (!$this->saveSmartItems($data, 'language'))
		{
			return false;
		}
		// we then store the language translations
		if (!$this->saveSmartItems($data, 'language_translation'))
		{
			return false;
		}
		// we then store the custom_code
		if (!$this->saveSmartItems($data, 'custom_code'))
		{
			return false;
		}
		// do a after all run on all items that need it
		$this->updateAfter();
		// lets move all the files to its correct location
		if (!$this->moveSmartStuff($dir))
		{
			return false;
		}
		return true;
	}

	/**
	* Move the smart content (files & folders) into place
	*
	* @param string  $dir    The path to the folders
	*
	* @return  boolean false on failure
	*
	**/
	protected function moveSmartStuff($dir)
	{
		// make sure to first unlock files
		$this->unLockFiles($dir);
		// set params
		$params = JComponentHelper::getParams('com_componentbuilder');
		// set custom folder path
		$customPath = str_replace('//', '/', $params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom'));
		$imagesPath = str_replace('//', '/', JPATH_SITE . '/images');
		$success = true;
		// check if we have custom files
		$customDir = str_replace('//', '/', $dir . '/custom');
		if (JFolder::exists($customDir))
		{
			// great we have some custom stuff lets move it
			if (!JFolder::copy($customDir, $customPath,'',true))
			{
				$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_BCUSTOM_FILESB_NOT_MOVE_TO_CORRECT_LOCATION'), 'error');
				$success = false;
			}
		}
		// check if we have images
		$imageDir = str_replace('//', '/', $dir . '/images');
		if (JFolder::exists($imageDir))
		{
			// great we have some images lets move them
			if (!JFolder::copy($imageDir, $imagesPath,'',true))
			{
				$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_BIMAGESB_NOT_MOVE_TO_CORRECT_LOCATION'), 'error');
				$success = false;
			}
		}
		return $success;
	}

	/**
	* Method to unlock all files
	*
	* @return void
	*/
	protected function unLockFiles(&$dir)
	{
		// lock the data if set
		if(ComponentbuilderHelper::checkString($this->sleutle) && strlen($this->sleutle) == 32)
		{
			$unlocker = new FOFEncryptAes($this->sleutle, 128);
			// we must first store the current working directory
			$joomla = getcwd();
			// setup the type path
			$customPath = str_replace('//', '/', $dir . '/custom');
			// go to the custom folder if found
			if (JFolder::exists($customPath))
			{
				$this->unlock($customPath, $unlocker);
			}
			// setup the type path
			$imagesPath = str_replace('//', '/', $dir . '/images');
			// go to the custom folder if found
			if (JFolder::exists($imagesPath))
			{
				$this->unlock($imagesPath, $unlocker);
			}
			// change back to working dir
			chdir($joomla);
		}
	}

	/**
	* The Unlocker
	*
	* @return void
	*/	
	protected function unlock(&$tmpPath, &$unlocker)
	{
		// we are changing the working directory to the tmp path (important)
		chdir($tmpPath);
		// get a list of files in the current directory tree (all)
		$files = JFolder::files('.', '.', true, true);
		// read in the file content
		foreach ($files as $file)
		{
			// check that the string is base64
			$data = str_replace("\n", '', file_get_contents($file));
			if ($data === base64_encode(base64_decode($data, true)))
			{
				// write the decrypted data back to file
				if (!ComponentbuilderHelper::writeFile($file, rtrim($unlocker->decryptString($data), "\0")))
				{
					// we should add error handler here in case file could not be unlocked
				}
			}
			
		}
	}

	/**
	* Save the smart items
	*
	* @param array   $items  The values to save
	* @param string  $type    The type of values
	*
	* @return  boolean false on failure
	*
	**/
	protected function saveSmartItems(&$items, $type)
	{
		$success = true;
		if (isset($items[$type]) && ComponentbuilderHelper::checkArray($items[$type]))
		{
			// get global action permissions
			$canDo		= ComponentbuilderHelper::getActions($type);
			$canEdit		= $canDo->get('core.edit');
			$canState		= $canDo->get('core.edit.state');
			$canCreate	= $canDo->get('core.create');
			// set id keeper
			if (!isset($this->newID[$type]))
			{
				$this->newID[$type] = array();
			}
			foreach ($items[$type] as $item)
			{
				$oldID = $item->id;
				// first check if exist
				if ($local = $this->getLocalItem($item, $type, 1))
				{
					$dbDate = strtotime($item->modified);
					$localDate = strtotime($local->modified);
					// okay we have it local (check if the version is newer)
					if ($this->forceUpdate == 1 || $dbDate > $localDate)
					{
						// add some local values to item to combine
						if ($type === 'language_translation')
						{
							$item->localComponents = $local->components;
							$item->localTranslation = $local->translation;
						}
						// make sure we have the correct ID set
						$item->id = $local->id;
						// yes it is newer, lets update (or is being forced)
						if ($canEdit && $id = $this->updateLocalItem($item, $type, $canState))
						{
							$this->newID[$type][$oldID] = $id;
						}
						else
						{
							$notice = '!';
							if (!$canEdit)
							{
								$notice = JText::sprintf("COM_COMPONENTBUILDER__SINCE_YOU_DONT_HAVE_PERMISSION_TO_EDIT_S", $type);
							}
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_COULD_NOT_BE_IMPORTEDS', $type.' id:'.$oldID, $notice), 'error');
						}
					}
					else
					{
						$this->newID[$type][$oldID] = $local->id;
					}
				}
				elseif ($canCreate && $id = $this->addLocalItem($item, $type))
				{
					// not found in local db so add
					$this->newID[$type][$oldID] = $id;
				}
				else
				{
					$notice = '!';
					if (!$canCreate)
					{
						$notice = JText::sprintf("COM_COMPONENTBUILDER__SINCE_YOU_DONT_HAVE_PERMISSION_TO_CREATE_S", $type);
					}
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_COULD_NOT_BE_IMPORTEDS', $type.' id:'.$oldID, $notice), 'error');
				}
			}
		}
		return $success;
	}

	/**
	* Update some items after all
	*
	*
	* @return  void
	*
	**/
	protected function updateAfter()
	{
		if (ComponentbuilderHelper::checkArray($this->updateAfter['field']))
		{
			// update repeatable
			foreach ($this->updateAfter['field'] as $field)
			{
				if (isset($this->newID['field'][$field]))
				{
					$field = $this->newID['field'][$field];
				}
				// get the field from db
				if ($xml = ComponentbuilderHelper::getVar('field', $field, 'id', 'xml'))
				{
					if (ComponentbuilderHelper::checkJson($xml))
					{
						$xml = json_decode($xml);
						$fields = ComponentbuilderHelper::getBetween($xml, 'fields="', '"');
						$fieldsSets = array();
						if (strpos($fields, ',') !== false)
						{
							// multiple fields
							$fieldsSets = array_map('trim', (array) explode(',', $fields));
						}
						elseif (is_numeric($fields))
						{
							// single field
							$fieldsSets[] = (int) $fields;
						}
						// update the fields
						if (ComponentbuilderHelper::checkArray($fieldsSets))
						{
							$bucket = array();
							foreach ($fieldsSets as $id)
							{
								if (isset($this->newID['field'][$id]))
								{
									$bucket[] = $this->newID['field'][$id];
								}
								else
								{
									$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BREPEATABLEB_IDS_MISMATCH_IN_BFIELDSB_AND_WAS_EMREMOVEDEM_FROM_THE_FIELD', $id, $field), 'warning');
								}
							}
							if (ComponentbuilderHelper::checkArray($bucket))
							{
								$string = implode(',', $bucket);
								$xml = json_encode(str_replace('fields="' . $fields . '"', 'fields="' . $string . '"', $xml));
							}
							else
							{
								$xml = '';
							}
							$object = new stdClass;
							$object->id = $field;
							$object->xml = $xml;
							// update the field
							$this->_db->updateObject('#__componentbuilder_field', $object, 'id');
						}
					}
				}
			}
		}
		// do a after all run on admin views that need it
		if (ComponentbuilderHelper::checkArray($this->updateAfter['adminview']))
		{
			// update the addlinked_views
			foreach ($this->updateAfter['adminview'] as $adminview)
			{
				if (isset($this->newID['admin_view'][$adminview]))
				{
					$adminview = $this->newID['admin_view'][$adminview];
				}
				// get the field from db
				if ($addlinked_views = ComponentbuilderHelper::getVar('admin_view', $adminview, 'id', 'addlinked_views'))
				{
					if (ComponentbuilderHelper::checkJson($addlinked_views))
					{
						$addlinked_views = json_decode($addlinked_views, true);
						if (ComponentbuilderHelper::checkArray($addlinked_views['adminview']))
						{
							foreach ($addlinked_views['adminview'] as $nr => $admin)
							{
								if (isset($this->newID['admin_view'][$admin]))
								{
									$addlinked_views['adminview'][$nr] = $this->newID['admin_view'][$admin];
								}
								else
								{
									$addlinked_views['adminview'][$nr] = '';
									$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BLINKED_VIEWB_IDS_MISMATCH_IN_BADMIN_VIEWSB_AND_WAS_EMREMOVEDEM_FROM_THE_LINKED_VIEWS', $admin, $adminview), 'warning');
								}
							}
							// update the fields
							$object = new stdClass;
							$object->id = $adminview;
							$object->addlinked_views = json_encode($addlinked_views);
							// update the admin view
							$this->_db->updateObject('#__componentbuilder_admin_view', $object, 'id');
						}
					}
				}
			}
		}
	}

	/*
	 * Convert repeatable field to subform
	 * 
	 * @param   array    $array    The array
	 * @param   string   $name     The main field name
	 *
	 * @return  array
	 */
	protected function convertRepeatable($array, $name)
	{
		$bucket = array();
		foreach ($array as $key => $values)
		{
			foreach ($values as $nr => $value)
			{
				if (!isset($bucket[$name . $nr]) || !ComponentbuilderHelper::checkArray($bucket[$name . $nr]))
				{
					$bucket[$name . $nr] = array();
				}
				$bucket[$name . $nr][$key] = $value;
			}
		}
		return $bucket;
	}

	/**
	* Prep the item
	*
	* @param object $item      The item to prep
	* @param string $type      The type of values
	* @param string $action    The action (add/update)
	*
	* @return  mixed           false on failure
	*                          object on success
	*
	**/
	protected function prepItem($item, &$type, $action)
	{
		// actions to effect both
		if (isset($item->asset_id))
		{
			unset($item->asset_id);
		}
		if (isset($item->checked_out))
		{
			$item->checked_out = 0;
		}
		if (isset($item->checked_out_time))
		{
			$item->checked_out_time = '0000-00-00 00:00:00';
		}
		// do the id fix for the new ids		
		switch($type)
		{
			case 'field':
				// update the fieldtype
				if (isset($item->fieldtype) && is_numeric($item->fieldtype) && $item->fieldtype > 0 && isset($this->newID['fieldtype'][$item->fieldtype]))
				{
					$item->fieldtype = $this->newID['fieldtype'][$item->fieldtype];
					// update multi field values
					if ($this->checkMultiFields($item->fieldtype))
					{
						$this->updateAfter['field'][$item->id] = $item->id; // multi field
					}
				}
				elseif (!is_numeric($item->fieldtype) || $item->fieldtype == 0)
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BFIELD_TYPEB_NOT_SET_FOR_BSB', ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'warning');
					unset($item->fieldtype);
				}
				else
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BFIELD_TYPEB_IDS_MISMATCH_IN_BSB', $item->fieldtype, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'error');
					return false;
				}
			break;
			case 'dynamic_get':
				// update the view_table_main ID
				if (isset($item->main_source) && $item->main_source == 1 && isset($item->view_table_main) && is_numeric($item->view_table_main) && $item->view_table_main > 0)
				{
					if (isset($this->newID['admin_view'][$item->view_table_main]))
					{
						$item->view_table_main = $this->newID['admin_view'][$item->view_table_main];
					}
					else
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BVIEW_TABLE_MAINB_IDS_MISMATCH_IN_BSB', $item->view_table_main, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'error');
						return false;
					}
				}
				// update the join_view_table
				if (isset($item->join_view_table) && ComponentbuilderHelper::checkJson($item->join_view_table))
				{
					$join_view_table = json_decode($item->join_view_table, true);
					// check if this is old values for repeatable fields
					if (isset($join_view_table['view_table']))
					{
						$join_view_table = $this->convertRepeatable($join_view_table, 'join_view_table');
					}
					foreach ($join_view_table as $nr => $join_values)
					{
						$id = $join_values['view_table'];
						if (!is_numeric($id))
						{
							continue;
						}
						// update the id's with local id's
						if (isset($this->newID['admin_view'][$id]))
						{
							$join_view_table[$nr]['view_table'] = $this->newID['admin_view'][$id];
						}
						else
						{							
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BJOIN_VIEW_TABLE_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BJOIN_VIEW_TABLEB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $id), 'warning');
							$join_values['view_table'] = '';
						}
					}
					// load it back
					$item->join_view_table = json_encode($join_view_table);
				}
				else
				{
					unset($item->join_view_table);
				}
				// repeatable fields to update
				$updaterR = array(
							'join_db_table' => 'db_table',
							'order' => 'table_key',
							'where' => 'table_key',
							'global' => 'name',
							'filter' => 'filter_type'
							);
				// update the repeatable fields
				foreach ($updaterR as  $up => $sleutel)
				{
					if (isset($item->{$up}) && ComponentbuilderHelper::checkJson($item->{$up}))
					{
						$updateArray = json_decode($item->{$up}, true);
						// check if this is old values for repeatable fields
						if (isset($updateArray[$sleutel]))
						{
							$updateArray = $this->convertRepeatable($updateArray, $up);
							// load it back
							$item->{$up} = json_encode($updateArray);
						}
					}
					elseif (isset($item->{$up}))
					{
						unset($item->{$up});
					}
				}
			break;
			case 'layout':
			case 'template':
				// update the dynamic_get
				if (isset($item->dynamic_get) && is_numeric($item->dynamic_get) && $item->dynamic_get > 0 && isset($this->newID['dynamic_get'][$item->dynamic_get]))
				{
					$item->dynamic_get = $this->newID['dynamic_get'][$item->dynamic_get];
				}
				elseif (!is_numeric($item->dynamic_get) || $item->dynamic_get == 0)
				{
					unset($item->dynamic_get);
				}
				else
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BDYNAMIC_GETB_IDS_MISMATCH_IN_BSB', $item->dynamic_get, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'warning');
					unset($item->dynamic_get);
				}
				// update the snippet
				if (isset($item->snippet) && is_numeric($item->snippet) && $item->snippet > 0 && isset($this->newID['snippet'][$item->snippet]))
				{
					$item->snippet = $this->newID['snippet'][$item->snippet];
				}
				elseif (!is_numeric($item->snippet) || $item->snippet == 0)
				{
					unset($item->snippet);
				}
				else
				{
					// $this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSNIPPETB_IDS_MISMATCH_IN_BSB', $item->snippet, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'warning');
					// unset($item->snippet);
				}
			break;
			case 'custom_admin_view':
			case 'site_view':
				// update the main_get
				if (isset($item->main_get) && is_numeric($item->main_get) && $item->main_get > 0 && isset($this->newID['dynamic_get'][$item->main_get]))
				{
					$item->main_get = $this->newID['dynamic_get'][$item->main_get];
				}
				elseif (!is_numeric($item->main_get) || $item->main_get == 0)
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BMAIN_GETB_NOT_SET_FOR_BSB', ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'warning');
					unset($item->main_get);
				}
				else
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BMAIN_GETB_IDS_MISMATCH_IN_BSB', $item->main_get, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'error');
					return false;
				}
				// update the dynamic_get
				if (isset($item->dynamic_get) && is_numeric($item->dynamic_get) && $item->dynamic_get > 0 && isset($this->newID['dynamic_get'][$item->dynamic_get]))
				{
					$item->dynamic_get = $this->newID['dynamic_get'][$item->dynamic_get];
				}
				elseif (!is_numeric($item->dynamic_get) || $item->dynamic_get == 0)
				{
					unset($item->dynamic_get);
				}
				else
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BDYNAMIC_GETB_IDS_MISMATCH_IN_BSB', $item->dynamic_get, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'warning');
					unset($item->dynamic_get);
				}
				// update the custom_get
				if (isset($item->custom_get) && ComponentbuilderHelper::checkJson($item->custom_get))
				{
					$custom_get = json_decode($item->custom_get, true);
					foreach ($custom_get as $nr => $get)
					{
						if (!is_numeric($get))
						{
							continue;
						}
						// update the custom_get
						if (isset($this->newID['dynamic_get'][$get]))
						{
							$custom_get[$nr] = $this->newID['dynamic_get'][$get];
						}
						else
						{
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BCUSTOM_GET_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BDYNAMIC_GETB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $get), 'warning');
							unset($custom_get[$nr]);
						}
					}
					// load it back if there is any remaining
					if (ComponentbuilderHelper::checkArray($custom_get))
					{
						$item->custom_get = json_encode( (object) $custom_get);
					}
					else
					{
						unset($item->custom_get);
					}
				}
				else
				{
					unset($item->custom_get);
				}
				// update the snippet
				if (isset($item->snippet) && is_numeric($item->snippet) && $item->snippet > 0 && isset($this->newID['snippet'][$item->snippet]))
				{
					$item->snippet = $this->newID['snippet'][$item->snippet];
				}
				elseif (!is_numeric($item->snippet) || $item->snippet == 0)
				{
					unset($item->snippet);
				}
				else
				{
					// $this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSNIPPETB_IDS_MISMATCH_IN_BSB', $item->snippet, ComponentbuilderHelper::safeString($type, 'w').':'.$item->id), 'warning');
					// unset($item->snippet);
				}
				// repeatable fields to update
				$updaterR = array(
							'ajax_input' => 'value_name',
							'custom_button' => 'name'
							);
				// update the repeatable fields
				foreach ($updaterR as  $up => $sleutel)
				{
					if (isset($item->{$up}) && ComponentbuilderHelper::checkJson($item->{$up}))
					{
						$updateArray = json_decode($item->{$up}, true);
						// check if this is old values for repeatable fields
						if (isset($updateArray[$sleutel]))
						{
							$updateArray = $this->convertRepeatable($updateArray, $up);
							// load it back
							$item->{$up} = json_encode($updateArray);
						}
					}
					elseif (isset($item->{$up}))
					{
						unset($item->{$up});
					}
				}
			break;
			case 'admin_view':
				// we must clear the demo content (since it was not moved as far as we know) TODO
				if ($item->add_sql == 1 && $item->source == 1)
				{
					// only if it is mapped to a table
					unset($item->add_sql);
					unset($item->source);
					unset($item->addtables);
				}
				// update the addfields (old dataset)
				if (isset($item->addfields) && ComponentbuilderHelper::checkJson($item->addfields))
				{
					// set the targets
					$targets = array('field' => 'field');
					// set the anchors
					$anchor = array('admin_view' => $item->id);
					// move the old data
					$this->moveData($item->addfields, 'admin_fields', 'addfields', 'target_field', $targets, $anchor);
					// remove from this dataset
					unset($item->addfields);
				}
				else
				{
					unset($item->addfields);
				}
				// update the addlinked_views
				if (isset($item->addlinked_views) && ComponentbuilderHelper::checkJson($item->addlinked_views))
				{
					$this->updateAfter['adminview'][$item->id] = $item->id; // addlinked_views
				}
				else
				{
					unset($item->addlinked_views);
				}
				// update the addconditions (old dataset)
				if (isset($item->addconditions))
				{
					// set the targets
					$targets = array('target_field' => 'field', 'match_field' => 'field');
					// set the anchors
					$anchor = array('admin_view' => $item->id);
					// move the old data
					$this->moveData($item->addconditions, 'admin_fields_conditions', 'addconditions', 'target_field', $targets, $anchor);
					// remove from this dataset
					unset($item->addconditions);
				}
				else
				{
					unset($item->addconditions);
				}
				// repeatable fields to update
				$updaterR = array(
						'ajax_input' => 'value_name',
						'custom_button' => 'name',
						'addtables' => 'table',
						'addlinked_views' => 'adminview',
						'addtabs' => 'name',
						'addpermissions' => 'action'
					);
				// update the repeatable fields
				foreach ($updaterR as  $up => $sleutel)
				{
					if (isset($item->{$up}) && ComponentbuilderHelper::checkJson($item->{$up}))
					{
						$updateArray = json_decode($item->{$up}, true);
						// check if this is old values for repeatable fields
						if (isset($updateArray[$sleutel]))
						{
							$updateArray = $this->convertRepeatable($updateArray, $up);
							// load it back
							$item->{$up} = json_encode($updateArray);
						}
					}
					elseif (isset($item->{$up}))
					{
						unset($item->{$up});
					}
				}
			break;
			case 'joomla_component':
				// update the addconfig
				if (isset($item->addconfig) && ComponentbuilderHelper::checkJson($item->addconfig))
				{
					$addconfig = json_decode($item->addconfig, true);
					foreach ($addconfig['field'] as $nr => $id)
					{
						if (!is_numeric($id))
						{
							continue;
						}
						// update the addconfig
						if (isset($this->newID['field'][$id]))
						{
							$addconfig['field'][$nr] = $this->newID['field'][$id];
						}
						else
						{
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BCONFIG_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BFIELDB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $id), 'warning');
							$addconfig['field'][$nr] = '';
						}
					}
					// load it back
					$item->addconfig = json_encode($addconfig);
				}
				// update the addadmin_views
				if (isset($item->addadmin_views) && ComponentbuilderHelper::checkJson($item->addadmin_views))
				{
					$addadmin_views = json_decode($item->addadmin_views, true);
					foreach ($addadmin_views['adminview'] as $nr => $id)
					{
						if (!is_numeric($id))
						{
							continue;
						}
						// update the addadmin_views
						if (isset($this->newID['admin_view'][$id]))
						{
							$addadmin_views['adminview'][$nr] = $this->newID['admin_view'][$id];
						}
						else
						{
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BADMIN_VIEW_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BADMIN_VIEWB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $id), 'warning');
							$addadmin_views['adminview'][$nr] = '';
						}
					}
					// load it back
					$item->addadmin_views = json_encode($addadmin_views);
				}
				else
				{
					unset($item->addadmin_views);
				}
				// update the addcustom_admin_views
				if (isset($item->addcustom_admin_views) && ComponentbuilderHelper::checkJson($item->addcustom_admin_views))
				{
					$addcustom_admin_views = json_decode($item->addcustom_admin_views, true);
					foreach ($addcustom_admin_views['customadminview'] as $nr => $id)
					{
						if (!is_numeric($id))
						{
							continue;
						}
						// update the addcustom_admin_views
						if (isset($this->newID['custom_admin_view'][$id]))
						{
							$addcustom_admin_views['customadminview'][$nr] = $this->newID['custom_admin_view'][$id];
						}
						else
						{
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BCUSTOM_ADMIN_VIEW_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BCUSTOM_ADMIN_VIEWB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $id), 'warning');
							$addcustom_admin_views['customadminview'][$nr] = '';
						}
					}
					// load it back
					$item->addcustom_admin_views = json_encode($addcustom_admin_views);
				}
				// update the addsite_views
				if (isset($item->addsite_views) && ComponentbuilderHelper::checkJson($item->addsite_views))
				{
					$addsite_views = json_decode($item->addsite_views, true);
					foreach ($addsite_views['siteview'] as $nr => $id)
					{
						if (!is_numeric($id))
						{
							continue;
						}
						// update the addsite_views
						if (isset($this->newID['site_view'][$id]))
						{
							$addsite_views['siteview'][$nr] = $this->newID['site_view'][$id];
						}
						else
						{
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSITE_VIEW_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BSITE_VIEWB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $id), 'warning');
							$addsite_views['siteview'][$nr] = '';
						}
					}
					// load it back
					$item->addsite_views = json_encode($addsite_views);
				}
			break;
			case 'custom_code':
				// update the component ID where needed
				if (isset($item->component) && $item->component > 0)
				{
					if (isset($this->newID['joomla_component'][$item->component]))
					{
						$item->component = $this->newID['joomla_component'][$item->component];
					}
					else
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BCOMPONENT_IN_SB_HAS_ID_MISMATCH_OF_SELECTED_BCOMPONENTB_SO_THE_IDS_WAS_REMOVED', '('.ComponentbuilderHelper::safeString($type, 'w').':'.$item->id.')', $item->component), 'warning');
						unset($item->component);
					}
				}
			break;
			case 'language_translation':
				// update the component ID where needed
				if (isset($item->components) && ComponentbuilderHelper::checkJson($item->components))
				{
					$components = json_decode($item->components, true);
					foreach ($components as $nr => $id)
					{
						if (!is_numeric($id))
						{
							continue;
						}
						// update the components
						if (isset($this->newID['joomla_component'][$id]))
						{
							$components[$nr] = $this->newID['joomla_component'][$id];
						}
						else
						{
							unset($components[$nr]);
						}
					}
				}
				// load the local components if found
				if (isset($item->localComponents) && ComponentbuilderHelper::checkJson($item->localComponents))
				{
					if (!isset($components))
					{
						$components= array();
					}
					$localComponents = json_decode($item->localComponents, true);
					foreach ($localComponents as $lid)
					{
						if (!is_numeric($lid))
						{
							continue;
						}
						// add if not already there
						if (!in_array($lid, $components))
						{
							$components[] = $lid;
						}
					}
				}
				// remove the localComponents
				if (isset($item->localComponents))
				{
					unset($item->localComponents);
				}
				// load it back
				if (isset($components) && ComponentbuilderHelper::checkArray($components))
				{
					// load it back
					$item->components = json_encode(array_values($components));
				}
				// merge the translations where needed
				if (isset($item->translation) && isset($item->localTranslation) 
					&& ComponentbuilderHelper::checkJson($item->translation)
					&& ComponentbuilderHelper::checkJson($item->localTranslation))
				{
					$newTranslations = json_decode($item->translation, true);
					$localTranslations = json_decode($item->localTranslation, true); // always the new format
					$translations = array();
					$pointer = 0;
					$checker = array();
					// okay we have the old format lets merge on that basis
					if (isset($newTranslations['translation']))
					{
						foreach ($localTranslations as $value)
						{
							// only keep old translation if the new does not have this translation & language
							if (!in_array($value['language'], $newTranslations['language']))
							{
								$translations['translation' . $pointer] = array('translation' => $value['translation'], 'language' => $value['language']);
								$pointer++;
							}
						}
						foreach ($newTranslations['translation'] as $nr => $newTrans)
						{
							// now convert the new translation array
							$translations['translation' . $pointer] = array('translation' => $newTrans, 'language' => $newTranslations['language'][$nr]);
							$pointer++;
						}
					}
					// okay this is the new format lets merge on that basis
					elseif (ComponentbuilderHelper::checkArray($newTranslations))
					{
						$translations = $newTranslations;
						$pointer = count($translations);
						foreach ($localTranslations as $value)
						{
							$keepLocal = true;
							foreach ($newTranslations as $newValue)
							{
								// only keep old translation if the new does not have this translation & language
								if ($value['language'] === $newValue['language'])
								{
									$keepLocal = false;
								}
							}
							if ($keepLocal)
							{
								$translations['translation' . $pointer] = array('translation' => $value['translation'], 'language' => $value['language']);
								$pointer++;
							}
						}
					}
					// okay seem to only have local translations
					elseif (ComponentbuilderHelper::checkArray($localTranslations))
					{
						$translations = $localTranslations;
					}
					// only update if we have translations
					if (ComponentbuilderHelper::checkArray($translations))
					{
						$item->translation = json_encode($translations);
					}
				}
				elseif (isset($item->localTranslation) && ComponentbuilderHelper::checkJson($item->localTranslation))
				{
					$item->translation = $item->localTranslation;
				}
				// remove the localTranslation
				if (isset($item->localTranslation))
				{
					unset($item->localTranslation);
				}
			break;
		}
		// final action prep
		switch($action)
		{
			case 'update':
				// set values to follow the update conventions
				if (isset($item->created_by))
				{
					unset($item->created_by);
				}
				$item->modified_by = $this->user->id;
				$item->modified = $this->today;
				// return the item
				return $item;
			break;
			case 'add':
				// remove the ID
				unset($item->id);
				// set values to follow the adding conventions
				$item->created_by = $this->user->id;
				$item->modified_by = $this->user->id;
				$item->modified = $this->today;
				// return the item
				return $item;
			break;
		}
		return false;
	}

	/**
	 * Check if a field has multiple fields
	 * 
	 * @param   string   $typeID  The type ID
	 *
	 * @return  bool true on success
	 * 
	 */
	protected function checkMultiFields($typeID)
	{
		if(isset($this->isMultiple[$typeID]))
		{
			return $this->isMultiple[$typeID];
		}
		elseif ($type = $this->getFieldType($typeID))
		{
			if ('repeatable' === $type || 'subform' === $type )
			{
				$this->isMultiple[$typeID] = true;
			}
			else
			{
				$this->isMultiple[$typeID] = false;
			}
			return $this->isMultiple[$typeID];
		}
		return false;
	}

	/**
	* Move old repeatable field to new subform field, and new table
	*
	* @param array/json    $values      The values to move
	* @param string          $table         The table to move the values to
	* @param string          $type          The type of values
	* @param string          $checker     The key to check if this is a repeatable field
	* @param array          $targets       The target to update and its type
	* @param array          $anchor       The fields to use in anchoring to the new table
	*
	* @return void
	*/
	protected function moveData($values, $table, $type, $checker, $targets, $anchor)
	{
		if (ComponentbuilderHelper::checkJson($values))
		{
			$values = json_decode($values, true);
		}
		// check if this is old values for repeatable fields
		if (ComponentbuilderHelper::checkArray($values) && isset($values[$checker]))
		{
			$values = $this->convertRepeatable($values, $type);
		}
		// now update the fields
		if (ComponentbuilderHelper::checkArray($values))
		{
			foreach ($values as $nr => &$value)
			{
				foreach ($targets as $target => $target_type)
				{
					if (isset($value[$target]))
					{
						// update the target
						if (!ComponentbuilderHelper::checkArray($value[$target]))
						{
							if (isset($this->newID[$target_type][$value[$target]]))
							{
								$value[$target] = $this->newID[$target_type][$value[$target]];
							}
							else
							{
								$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_HAS_ID_MISMATCH_SO_THE_IDS_WAS_REMOVED', ComponentbuilderHelper::safeString($target_type, 'Ww') . '->' . ComponentbuilderHelper::safeString($target, 'Ww') .' in ('.ComponentbuilderHelper::safeString($table, 'w').':'.$item->id.')', $value[$target]), 'warning');
								$value[$target] = '';
							}
						}
						elseif (ComponentbuilderHelper::checkArray($value[$target]))
						{
							// the bucket to load the items back
							$bucket = array();
							foreach ($value[$target] as $id)
							{
								if (!is_numeric($id))
								{
									continue;
								}
								if (isset($this->newID[$target_type][$id]))
								{
									$bucket[] = $this->newID[$target_type][$id];
								}
								else
								{
									$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_HAS_ID_MISMATCH_SO_THE_IDS_WAS_REMOVED', ComponentbuilderHelper::safeString($target_type, 'Ww') . '->' . ComponentbuilderHelper::safeString($target, 'Ww') .' in ('.ComponentbuilderHelper::safeString($table, 'w').':'.$item->id.')', $id), 'warning');
									$bucket[] = '';
								}
							}
							// set ids back
							if (ComponentbuilderHelper::checkArray($bucket))
							{
								$value[$target] = $bucket;
							}
						}
					}
				}
			}
		}
		// we need to move this to the new $table based on anchors
		if (ComponentbuilderHelper::checkArray($anchor))
		{
			$anchorArray = array();
			foreach ($anchor as $name => $id)
			{
				$updated = false;
				if (isset($this->newID[$name]) && isset($this->newID[$name][$id]))
				{
					$id = $this->newID[$name][$id];
					$updated = true;
				}
				// set the values
				$anchorArray[$name] = array('value' => $id, 'updated' => $updated);
			}
			if (!isset($this->dataMover[$table]))
			{
				$this->dataMover[$table] = array();
			}
			// set unique key
			$uniqueKey = md5(serialize($anchorArray));
			if (!isset($this->dataMover[$table][$uniqueKey]))
			{
				$this->dataMover[$table][$uniqueKey] = array();
				$this->dataMover[$table][$uniqueKey]['<(--AnCh0r'] = $anchorArray;
			}
			// add the data to the mover
			$this->dataMover[$table][$uniqueKey][$type] = json_encode($values);
		}
		else
		{
			$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_WE_FAILED_TO_MOVE_BSB', ComponentbuilderHelper::safeString($type, 'Ww') . ' to ('.ComponentbuilderHelper::safeString($table, 'w').')'), 'warning');
		}
	}

	/**
	 * Get the field type
	 * 
	 * @param   string   $id  The field type id
	 *
	 * @return  string field type
	 * 
	 */
	protected function getFieldType($id)
	{
		if (!isset($this->fieldTypes[$id]))
		{
			$properties = ComponentbuilderHelper::getVar('fieldtype', $id, 'id', 'properties');
			if (ComponentbuilderHelper::checkJson($properties))
			{
				$properties = json_decode($properties, true);
				// check if this is old values for repeatable fields
				if (isset($properties['name']))
				{
					$properties = $this->convertRepeatable($properties, 'properties');
				}
				// now check to find type
				foreach ($properties as $property)
				{
					if ('type' === $property['name'])
					{
						if (isset($property['example'])  && ComponentbuilderHelper::checkString($property['example']))
						{
							$this->fieldTypes[$id] = $property['example'];
							break;
						}
					}
				}
			}
			// if not found
			if (!isset($this->fieldTypes[$id]) && $name = ComponentbuilderHelper::getVar('fieldtype', $id, 'id', 'name'))
			{
				$this->fieldTypes[$id] = ComponentbuilderHelper::safeString($name);
			}
		}
		// return the type
		if (isset($this->fieldTypes[$id]))
		{
			return $this->fieldTypes[$id];
		}
		return false;
	}

	/**
	* Update the local item 
	*
	* @param object  $item          The item to update
	* @param string   $type         The type of values
	* @param bool     $canState  The switch to set state
	*
	* @return  mixed           false on failure
	*                                  ID int on success
	*
	**/
	protected function updateLocalItem(&$item, &$type, &$canState)
	{
		// prep the item
		if ($update = $this->prepItem($item, $type, 'update'))
		{
			// remove the published state if not allowed to edit it
			if (!$canState && isset($update->published))
			{
				unset($update->published);
			}
			// update the item
			if ($result = $this->_db->updateObject('#__componentbuilder_' . $type, $update, 'id'))
			{
				// return current ID
				return $update->id;
			}
		}
		return false;
	}

	/**
	* add the local item 
	*
	* @param object $item      The item to update
	* @param string $type      The type of values
	*
	* @return  mixed           false on failure
	*                          ID int on success
	*
	**/
	protected function addLocalItem(&$item, &$type)
	{
		// prep the item
		if ($add = $this->prepItem($item, $type, 'add'))
		{
			// insert/add the item
			if ($result = $this->_db->insertObject('#__componentbuilder_' . $type, $add))
			{
				$aId = $this->_db->insertid();
				// make sure the access of asset is set
				ComponentbuilderHelper::setAsset($aId, $type);
				// set new ID
				return $aId;
			}
		}
		return false;
	}

	/**
	* Get the local item
	*
	* @param object $item      The item to get
	* @param string $type      The type of values
	* @param bool   $retry      The retry switch
	* @param bool   $get        The query get switch
	*
	* @return  mixed           false on failure
	*                          ID int on success
	*
	**/
	protected function getLocalItem(&$item, &$type, $retry = false, $get = 1)
	{
		$query = $this->_db->getQuery(true);
		$query->select('a.*');
		$query->from($this->_db->quoteName('#__componentbuilder_' . $type, 'a'));
		if ($get == 1)
		{
			$query->where($this->_db->quoteName('a.created') . ' = '. $this->_db->quote($item->created));
			$query->where($this->_db->quoteName('a.id') .' = '. (int) $item->id);
		}
		elseif (componentbuilderHelper::checkArray($get))
		{
			foreach ($get as $field)
			{
				if (isset($item->$field))
				{
					// set the value
					$value = $item->$field;
					// check if we have special value
					if ($this->specialValue && ComponentbuilderHelper::checkArray($this->specialValue) && isset($this->specialValue[$field]))
					{
						$value = $this->specialValue[$field];
					}
					// load to query
					if (is_numeric($value) && is_int($value))
					{
						$query->where($this->_db->quoteName('a.' . $field) . ' = '. (int) $value);
					}
					elseif (is_numeric($value) && is_float($value))
					{
						$query->where($this->_db->quoteName('a.' . $field) . ' = '. (float) $value);
					}
					elseif(componentbuilderHelper::checkString($value)) // do not allow empty strings (since it could be major mis match)
					{
						$query->where($this->_db->quoteName('a.' . $field) . ' = '. $this->_db->quote($value));
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
		}
		elseif (isset($item->$get) && componentbuilderHelper::checkString($item->$get)) // do not allow empty strings (since it could be major mis match)
		{
			// set the value
			$value = $item->$get;
			// check if we have special value
			if ($this->specialValue && ComponentbuilderHelper::checkArray($this->specialValue) && isset($this->specialValue[$get]))
			{
				$value = $this->specialValue[$get];
			}
			$query->where($this->_db->quoteName('a.' . $get) . ' = '. $this->_db->quote($value));
		}
		elseif (isset($item->$get) && is_numeric($item->$get))
		{
			// set the value
			$value = $item->$get;
			// check if we have special value
			if ($this->specialValue && ComponentbuilderHelper::checkArray($this->specialValue) && isset($this->specialValue[$get]))
			{
				$value = $this->specialValue[$get];
			}
			// load to query
			if (is_int($value))
			{
				$query->where($this->_db->quoteName('a.' . $get) . ' = '. (int) $value);
			}
			elseif (is_float($value))
			{
				$query->where($this->_db->quoteName('a.' . $get) . ' = '. (float) $value);
			}
			else
			{
				return false; // really not needed but who knows for sure...
			}
		}
		else
		{
			return false;
		}
		// see if we get an item
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			return $this->_db->loadObject();
		}
		elseif ($retry)
		{
			$retryAgain = false;
			$this->specialValue = false;
			// set the getter
			switch ($type)
			{
				case 'admin_fields':
				case 'admin_fields_conditions':
					// get by admin_view (since there should only be one of each name)
					$getter = 'admin_view';
					// update the admin_view with the local ID
					if (isset($this->newID[$getter]) && isset($this->newID[$getter][$item->admin_view]))
					{
						$item->{$getter} = (int) $this->newID[$getter][$item->{$getter}];
					}
					break;
				case 'fieldtype':
					// get by name (since there should only be one of each name)
					$getter = 'name';
					break;
				case 'field':
					// get by name and xml to target correct field
					if ($retry == 2)
					{
						// get by id name..
						$getter = array('name','datatype','store','indexes','null_switch','xml');
					}
					else
					{
						// get by id name..
						$getter = array('name','datatype','store','indexes','null_switch');
						// lets try to add the fieldtype
						if (isset($item->fieldtype) && is_numeric($item->fieldtype) && $item->fieldtype > 0 && isset($this->newID['fieldtype'][$item->fieldtype]) && $this->newID['fieldtype'][$item->fieldtype] > 0)
						{
							$getter[] = 'fieldtype';
							$this->specialValue = array();
							$this->specialValue['fieldtype'] = $this->newID['fieldtype'][$item->fieldtype];
							$retryAgain = 2;
						}
						else
						{
							$getter[] = 'xml';
						}
					}
					break;
				case 'site_view':
				case 'custom_admin_view':
					// get by name, system_name and codename
					$getter = array('name', 'system_name', 'codename');
					// lets try to add the main_get
					if (isset($item->main_get) && is_numeric($item->main_get) && $item->main_get > 0 && isset($this->newID['dynamic_get'][$item->main_get]) && $this->newID['dynamic_get'][$item->main_get] > 0)
					{
						$getter[] = 'main_get';
						$this->specialValue = array();
						$this->specialValue['main_get'] = $this->newID['dynamic_get'][$item->main_get];
					}
					break;
				case 'template':
				case 'layout':
					// get by code name (since there should only be one)
					$getter = 'alias';
					break;
				case 'snippet':
					// get by snippet (since there should only be one snippet like that)
					if ($retry == 2)
					{
						$getter = array('name', 'snippet', 'url', 'type', 'heading');
					}
					else
					{
						// get by id name..
						$getter = array('id', 'name', 'snippet', 'url', 'type', 'heading');
						$retryAgain = 2;
					}
					break;
				case 'custom_code':
					// get by code to insure its correctly matched
					$getter = array('code', 'comment_type', 'target');
					// add some more advanced search
					if (isset($item->path) && ComponentbuilderHelper::checkString($item->path))
					{
						$getter[] = 'path';
					}
					elseif (isset($item->function_name) && ComponentbuilderHelper::checkString($item->function_name))
					{
						$getter[] = 'function_name';
					}
					elseif (isset($item->hashtarget) && ComponentbuilderHelper::checkString($item->hashtarget))
					{
						$getter[] = 'hashtarget';
					}
					break;
				case 'dynamic_get':
					if ($retry == 2)
					{
						// get by name ...
						$getter = array('name', 'gettype', 'main_source'); // risky will look at this again
						// add some more advanced search
						if (isset($item->main_source) && $item->main_source == 1 && isset($item->view_selection) && ComponentbuilderHelper::checkString($item->view_selection))
						{
							$getter[] = 'view_selection';
						}
						elseif (isset($item->main_source) && $item->main_source == 2 && isset($item->db_selection) && ComponentbuilderHelper::checkString($item->db_selection))
						{
							$getter[] = 'db_selection';
						}
						elseif (isset($item->main_source) && $item->main_source == 3 && isset($item->php_custom_get) && ComponentbuilderHelper::checkString($item->php_custom_get))
						{
							$getter[] = 'php_custom_get';
						}
						// add some extra
						if (isset($item->getcustom) && ComponentbuilderHelper::checkString($item->getcustom))
						{
							$getter[] = 'getcustom';
						}
					}
					else
					{
						// get by id name gettype and main_source
						$getter = array('id', 'name', 'gettype', 'main_source'); // risky will look at this again
						$retryAgain = 2;
					}
					break;
				case 'admin_view':
					if ($retry == 2)
					{
						// get by name ...
						$getter = array('name_list', 'name_single', 'short_description', 'system_name'); // risky will look at this again
					}
					else
					{
						// get by id name ...
						$getter = array('id', 'name_list', 'name_single', 'short_description', 'system_name'); // risky will look at this again
						$retryAgain = 2;
					}
					break;
				case 'joomla_component':
					if ($retry == 2)
					{
						// get by name ...
						$getter = array('name', 'name_code', 'short_description', 'author', 'email', 'component_version', 'companyname', 'system_name', 'website', 'bom', 'copyright', 'license'); // risky will look at this again
					}
					else
					{
						// get by id name ...
						$getter = array('id', 'name', 'name_code', 'short_description', 'author', 'component_version', 'companyname', 'system_name'); // risky will look at this again
						$retryAgain = 2;
					}
					break;
				case 'language_translation':
						// get by English translation since there should just be one
						$getter = 'entranslation';
					break;
				case 'language':
						// get by language tag since there should just be one
						$getter = 'langtag';
					break;
				default:
					// can't be found so return false
					return false;
					break;
			}
			// we try again
			return $this->getLocalItem($item, $type, $retryAgain, $getter);
		}
		return false;
	}

	/**
	* Save the data from the file to the database
	*
	* @param array  $data The values to save
	*
	* @return  boolean false on failure
	*
	**/
	protected function saveBasic($data)
	{
		// import the data if there is any
		if(ComponentbuilderHelper::checkArray($data['array']))
		{
			// get user object
			$this->user  	= JFactory::getUser();
			// remove header if it has headers
			$id_key 	= $data['target_headers']['id'];
			$published_key 	= $data['target_headers']['published'];
			$ordering_key 	= $data['target_headers']['ordering'];
			// get the first array set
			$firstSet = reset($data['array']);

			// check if first array is a header array and remove if true
			if($firstSet[$id_key] == 'id' || $firstSet[$published_key] == 'published' || $firstSet[$ordering_key] == 'ordering')
			{
				array_shift($data['array']);
			}
			
			// make sure there is still values in array and that it was not only headers
			if(ComponentbuilderHelper::checkArray($data['array']) && $this->user->authorise($this->dataType.'.import', 'com_componentbuilder') && $this->user->authorise('core.import', 'com_componentbuilder'))
			{
				// set target.
				$target	= array_flip($data['target_headers']);
				// set some defaults
				$todayDate	= JFactory::getDate()->toSql();
				// get global action permissions
				$canDo		= ComponentbuilderHelper::getActions($this->dataType);
				$canEdit		= $canDo->get('core.edit');
				$canState		= $canDo->get('core.edit.state');
				$canCreate	= $canDo->get('core.create');
				$hasAlias		= $this->getAliasesUsed($this->dataType);
				// prosses the data
				foreach($data['array'] as $row)
				{
					$found = false;
					if (isset($row[$id_key]) && is_numeric($row[$id_key]) && $row[$id_key] > 0)
					{
						// raw items import & update!
						$query = $this->_db->getQuery(true);
						$query
							->select('version')
							->from($this->_db->quoteName('#__componentbuilder_'.$this->dataType))
							->where($this->_db->quoteName('id') . ' = '. $this->_db->quote($row[$id_key]));
						// Reset the query using our newly populated query object.
						$this->_db->setQuery($query);
						$this->_db->execute();
						$found = $this->_db->getNumRows();
					}
					
					if($found && $canEdit)
					{
						// update item
						$id 		= $row[$id_key];
						$version	= $this->_db->loadResult();
						// reset all buckets
						$query 	= $this->_db->getQuery(true);
						$fields 	= array();
						// Fields to update.
						foreach($row as $key => $cell)
						{
							// ignore column
							if ('IGNORE' == $target[$key])
							{
								continue;
							}
							// update modified
							if ('modified_by' == $target[$key])
							{
								continue;
							}
							// update modified
							if ('modified' == $target[$key])
							{
								continue;
							}
							// update version
							if ('version' == $target[$key])
							{
								$cell = (int) $version + 1;
							}
							// verify publish authority
							if ('published' == $target[$key] && !$canState)
							{
								continue;
							}
							// set to update array
							if(in_array($key, $data['target_headers']) && is_numeric($cell))
							{
								$fields[] = $this->_db->quoteName($target[$key]) . ' = ' . $cell;
							}
							elseif(in_array($key, $data['target_headers']) && is_string($cell))
							{
								$fields[] = $this->_db->quoteName($target[$key]) . ' = ' . $this->_db->quote($cell);
							}
							elseif(in_array($key, $data['target_headers']) && is_null($cell))
							{
								// if import data is null then set empty
								$fields[] = $this->_db->quoteName($target[$key]) . " = ''";
							}
						}
						// load the defaults
						$fields[]	= $this->_db->quoteName('modified_by') . ' = ' . $this->_db->quote($this->user->id);
						$fields[]	= $this->_db->quoteName('modified') . ' = ' . $this->_db->quote($todayDate);
						// Conditions for which records should be updated.
						$conditions = array(
							$this->_db->quoteName('id') . ' = ' . $id
						);
						$query->update($this->_db->quoteName('#__componentbuilder_' . $this->dataType))->set($fields)->where($conditions);
						$this->_db->setQuery($query);
						$this->_db->execute();
					}
					elseif ($canCreate)
					{
						// insert item
						$query = $this->_db->getQuery(true);
						// reset all buckets
						$columns 	= array();
						$values 	= array();
						$version	= false;
						// Insert columns. Insert values.
						foreach($row as $key => $cell)
						{
							// ignore column
							if ('IGNORE' == $target[$key])
							{
								continue;
							}
							// remove id
							if ('id' == $target[$key])
							{
								continue;
							}
							// update created
							if ('created_by' == $target[$key])
							{
								continue;
							}
							// update created
							if ('created' == $target[$key])
							{
								continue;
							}
							// Make sure the alias is incremented
							if ('alias' == $target[$key])
							{
								$cell = $this->getAlias($cell,$this->dataType);
							}
							// update version
							if ('version' == $target[$key])
							{
								$cell = 1;
								$version = true;
							}
							// set to insert array
							if(in_array($key, $data['target_headers']) && is_numeric($cell))
							{
								$columns[] 	= $target[$key];
								$values[] 		= $cell;
							}
							elseif(in_array($key, $data['target_headers']) && is_string($cell))
							{
								$columns[] 	= $target[$key];
								$values[] 		= $this->_db->quote($cell);
							}
							elseif(in_array($key, $data['target_headers']) && is_null($cell))
							{
								// if import data is null then set empty
								$columns[] 	= $target[$key];
								$values[] 		= "''";
							}
						}
						// load the defaults
						$columns[] 	= 'created_by';
						$values[] 		= $this->_db->quote($this->user->id);
						$columns[] 	= 'created';
						$values[] 		= $this->_db->quote($todayDate);
						if (!$version)
						{
							$columns[] 	= 'version';
							$values[] 		= 1;
						}
						// Prepare the insert query.
						$query
							->insert($this->_db->quoteName('#__componentbuilder_'.$this->dataType))
							->columns($this->_db->quoteName($columns))
							->values(implode(',', $values));
						// Set the query using our newly populated query object and execute it.
						$this->_db->setQuery($query);
						$done = $this->_db->execute();
						if ($done)
						{
							$aId = $this->_db->insertid();
							// make sure the access of asset is set
							ComponentbuilderHelper::setAsset($aId,$this->dataType);
						}
					}
					else
					{
						return false;
					}
				}
				return true;
			}
		}
		return false;
	}
	
	protected function getAlias($name,$type = false)
	{
		// sanitize the name to an alias
		if (JFactory::getConfig()->get('unicodeslugs') == 1)
		{
			$alias = JFilterOutput::stringURLUnicodeSlug($name);
		}
		else
		{
			$alias = JFilterOutput::stringURLSafe($name);
		}
		// must be a uniqe alias
		if ($type)
		{
			return $this->getUniqe($alias,'alias',$type);
		}
		return $alias;
	}
	
	/**
	 * Method to generate a uniqe value.
	 *
	 * @param   string  $field name.
	 * @param   string  $value data.
	 * @param   string  $type table.
	 *
	 * @return  string  New value.
	 */
	protected function getUniqe($value,$field,$type)
	{
		// insure the filed is always uniqe
		while (isset($this->uniqeValueArray[$type][$field][$value]))
		{
			$value = JString::increment($value, 'dash');
		}
		$this->uniqeValueArray[$type][$field][$value] = $value;
		return $value;
	}
	
	protected function getAliasesUsed($table)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// first we check if there is a alias column
		$columns = $db->getTableColumns('#__componentbuilder_'.$table);
		if(isset($columns['alias'])){
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('alias')));
			$query->from($db->quoteName('#__componentbuilder_'.$table));
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$aliases = $db->loadColumn();
				foreach($aliases as $alias)
				{
					$this->uniqeValueArray[$table]['alias'][$alias] = $alias;
				}
			}
			return true;
		}
		return false;
	}
}
