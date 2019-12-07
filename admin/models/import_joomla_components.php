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
	protected $getType = NULL;
	protected $dataType = NULL;
	
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
	
	public $canmerge = 1;
	public $postfix = false;
	public $forceUpdate = 0;
	public $hasKey = 0;
	public $sleutle = null;
	public $data = false;
	public $app;

	protected $dir = false;
	protected $target = false;
	protected $newID = array();
	protected $updateAfter = array('field' => array(), 'adminview' => array());
	protected $divergedDataMover = array();
	protected $fieldTypes = array();
	protected $isMultiple = array();
	protected $tableColumns = array();
	protected $fieldImportErrors = array();
	protected $specialValue = false;
	protected $checksum = null;
	protected $checksumURLs = array('vdm' => 'https://raw.githubusercontent.com/vdm-io/JCB-Packages/master/', 'jcb' => 'https://raw.githubusercontent.com/vdm-io/JCB-Community-Packages/master/');
	protected $mustMerge = array('validation_rule', 'fieldtype', 'snippet', 'language', 'language_translation', 'class_extends', 'class_property', 'class_method', 'joomla_plugin_group');

	/**
	 * Import an spreadsheet from either folder, url or upload.
	 *
	 * @return  boolean result of import
	 *
	 */
	public function import()
	{
		// set the state to import
		$this->setState('action', 'import');
		// get App
		$this->app = JFactory::getApplication();
		// get session
		$session = JFactory::getSession();
		// some defaults
		$package = null;
		$continue = false;
		// get import type
		$this->getType = $this->app->input->getString('gettype', NULL);
		// do checksum validation
		$this->checksum = $this->app->input->getString('checksum', NULL);
		// get import type
		$this->dataType = $session->get('dataType_VDM_IMPORTINTO', NULL);
		// if we have no package
		if ($package === null)
		{
			// we must allow unsafe with smart import since it is code being imported.
			if ($this->dataType === 'smart_package')
			{
				$this->allow_unsafe = true;
			}
			// action based on get Type
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
					$package	= $session->get('package', null);
					if (ComponentbuilderHelper::checkJson($package))
					{
						// get package
						$package	= json_decode($package, true);
						// remove zip file
						if (isset($package['packagename']))
						{
							$this->remove($package['packagename']);
						}
						// check if dir is set
						if (isset($package['dir']))
						{
							// set auto loader
							ComponentbuilderHelper::autoLoader('smart');
							// get install folder
							$dir = JFile::stripExt($package['dir']);
							// remove unziped folder
							ComponentbuilderHelper::removeFolder($dir);
						}
					}
					// clear session
					$session->clear('package');
					$session->clear('dataType');
					$session->clear('hasPackage');
					$session->clear('smart_package_info');
					$back = $session->get('backto_VDM_IMPORT', NULL);
					$session->clear('backto_VDM_IMPORT');
					if ($back)
					{
						$this->app->setUserState('com_componentbuilder.redirect_url', 'index.php?option=com_componentbuilder&view='.$back);
					}
					$session->clear('backto_VDM_IMPORT');
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
			if ($this->dataType !== 'smart_package' || !$this->getInfo($package, $session))
			{
				$this->app->setUserState('com_componentbuilder.message', JText::_('COM_COMPONENTBUILDER_THERE_WAS_AN_ERROR_GETTING_THE_PACKAGE_INFO'));
				return false;
			}
			// set package to session
			$package = json_encode($package);
			$session->set('package', $package);
			$session->set('dataType', $this->dataType);
			$session->set('hasPackage', true);
			return true;
		}
		// force update
		$this->forceUpdate = $this->app->input->getInt('force_update', 0);
		// show more information
		$this->moreInfo = $this->app->input->getInt('more_info', 0);
		// allow merge
		$this->canmerge = $this->app->input->getInt('canmerge', 1);
		// has a key
		 $this->hasKey = $this->app->input->getInt('haskey', 0);
		// die sleutle
		$this->sleutle = $this->app->input->getString('sleutle', NULL);
		// try to store/set data
		if (!$this->setData($package))
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
				// does this package pass a checksum
				$checksum = false;
				$checksumStatus = 'warning'; 
				$checksumMessage = JText::_('COM_COMPONENTBUILDER_PLEASE_NOTE_THAT_THIS_PACKAGE_BHAS_NOB_CHECKSUM_VALIDATION');
				// do hash validation here for git repos
				if (ComponentbuilderHelper::checkString($this->checksum) && isset($this->checksumURLs[$this->checksum]))
				{
					// get packages checksums
					$checksums = ComponentbuilderHelper::getFileContents($this->checksumURLs[$this->checksum].'checksum.json');
					if (ComponentbuilderHelper::checkJson($checksums))
					{
						// convert to array
						$checksums = json_decode($checksums, true);
						// get package name
						$packageName = basename($package['dir']);
						// check if package is found
						if (isset($checksums[$packageName]))
						{
							// validate checksum
							if ($checksums[$packageName] === sha1_file($package['dir']))
							{
								$validator = $this->checksumURLs[$this->checksum].str_replace('.zip', '.sha', $packageName);
								$checksumMessage =  JText::sprintf('COM_COMPONENTBUILDER_THIS_PACKAGE_BPASSEDB_THE_CHECKSUM_VALIDATIONBR_BR_SMALLMANUALLY_ALSO_VALIDATE_THAT_THE_CORRECT_CHECKSUM_WAS_USEDSMALLBR_THIS_CHECKSUM_BSB_MUST_BE_THE_SAME_AS_THE_ONE_FOUND_A_S_SA', $checksums[$packageName], 'href="'.$validator.'" target="_blank" title="verify checksum">', $validator);
								$checksumStatus = 'Success';
								$checksum = true;
							}
						}
						// set error
						if (!$checksum)
						{
							$checksumMessage =  JText::_('COM_COMPONENTBUILDER_BBEST_TO_NOT_CONTINUEBBR_YOU_CAN_REFRESH_AND_TRY_AGAINBR_BUT_NOTE_THAT_THIS_PACKAGE_BFAILEDB_CHECKSUM_VALIDATION_THIS_COULD_BE_A_SERIOUS_SECURITY_BREACH_DO_NOT_CONTINUE');
							$checksumStatus = 'error';
						}
					}
					// set error
					else
					{
						$checksumMessage =  JText::_('COM_COMPONENTBUILDER_BBEST_TO_NOT_CONTINUEBBR_WE_COULD_NOT_LOAD_THE_CHECKSUM_FOR_THIS_PACKAGE_AND_SO_NO_VALIDATION_WAS_POSSIBLE_THIS_MAY_BE_DUE_TO_YOUR_NETWORK_OR_A_CHANGE_TO_THAT_PACKAGE_NAME');
						$checksumStatus = 'error';
					}
				}
				// do not have check sum validation
				$this->app->enqueueMessage($checksumMessage, $checksumStatus);
				// get the zip adapter
				$zip = JArchive::getAdapter('zip');
				// set the directory name
				$this->dir = JFile::stripExt($package['dir']);
				// unzip the package
				$zip->extract($package['dir'], $this->dir);
				// check for database file
				$infoFile = $this->dir . '/info.vdm';
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
							$db = 'COM_COMPONENTBUILDER_VJRZDESSMHBTRWFIFTYTWVZEROAENINEKQFLVVXJTMTHREEJTWOIXM';
							$opener = new FOFEncryptAes(base64_decode(JText::sprintf($db, 'QzdmV')), 128);
							$info = rtrim($opener->decryptString($info), "\0");
							$session->set('smart_package_info', $info);
							return true;
						}
					}
				}
				ComponentbuilderHelper::removeFolder($this->dir);
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
		$app = JFactory::getApplication();
		$input = $app->input;

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
		$config = JFactory::getConfig();
		$tmp_dest = $config->get('tmp_path') . '/' . $userfile['name'];
		$tmp_src = $userfile['tmp_name'];

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
		$app = JFactory::getApplication();
		$input = $app->input;

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
		$package['dir'] = $p_dir;
		$package['type'] = $type;

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
		$app = JFactory::getApplication();
		$input = $app->input;

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
		$app = JFactory::getApplication();
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
		
		$config = JFactory::getConfig();
		// set Package Name
		$check['packagename'] = $archivename;
		
		// set directory
		$check['dir'] = $config->get('tmp_path'). '/' .$archivename;
		
		// set type
		$check['type'] = $this->getType;
		
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
		
		$config = JFactory::getConfig();
		$package = $config->get('tmp_path'). '/' .$package;

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
	protected function setData($package)
	{
		$jinput = JFactory::getApplication()->input;
		// set the data based on the type of import being done
		if ('continue-ext' === $this->getType)
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
					$this->dir = JFile::stripExt($package['dir']);
					// check for database file
					$dbFile = $this->dir . '/db.vdm';
					if (!JFile::exists($dbFile))
					{
						// get the zip adapter
						$zip = JArchive::getAdapter('zip');
						// unzip the package
						$zip->extract($package['dir'], $this->dir);
					}
					// check again
					if (JFile::exists($dbFile))
					{
						// load the data
						if ($data = @file_get_contents($dbFile))
						{
							// prep the data
							if ($this->extractData($data))
							{
								if (isset($this->data['joomla_component']) && ComponentbuilderHelper::checkArray($this->data['joomla_component']))
								{
									// save the smart data
									if ($this->saveSmartComponents())
									{
										ComponentbuilderHelper::removeFolder($this->dir);
										return true;
									}
								}
							}
						}
					}
					ComponentbuilderHelper::removeFolder($this->dir);
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
				// set the data global
				$this->data = $data;
				return true;
			}
			$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_HTWODATA_IS_CORRUPTHTWOTHIS_COULD_BE_DUE_TO_BKEY_ERRORB_OR_BROKEN_PACKAGE'), 'error');
			return false;
		}
		$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_HTWODATA_IS_CORRUPTHTWOTHIS_COULD_BE_DUE_TO_BROKEN_PACKAGE'), 'error');
		return false;
	} 
	
	/**
	* Save the smart components
	*
	* @return  boolean false on failure
	*
	**/
	protected function saveSmartComponents()
	{
		// get user object
		$this->user = JFactory::getUser();
		// set some defaults
		$this->today = JFactory::getDate()->toSql();
		// if we can't merge add postfix to name
		if (!$this->canmerge)
		{
			// set some postfix
			$this->postfix = ' ('.ComponentbuilderHelper::randomkey(2).')';
		}
		// the array of tables to store
		$tables = array(
			'validation_rule', 'fieldtype', 'field', 'admin_view', 'snippet', 'dynamic_get', 'custom_admin_view', 'site_view',
			'template', 'layout', 'joomla_component', 'language', 'language_translation', 'custom_code', 'placeholder', 'class_extends',
			'joomla_module', 'joomla_module_files_folders_urls', 'joomla_module_updates',
			'joomla_plugin_group', 'class_property', 'class_method', 'joomla_plugin', 'joomla_plugin_files_folders_urls', 'joomla_plugin_updates',
			'admin_fields', 'admin_fields_conditions', 'admin_fields_relations',  'admin_custom_tabs', 'component_admin_views',
			'component_site_views', 'component_custom_admin_views', 'component_updates', 'component_mysql_tweaks',
			'component_custom_admin_menus', 'component_config', 'component_dashboard', 'component_files_folders',
			'component_placeholders', 'component_modules', 'component_plugins'
		);
		// get prefix
		$prefix = $this->_db->getPrefix();
		// get local tables
		$localTables = $this->_db->getTableList();
		// smart table loop
		foreach ($tables as $table)
		{
			//  only continue the import if the table is available locally
			if (in_array($prefix . 'componentbuilder_' . $table, $localTables))
			{
				// save the table to database
				if (!$this->saveSmartItems($table))
				{
					return false;
				}
			}
			else
			{
				$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_TABLE_BSB_NOT_FOUND_IN_THE_LOCAL_DATABASE_SO_ITS_VALUES_COULD_NOT_BE_IMPORTED_PLEASE_UPDATE_YOUR_JCB_INSTALL_AND_TRY_AGAIN', '#__componentbuilder_' . $table), 'warning');
			}
		}
		// do a after all run on all items that need it
		$this->updateAfterAll();
		// finally move the old datasets
		$this->moveDivergedData();
		// lets move all the files to its correct location
		if (!$this->moveSmartStuff())
		{
			return false;
		}
		return true;
	}

	/**
	* Save the smart items
	*
	* @param string  $table   The table
	*
	* @return  boolean false on failure
	*
	**/
	public function saveSmartItems($table)
	{
		if (isset($this->data[$table]) && ComponentbuilderHelper::checkArray($this->data[$table]))
		{
			// add pre import event
			$this->preImportEvent($table);
			// get global action permissions
			$canDo = ComponentbuilderHelper::getActions($table);
			$canEdit = $canDo->get('core.edit');
			$canState = $canDo->get('core.edit.state');
			$canCreate = $canDo->get('core.create');
			// check if we should allow merge of local values
			$canmerge = $this->allowMerge($table);
			// set id keeper
			if (!isset($this->newID[$table]))
			{
				$this->newID[$table] = array();
			}
			foreach ($this->data[$table] as $item)
			{
				$oldID = (int) $item->id;
				// first check if exist
				if ($canmerge && ($local = $this->getLocalItem($item, $table, 1)) !== false)
				{
					// display more import info
					if ($this->moreInfo)
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_WAS_FOUND', $table.' id:'.$oldID . '->' . $local->id), 'success');
					}
					$dbDate = strtotime($item->modified);
					$localDate = strtotime($local->modified);
					// okay we have it local (check if the version is newer)
					if ($this->forceUpdate == 1 || $dbDate > $localDate)
					{
						// add some local values to item to combine
						if ($table === 'language_translation')
						{
							$item->localComponents = $local->components;
							$item->localTranslation = $local->translation;
						}
						// make sure we have the correct ID set
						$item->id = $local->id;
						// yes it is newer, lets update (or is being forced)
						if ($canEdit && ($id = $this->updateLocalItem($item, $table, $canState)) !== false)
						{
							// we had success in
							$this->newID[$table][$oldID] = (int) $local->id;
							// display more import info
							if ($this->moreInfo)
							{
								$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_HAS_BEEN_UPDATED', $table.' id:'.$oldID . '->' . $id), 'success');
							}
						}
						else
						{
							$notice = '!';
							if (!$canEdit)
							{
								$notice = JText::sprintf("COM_COMPONENTBUILDER__SINCE_YOU_DONT_HAVE_PERMISSION_TO_EDIT_S", $table);
							}
							$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_COULD_NOT_BE_IMPORTEDS', $table.' id:'.$oldID, $notice), 'error');
						}
					}
					// insure to load the local ID to link imported values with it
					if (!isset($this->newID[$table][$oldID]))
					{
						$this->newID[$table][$oldID] = (int) $local->id;
					}
				}
				elseif ($canCreate && ($id = $this->addLocalItem($item, $table)) !== false)
				{
					// not found in local db so add
					$this->newID[$table][$oldID] = (int) $id;
					// display more import info
					if ($this->moreInfo)
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_HAS_BEEN_IMPORTED', $table.' id:'.$oldID . '->' . $id), 'success');
					}
				}
				else
				{
					$notice = '!';
					if (!$canCreate)
					{
						$notice = JText::sprintf("COM_COMPONENTBUILDER__SINCE_YOU_DONT_HAVE_PERMISSION_TO_CREATE_S", $table);
					}
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSB_COULD_NOT_BE_IMPORTEDS', $table.' id:'.$oldID, $notice), 'error');
				}
			}
		}
		return true;
	}

	/**
	* Check if this table needs some house cleaning before we import the data
	*
	* @return  void
	*
	**/
	protected function preImportEvent($table)
	{
		// if this is custom code table
		// remove all custom code linked to these components
		// since some code may have been removed and changed
		// best unpublish all and let the import publish those still active
		if ('custom_code' === $table && isset($this->newID['joomla_component']) && ComponentbuilderHelper::checkArray($this->newID['joomla_component']))
		{
			$query = $this->_db->getQuery(true);
			// Field to update.
			$fields = array(
			    $this->_db->quoteName('published') . ' = 0'
			);

			// Conditions for which records should be updated.
			$conditions = array(
			    $this->_db->quoteName('component') . ' IN (' . implode(', ', array_values($this->newID['joomla_component'])) . ')'
			);

			$query->update($this->_db->quoteName('#__componentbuilder_custom_code'))->set($fields)->where($conditions);

			$this->_db->setQuery($query);
			$this->_db->execute();
		}
	}

	/**
	* Check if we should allow merge for this table
	*
	* @return  boolean
	*
	**/
	protected function allowMerge($table)
	{
		if ($this->canmerge == 1 || in_array($table, $this->mustMerge))
		{
			return true;
		}
		return false;
	}

	/**
	* Move the smart content (files & folders) into place
	*
	* @return  boolean false on failure
	*
	**/
	protected function moveSmartStuff()
	{
		// make sure to first unlock files
		$this->unLockFiles();
		// set params
		$params = JComponentHelper::getParams('com_componentbuilder');
		// set custom folder path
		$customPath = str_replace('//', '/', $params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom'));
		$imagesPath = str_replace('//', '/', JPATH_SITE . '/images');
		$success = true;
		// check if we have custom files
		$customDir = str_replace('//', '/', $this->dir . '/custom');
		if (JFolder::exists($customDir))
		{
			// great we have some custom stuff lets move it
			if (!JFolder::copy($customDir, $customPath,'',true))
			{
				$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_BCUSTOM_FILESB_NOT_MOVED_TO_CORRECT_LOCATION'), 'error');
				$success = false;
			}
			// display more import info
			elseif ($this->moreInfo)
			{
				$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_SOME_BCUSTOM_FILESB_WERE_MOVED_TO_BSB', $customPath), 'success');
			}
		}
		// check if we have images
		$imageDir = str_replace('//', '/', $this->dir . '/images');
		if (JFolder::exists($imageDir))
		{
			// great we have some images lets move them
			if (!JFolder::copy($imageDir, $imagesPath,'',true))
			{
				$this->app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_BIMAGESB_NOT_MOVED_TO_CORRECT_LOCATION'), 'error');
				$success = false;
			}
			// display more import info
			elseif ($this->moreInfo)
			{
				$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_SOME_BIMAGESB_WERE_MOVED_TO_BSB', $imagesPath), 'success');
			}
		}
		// now move the dynamic files if found
		$dynamicDir = str_replace('//', '/', $this->dir . '/dynamic');
		if (JFolder::exists($dynamicDir))
		{
			// get a list of folders
			$folders = JFolder::folders($dynamicDir);
			// check if we have files
			if(ComponentbuilderHelper::checkArray($folders))
			{
				foreach ($folders as $folder)
				{
					$destination = $this->setDynamicPath($folder);
					$fullPath = str_replace('//', '/', $dynamicDir . '/' . $folder);
					if (!JFolder::exists($fullPath) || !JFolder::copy($fullPath, $destination,'',true))
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FOLDER_BSB_WAS_NOT_MOVED_TO_BSB', $folder, $destination), 'error');
						$success = false;
					}
					// display more import info
					elseif ($this->moreInfo)
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FOLDER_BSB_WAS_MOVED_TO_BSB', $folder, $destination), 'success');
					}
				}
			}
			// get a list of files
			$files = JFolder::files($dynamicDir);
			// check if we have files
			if(ComponentbuilderHelper::checkArray($files))
			{
				foreach ($files as $file)
				{
					$destination = $this->setDynamicPath($file);
					$fullPath = str_replace('//', '/', $dynamicDir . '/' . $file);
					if (!JFile::exists($fullPath) || !JFile::copy($fullPath, $destination))
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FILE_BSB_WAS_NOT_MOVED_TO_BSB', $file, $destination), 'error');
						$success = false;
					}
					// display more import info
					elseif ($this->moreInfo)
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FILE_BSB_WAS_MOVED_TO_BSB', $file, $destination), 'success');
					}
				}
			}
		}
		return $success;
	}

	/**
	* Method to unlock all files
	*
	* @return void
	*/
	protected function unLockFiles()
	{
		// lock the data if set
		if(ComponentbuilderHelper::checkString($this->sleutle) && strlen($this->sleutle) == 32)
		{
			$unlocker = new FOFEncryptAes($this->sleutle, 128);
			// we must first store the current working directory
			$joomla = getcwd();
			// to avoid that it decrypt the db and info file again we must move per/folder
			$folders = array('images', 'custom', 'dynamic');
			// loop the folders
			foreach ($folders as $folder)
			{
				$subPath = str_replace('//', '/', $this->dir . '/' . $folder);
				// go to the package sub folder if found
				if (JFolder::exists($subPath))
				{
					$this->unlock($subPath, $unlocker);
				}
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
					// in case file could not be unlocked
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FILE_BSB_COULD_NOT_BE_UNLOCKED', $file), 'error');
				}
				// display more import info
				elseif ($this->moreInfo)
				{
					$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FILE_BSB_WAS_SUCCESSFULLY_UNLOCKED', $file),  'success');
				}
			}
		}
	}

	/**
	* Update some items after all
	*
	* @return  void
	*
	**/
	public function updateAfterAll()
	{
		// update the fields
		if (isset($this->updateAfter['field']) && ComponentbuilderHelper::checkArray($this->updateAfter['field']))
		{
			// update repeatable
			foreach ($this->updateAfter['field'] as $field => $action)
			{
				if ('add' === $action && isset($this->newID['field'][$field]))
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
								if (isset($this->newID['field'][(int) $id]))
								{
									$bucket[] = $this->newID['field'][(int) $id];
								}
								else
								{
									$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BMULTIPLE_FIELD_REPEATABLE_MODEB_IDS_MISMATCH_IN_BFIELDSB_AND_WAS_EMREMOVEDEM_FROM_THE_FIELD', $id, $field), 'warning');
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
		if (isset($this->updateAfter['adminview']) && ComponentbuilderHelper::checkArray($this->updateAfter['adminview']))
		{
			// update the addlinked_views
			foreach ($this->updateAfter['adminview'] as $adminview => $action)
			{
				if ('add' === $action && isset($this->newID['admin_view'][(int) $adminview]))
				{
					$adminview = $this->newID['admin_view'][(int) $adminview];
				}
				// get the field from db
				if ($addlinked_views = ComponentbuilderHelper::getVar('admin_view', $adminview, 'id', 'addlinked_views'))
				{
					if (ComponentbuilderHelper::checkJson($addlinked_views))
					{
						$addlinked_views = json_decode($addlinked_views, true);
						// convert Repeatable Fields
						if (ComponentbuilderHelper::checkArray($addlinked_views) && isset($addlinked_views['adminview']))
						{
							$addlinked_views = ComponentbuilderHelper::convertRepeatable($addlinked_views, 'addlinked_views');
						}
						// update the view IDs
						if (ComponentbuilderHelper::checkArray($addlinked_views))
						{
							// only update the view IDs
							$addlinked_views = $this->updateSubformIDs($addlinked_views, 'admin_view', array('adminview' => 'admin_view'));
						}
						// update the fields
						$object = new stdClass;
						$object->id = $adminview;
						$object->addlinked_views = json_encode($addlinked_views, JSON_FORCE_OBJECT);
						// update the admin view
						$this->_db->updateObject('#__componentbuilder_admin_view', $object, 'id');
					}
				}
			}
		}
		// update the joomla_component dashboard
		if (isset($this->updateAfter['joomla_component']) && ComponentbuilderHelper::checkArray($this->updateAfter['joomla_component']))
		{
			// update dashboard of the components
			foreach ($this->updateAfter['joomla_component'] as $component => $action)
			{
				if ('add' === $action && isset($this->newID['joomla_component'][(int) $component]))
				{
					$component = $this->newID['joomla_component'][(int) $component];
				}
				// get the dashboard from db
				if ($dashboard = ComponentbuilderHelper::getVar('joomla_component', $component, 'id', 'dashboard'))
				{
					if (ComponentbuilderHelper::checkString($dashboard))
					{
						// get id
						$id = (int) preg_replace("/[^0-9]/", "", $dashboard);
						// update the value
						$update = false;
						// admin_view
						if ((strpos($dashboard, 'A') !== false || strpos($dashboard, 'a') !== false) && isset($this->newID['admin_view'][$id]))
						{
							// set the new value
							$dashboard = 'A_' . $this->newID['admin_view'][$id];
							// update the value
							$update = true;
						}
						// custom_admin_view
						elseif ((strpos($dashboard, 'C') !== false || strpos($dashboard, 'c') !== false) && isset($this->newID['custom_admin_view'][$id]))
						{
							// set the new value
							$dashboard = 'C_' . $this->newID['custom_admin_view'][$id];
							// update the value
							$update = true;
						}
						// did we get a new value
						if ($update)
						{
							// now update the joomla_component dashboard value
							$object = new stdClass;
							$object->id = (int) $component;
							$object->dashboard = $dashboard;
							// update the admin view
							$this->_db->updateObject('#__componentbuilder_joomla_component', $object, 'id');
						}
					}
				}
			}
		}
		// update the admin_fields_relations
		if (isset($this->updateAfter['relations']) && ComponentbuilderHelper::checkArray($this->updateAfter['relations']))
		{
			// update repeatable
			foreach ($this->updateAfter['relations'] as $relation => $action)
			{
				// check if we must update this relation
				$update = false;
				if ('add' === $action && isset($this->newID['admin_fields_relations'][$relation]))
				{
					$relation = $this->newID['admin_fields_relations'][$relation];
				}
				// get the set relation from db
				if ($addrelations = ComponentbuilderHelper::getVar('admin_fields_relations', $relation, 'id', 'addrelations'))
				{
					if (ComponentbuilderHelper::checkJson($addrelations))
					{
						$addrelations = json_decode($addrelations, true);
						if (ComponentbuilderHelper::checkArray($addrelations))
						{
							foreach ($addrelations as $nr => &$value)
							{
								// reset the buckets
								$bucket = array();
								// get fields
								$found = ComponentbuilderHelper::getAllBetween($value['set'], '[field=', ']');
								// if found
								if (ComponentbuilderHelper::checkArray($found))
								{
									$bucket[] = $found;
								}
								// get fields
								$found = ComponentbuilderHelper::getAllBetween($value['set'], '$item->{', '}');
								// if found
								if (ComponentbuilderHelper::checkArray($found))
								{
									$bucket[] = $found;
								}
								// check if we have values
								if (ComponentbuilderHelper::checkArray($bucket))
								{
									$fields = ComponentbuilderHelper::mergeArrays($bucket);
									// reset the buckets
									$bucket = array();
									if (ComponentbuilderHelper::checkArray($fields))
									{
										foreach ($fields as $field)
										{
											if (isset($this->newID['field'][(int) $field]))
											{
												$bucket['[field=' . (int) $field . ']'] = '[field=' . (int) $this->newID['field'][(int) $field] . ']';
												$bucket['$item->{' . (int) $field . '}'] = '$item->{' . (int) $this->newID['field'][(int) $field] . '}';
											}
											else
											{
												$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BADMIN_FIELDS_RELATIONSB_IDS_MISMATCH_IN_BFIELDSB_AND_WAS_NOT_UPDATED_IN_THE_CUSTOM_CODE', $relation, $field), 'warning');
											}
										}
										// check if we have a bucket of values to update
										if (ComponentbuilderHelper::checkArray($bucket))
										{
											$value['set'] = str_replace(array_keys($bucket), array_values($bucket), $value['set']);
											$update = true;
										}
									}
								}
							}
							// update only if needed
							if ($update)
							{
								$object = new stdClass;
								$object->id = $relation;
								$object->addrelations = json_encode($addrelations, JSON_FORCE_OBJECT);
								// update the field
								$this->_db->updateObject('#__componentbuilder_admin_fields_relations', $object, 'id');
							}
						}
					}
				}
			}
		}
	}

	/**
	* Moving of diverged data
	*
	* @return  void
	*
	**/
	public function moveDivergedData()
	{
		// check if there is data to move
		if (ComponentbuilderHelper::checkArray($this->divergedDataMover))
		{
			foreach($this->divergedDataMover as $table => $values)
			{
				foreach($values as $value)
				{
					// first check if exist (only add if it does not)
					if (!$this->getLocalItem($value, $table, 1, 1, true))
					{
						// add the diverged data
						$this->addLocalItem($value, $table, true);
					}
				}
			}
		}
	}

	/**
	* Update Many Subform IDs
	*
	* @param array           $values      The values to update the IDs in
	* @param string          $table         The table these values belong to
	* @param array          $targets       The target to update and its type
	*
	* @return void
	*/
	protected function updateSubformsIDs(&$item, $table, $targets)
	{
		// update the repeatable fields
		foreach ($targets as  $field => $targetArray)
		{
			if (isset($item->{$field}) && ComponentbuilderHelper::checkJson($item->{$field}))
			{
				$updateArray = json_decode($item->{$field}, true);
				if (ComponentbuilderHelper::checkArray($updateArray))
				{
					// load it back
					$item->{$field} = json_encode($this->updateSubformIDs($updateArray, $table, $targetArray), JSON_FORCE_OBJECT);
				}
			}
		}
	}

	/**
	* Update One Subform IDs
	*
	* @param array           $values      The values to update the IDs in
	* @param string          $table         The table these values belong to
	* @param array          $targets       The target to update and its type
	*
	* @return void
	*/
	protected function updateSubformIDs($values, $table, $targets)
	{
		$isJson = false;
		if (ComponentbuilderHelper::checkJson($values))
		{
			$values = json_decode($values, true);
			$isJson = true;
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
						$value = $this->setNewID($value, $target, $target_type, $table);
					}
				}
			}
		}
		if ($isJson)
		{
			return json_encode($values, JSON_FORCE_OBJECT);
		}
		return $values;
	}

	/**
	 * Set the new ID
	 *
	 * @param array          $item        The values to update the IDs in
	 * @param string         $target      The target field
	 * @param string         $type        The table of that field
	 * @param string         $table       The table these values belong to
	 *
	 * @return  boolean  True on success
	 *
	 */
	protected function setNewID($item, $target, $type, $table)
	{
		$isJson = false;
		if (ComponentbuilderHelper::checkJson($item))
		{
			$item = json_decode($item, true);
			$isJson = true;
		}
		if (ComponentbuilderHelper::checkArray($item) && isset($item[$target]))
		{
			// set item ID
			$itemId = (isset($item['id'])) ? $item['id'] :  'newItem';
			// check if it is json
			$isJsonTarget = false;
			if (ComponentbuilderHelper::checkJson($item[$target]))
			{
				$item[$target] = json_decode($item[$target], true);
				$isJsonTarget = true;
			}
			// update the target
			if (ComponentbuilderHelper::checkString($item[$target]) || is_numeric($item[$target]))
			{
				if ($item[$target] == 0)
				{
					$item[$target] = '';
				}
				elseif (isset($this->newID[$type][(int) $item[$target]]))
				{
					$item[$target] = $this->newID[$type][(int) $item[$target]];
				}
				else
				{
					$this->enqueueIdMismatchMessage($item[$target], $itemId, $target, $type, $table);
					$item[$target] = '';
				}
			}
			elseif (ComponentbuilderHelper::checkArray($item[$target]))
			{
				// the bucket to load the items back
				$bucket = array();
				foreach ($item[$target] as $nr => $id)
				{
					if ($id == 0)
					{
						continue;
					}
					elseif ((ComponentbuilderHelper::checkString($id) || is_numeric($id)) && isset($this->newID[$type][(int) $id]))
					{
						$bucket[] = $this->newID[$type][(int) $id];
					}
					else
					{
						$this->enqueueIdMismatchMessage($id, $itemId, $target, $type, $table);
					}
				}
				// set ids back
				if (ComponentbuilderHelper::checkArray($bucket))
				{
					$item[$target] = $bucket;
				}
			}
			// convert back to json
			if ($isJsonTarget)
			{
				$item[$target] = json_encode($item[$target], JSON_FORCE_OBJECT);
			}
		}
		elseif (ComponentbuilderHelper::checkObject($item) && isset($item->{$target}))
		{
			// set item ID
			$itemId = (isset($item->id)) ? $item->id : 'newItem';
			// check if it is json
			$isJsonTarget = false;
			if (ComponentbuilderHelper::checkJson($item->{$target}))
			{
				$item->{$target} = json_decode($item->{$target}, true);
				$isJsonTarget = true;
			}
			// update the target
			if (ComponentbuilderHelper::checkString($item->{$target}) || is_numeric($item->{$target}))
			{
				if ($item->{$target} == 0)
				{
					$item->{$target} = '';
				}
				elseif (isset($this->newID[$type][(int) $item->{$target}]))
				{
					$item->{$target} = $this->newID[$type][(int) $item->{$target}];
				}
				else
				{
					$this->enqueueIdMismatchMessage($item->{$target}, $itemId, $target, $type, $table);
					$item->{$target} = '';
				}
			}
			elseif (ComponentbuilderHelper::checkArray($item->{$target}))
			{
				// the bucket to load the items back
				$bucket = array();
				foreach ($item->{$target} as $id)
				{
					if ($id == 0)
					{
						continue;
					}
					elseif ((ComponentbuilderHelper::checkString($id) || is_numeric($id)) && isset($this->newID[$type][(int) $id]))
					{
						$bucket[] = $this->newID[$type][(int) $id];
					}
					else
					{
						$this->enqueueIdMismatchMessage($id, $itemId, $target, $type, $table);
						$bucket[] = '';
					}
				}
				// set ids back
				if (ComponentbuilderHelper::checkArray($bucket))
				{
					$item->{$target} = $bucket;
				}
			}
			// convert back to json
			if ($isJsonTarget)
			{
				$item->{$target} = json_encode($item->{$target}, JSON_FORCE_OBJECT);
			}
		}
		// return as json if received as json
		if ($isJson)
		{
			return json_encode($item);
		}
		return $item;
	}

	/**
	 * Set the new ID
	 *
	 * @param int             $id             The field ID
	 * @param int             $itemId      The item ID
	 * @param string         $target      The target field
	 * @param string         $type        The table of that field
	 * @param string         $table       The table these values belong to
	 *
	 * @return  void
	 *
	 */
	protected function enqueueIdMismatchMessage($id, $itemId, $target, $type, $table)
	{
		$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_BSBS_IN_BSB_HAS_ID_MISMATCH_SO_THE_BSB_WAS_REMOVED', ComponentbuilderHelper::safeString($type, 'Ww'), ComponentbuilderHelper::safeString($target, 'Ww') , ComponentbuilderHelper::safeString($table, 'w').':'.$itemId, $type . ':' . $id), 'warning');
	}

	/**
	* Prep the item
	*
	* @param object $item       The item to prep
	* @param string $type        The type of values
	* @param string $action     The action (add/update)
	* @param bool   $diverged  The diverged data switch
	*
	* @return  mixed           false on failure
	*                          object on success
	*
	**/
	protected function prepItem($item, $type, $action, $diverged = false)
	{
		// remove access
		if (isset($item->access))
		{
			unset($item->access);
		}
		// remove metadata
		if (isset($item->metadata))
		{
			unset($item->metadata);
		}
		// remove metadesc
		if (isset($item->metadesc))
		{
			unset($item->metadesc);
		}
		// remove metakey
		if (isset($item->metakey))
		{
			unset($item->metakey);
		}
		// remove not_required
		if (isset($item->not_required))
		{
			unset($item->not_required);
		}
		// actions to effect all
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
			case 'fieldtype':
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'properties' => 'name'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
			break;
			case 'field':
				// update the fieldtype
				if (isset($item->fieldtype) && is_numeric($item->fieldtype) && $item->fieldtype > 0 && isset($this->newID['fieldtype'][(int) $item->fieldtype]))
				{
					$item->fieldtype = $this->newID['fieldtype'][(int) $item->fieldtype];
					// update multi field values
					if ($this->checkMultiFields($item->fieldtype))
					{
						$this->updateAfter['field'][(int) $item->id] = $action; // multi field
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
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->name = $item->name.$this->postfix;
				}
			break;
			case 'dynamic_get':
				// update the view_table_main ID
				if (isset($item->main_source) && $item->main_source == 1)
				{
					$item = $this->setNewID($item, 'view_table_main', 'admin_view', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'join_view_table' => 'view_table',
					'join_db_table' => 'db_table',
					'order' => 'table_key',
					'where' => 'table_key',
					'global' => 'name',
					'filter' => 'filter_type'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => field => type_value
					'join_view_table' => array('view_table' => 'admin_view')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'dynamic_get', $updaterT);
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->name = $item->name.$this->postfix;
				}
			break;
			case 'layout':
			case 'template':
				// update the dynamic_get
				$item = $this->setNewID($item, 'dynamic_get', 'dynamic_get', $type);
				// update the snippet
				$item = $this->setNewID($item, 'snippet', 'snippet', $type);
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->name = $item->name.$this->postfix;
				}
			break;
			case 'custom_admin_view':
			case 'site_view':
				// update the main_get
				$item = $this->setNewID($item, 'main_get', 'dynamic_get', $type);
				// update the dynamic_get
				$item = $this->setNewID($item, 'dynamic_get', 'dynamic_get', $type);
				// update the custom_get
				$item = $this->setNewID($item, 'custom_get', 'dynamic_get', $type);
				// update the snippet
				$item = $this->setNewID($item, 'snippet', 'snippet', $type);
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'ajax_input' => 'value_name',
					'custom_button' => 'name'
				);
				// update the repeatable fields				
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->system_name = $item->system_name.$this->postfix;
				}
			break;
			case 'admin_view':
				// set the getters anchors
				$getter = array('admin_view' => $item->id);
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
					// move the old data
					$this->setDivergedDataMover($item->addfields, 'admin_fields', 'addfields', $getter);
				}
				// remove from this dataset
				unset($item->addfields);
				// update the addlinked_views
				if (isset($item->addlinked_views) && ComponentbuilderHelper::checkJson($item->addlinked_views))
				{
					$this->updateAfter['adminview'][(int) $item->id] = $action; // addlinked_views
				}
				elseif (isset($item->addlinked_views))
				{
					unset($item->addlinked_views);
				}
				// update the addconditions (old dataset)
				if (isset($item->addconditions) && ComponentbuilderHelper::checkJson($item->addconditions))
				{
					// move the old data
					$this->setDivergedDataMover($item->addconditions, 'admin_fields_conditions', 'addconditions', $getter);
				}
				// remove from this dataset
				unset($item->addconditions);
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'ajax_input' => 'value_name',
					'custom_button' => 'name',
					'addtables' => 'table',
					'addlinked_views' => 'adminview',
					'addtabs' => 'name',
					'addpermissions' => 'action'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->system_name = $item->system_name.$this->postfix;
				}
			break;
			case 'joomla_component':
				// update custom dash after
				if (isset($item->dashboard_type) && 2 == $item->dashboard_type)
				{
					// update the custom dash ID
					$this->updateAfter['joomla_component'][(int) $item->id] = $action; // dashboard
				}
				// set the anchors getters
				$getter = array('joomla_component' => $item->id);
				// update the addconfig
				if (isset($item->addconfig) && ComponentbuilderHelper::checkJson($item->addconfig))
				{
					// move the old data
					$this->setDivergedDataMover($item->addconfig, 'component_config', 'addconfig', $getter);
				}
				// remove from this dataset
				unset($item->addconfig);
				// update the addadmin_views
				if (isset($item->addadmin_views) && ComponentbuilderHelper::checkJson($item->addadmin_views))
				{
					// move the old data
					$this->setDivergedDataMover($item->addadmin_views, 'component_admin_views', 'addadmin_views', $getter);
				}
				// remove from this dataset
				unset($item->addadmin_views);
				// update the addcustom_admin_views
				if (isset($item->addcustom_admin_views) && ComponentbuilderHelper::checkJson($item->addcustom_admin_views))
				{
					// move the old data
					$this->setDivergedDataMover($item->addcustom_admin_views, 'component_custom_admin_views', 'addcustom_admin_views', $getter);
				}
				// remove from this dataset
				unset($item->addcustom_admin_views);
				// update the addsite_views
				if (isset($item->addsite_views) && ComponentbuilderHelper::checkJson($item->addsite_views))
				{
					// move the old data
					$this->setDivergedDataMover($item->addsite_views, 'component_site_views', 'addsite_views', $getter);
				}
				// remove from this dataset
				unset($item->addsite_views);
				// update the version_update
				if (isset($item->version_update) && ComponentbuilderHelper::checkJson($item->version_update))
				{
					// move the old data
					$this->setDivergedDataMover($item->version_update, 'component_updates', 'version_update', $getter);
				}
				// remove from this dataset
				unset($item->version_update);
				// update the sql_tweak
				if (isset($item->sql_tweak) && ComponentbuilderHelper::checkJson($item->sql_tweak))
				{
					// move the old data
					$this->setDivergedDataMover($item->sql_tweak, 'component_mysql_tweaks', 'sql_tweak', $getter);
				}
				// remove from this dataset
				unset($item->sql_tweak);
				// update the addcustommenus
				if (isset($item->addcustommenus) && ComponentbuilderHelper::checkJson($item->addcustommenus))
				{
					// move the old data
					$this->setDivergedDataMover($item->addcustommenus, 'component_custom_admin_menus', 'addcustommenus', $getter);
				}
				// remove from this dataset
				unset($item->addcustommenus);
				// update the dashboard_tab
				if (isset($item->dashboard_tab) && ComponentbuilderHelper::checkJson($item->dashboard_tab))
				{
					// move the old data
					$this->setDivergedDataMover($item->dashboard_tab, 'component_dashboard', 'dashboard_tab', $getter);
				}
				// remove from this dataset
				unset($item->dashboard_tab);
				// update the php_dashboard_methods
				if (isset($item->php_dashboard_methods))
				{
					// move the old data
					$this->setDivergedDataMover($item->php_dashboard_methods, 'component_dashboard', 'php_dashboard_methods', $getter);
				}
				// remove from this dataset
				unset($item->php_dashboard_methods);
				unset($item->add_php_dashboard_methods);
				// update the addfiles
				if (isset($item->addfiles) && ComponentbuilderHelper::checkJson($item->addfiles))
				{
					// move the old data
					$this->setDivergedDataMover($item->addfiles, 'component_files_folders', 'addfiles', $getter);
				}
				// remove from this dataset
				unset($item->addfiles);
				// update the addfolders
				if (isset($item->addfolders) && ComponentbuilderHelper::checkJson($item->addfolders))
				{
					// move the old data
					$this->setDivergedDataMover($item->addfolders, 'component_files_folders', 'addfolders', $getter);
				}
				// remove from this dataset
				unset($item->addfolders);
				// update the add_css
				if (isset($item->add_css))
				{
					$item->add_css_admin = $item->add_css;
				}
				// remove from this dataset
				unset($item->add_css);
				// update the css
				if (isset($item->css) && ComponentbuilderHelper::checkString($item->css))
				{
					$item->css_admin = $item->css;
				}
				// remove from this dataset
				unset($item->css);
				// rename sales_server_ftp field
				if (isset($item->sales_server_ftp))
				{
					$item->sales_server = $item->sales_server_ftp;
					unset($item->sales_server_ftp);
				}
				// rename update_server_ftp field
				if (isset($item->update_server_ftp))
				{
					$item->update_server = $item->update_server_ftp;
					unset($item->update_server_ftp);
				}
				// rename export_package_link field
				if (isset($item->export_package_link))
				{
					$item->joomla_source_link = $item->export_package_link;
					unset($item->export_package_link);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addcontributors' => 'name'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->system_name = $item->system_name.$this->postfix;
				}
			break;
			case 'component_admin_views':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addadmin_views' => 'adminview'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addadmin_views' => array('adminview' => 'admin_view')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_admin_views', $updaterT);
			break;
			case 'component_site_views':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addsite_views' => 'siteview'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addsite_views' => array('siteview' => 'site_view')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_site_views', $updaterT);
			break;
			case 'component_custom_admin_views':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addcustom_admin_views' => 'customadminview'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addcustom_admin_views' => array('customadminview' => 'custom_admin_view', 'adminviews' => 'admin_view', 'before' => 'admin_view')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_custom_admin_views', $updaterT);
			break;
			case 'component_updates':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'version_update' => 'version'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
			break;
			case 'component_mysql_tweaks':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'sql_tweak' => 'adminview'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'sql_tweak' => array('adminview' => 'admin_view')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_mysql_tweaks', $updaterT);
			break;
			case 'component_custom_admin_menus':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addcustommenus' => 'name'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addcustommenus' => array('before' => 'admin_view')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_custom_admin_menus', $updaterT);
			break;
			case 'component_config':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addconfig' => 'field'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addconfig' => array('field' => 'field')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_config', $updaterT);
			break;
			case 'component_dashboard':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'dashboard_tab' => 'name'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
			break;
			case 'component_placeholders':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
			break;
			case 'component_modules':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addjoomla_modules' => array('module' => 'joomla_module')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_modules', $updaterT);
			break;
			case 'component_plugins':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'addjoomla_plugins' => array('plugin' => 'joomla_plugin')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'component_plugins', $updaterT);
			break;
			case 'component_files_folders':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_component ID where needed
					$item = $this->setNewID($item, 'joomla_component', 'joomla_component', $type);
				}
				// repeatable fields to update
				$updaterR = array(
					// repeatablefield => checker
					'addfiles' => 'file',
					'addfolders' => 'folder'
				);
				// update the repeatable fields
				$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
			break;
			case 'joomla_module':
				// update the custom_get
				$item = $this->setNewID($item, 'custom_get', 'dynamic_get', $type);
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->system_name = $item->system_name.$this->postfix;
				}
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'fields' => array('field' => 'field')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'joomla_module', $updaterT);
			break;
			case 'joomla_module_files_folders_urls':
			case 'joomla_module_updates':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_module ID where needed
					$item = $this->setNewID($item, 'joomla_module', 'joomla_module', $type);
				}
			break;
			case 'joomla_plugin_group':
				// diverged id already updated
				if (!$diverged)
				{
					// update the class_extends ID where needed
					$item = $this->setNewID($item, 'class_extends', 'class_extends', $type);
				}
			break;
			case 'class_method':
			case 'class_property':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_plugin_group ID where needed
					$item = $this->setNewID($item, 'joomla_plugin_group', 'joomla_plugin_group', $type);
				}
			break;
			case 'joomla_plugin':
				// diverged id already updated
				if (!$diverged)
				{
					// update the class_extends ID where needed
					$item = $this->setNewID($item, 'class_extends', 'class_extends', $type);
					// update the joomla_plugin_group ID where needed
					$item = $this->setNewID($item, 'joomla_plugin_group', 'joomla_plugin_group', $type);
				}
				// if we can't merge add postfix to name
				if ($this->postfix)
				{
					$item->system_name = $item->system_name.$this->postfix;
				}
				// subform fields to target
				$updaterT = array(
					// subformfield => array( field => type_value )
					'fields' => array('field' => 'field'),
					'property_selection' => array('property' => 'class_property'),
					'method_selection' => array('method' => 'class_method')
				);
				// update the subform ids
				$this->updateSubformsIDs($item, 'joomla_plugin', $updaterT);
			break;
			case 'joomla_plugin_files_folders_urls':
			case 'joomla_plugin_updates':
				// diverged id already updated
				if (!$diverged)
				{
					// update the joomla_plugin ID where needed
					$item = $this->setNewID($item, 'joomla_plugin', 'joomla_plugin', $type);
				}
			break;
			case 'custom_code':
				// update the component ID where needed
				$item = $this->setNewID($item, 'component', 'joomla_component', $type);
			break;
			case 'language_translation':
				// update the component ID where needed
				$item = $this->setNewID($item, 'component', 'joomla_component', $type);
				// load the local components if found
				if (isset($item->localComponents) && ComponentbuilderHelper::checkJson($item->localComponents))
				{
					$components = array();
					if (isset($item->components) && ComponentbuilderHelper::checkJson($item->components))
					{
						$components = json_decode($item->components, true);
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
					$item->components = json_encode(array_values($components), JSON_FORCE_OBJECT);
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
						$item->translation = json_encode($translations, JSON_FORCE_OBJECT);
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
				// move entranslation to source
				if (isset($item->entranslation))
				{
					$item->source = $item->entranslation;
					// also remove the old field
					unset($item->entranslation);
				}
			break;
			case 'admin_fields':
			case 'admin_fields_conditions':
			case 'admin_fields_relations':
			case 'admin_custom_tabs':
				// diverged id already updated
				if (!$diverged)
				{
					// update the admin_view ID where needed
					$item = $this->setNewID($item, 'admin_view', 'admin_view', $type);
				}
				$updaterR = array();
				// set the updater
				if ('admin_fields' === $type)
				{
					// repeatable fields to update
					$updaterR = array(
						// repeatablefield => checker
						'addfields' => 'field'
					);
					// subform fields to target
					$updaterT = array(
						// subformfield => field => type_value
						'addfields' => array('field' => 'field')
					);
					// little tweak... oops
					if (isset($item->addconditions))
					{
						unset($item->addconditions);
					}
				}
				elseif ('admin_fields_conditions' === $type)
				{
					// repeatable fields to update
					$updaterR = array(
						// repeatablefield => checker
						'addconditions' => 'target_field'
					);
					// subform fields to target
					$updaterT = array(
						// subformfield => field => type_value
						'addconditions' => array('target_field' => 'field', 'match_field' => 'field')
					);
				}
				elseif ('admin_fields_relations' === $type)
				{
					// subform fields to target
					$updaterT = array(
						// subformfield => field => type_value
						'addrelations' => array('listfield' => 'field', 'joinfields' => 'field')
					);
					// special fix for custom code
					$this->updateAfter['relations'][(int) $item->id] = $action; // addrelations->set
				}

				// update the repeatable fields
				if (isset($updaterR) && ComponentbuilderHelper::checkArray($updaterR))
				{
					$item = ComponentbuilderHelper::convertRepeatableFields($item, $updaterR);
				}
				// update the subform ids
				if (isset($updaterT) && ComponentbuilderHelper::checkArray($updaterT))
				{
					$this->updateSubformsIDs($item, $type, $updaterT);
				}
		}
		// remove all fields/columns not part of the current table
		$this->removingFields($type, $item);
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
				if (isset($item->id))
				{
					unset($item->id);
				}
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
	* remove all fields/columns not part of the current table
	*
	* @param string $type       The table this item belongs to
	* @param object $item      The item to clean
	*
	* @return viod
	*/
	protected function removingFields($type, &$item)
	{
		// get the columns
		$columns = $this->getTableColumns("#__componentbuilder_" . $type);
		if (ComponentbuilderHelper::checkArray($columns))
		{
			foreach ($item as $name => $value)
			{
				if (!isset($columns[$name]))
				{
					// we must show a warning that this field was not imported (but just once)
					if (!isset($this->fieldImportErrors[$type.$name]))
					{
						$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_FIELD_BSB_NOT_FOUND_IN_LOCAL_DATABASE_TABLE_S_SO_IMPORTED_OF_ITS_VALUES_FAILED_PLEASE_UPDATE_YOUR_JCB_INSTALL_AND_TRY_AGAIN', $name, '#__componentbuilder_' . $type), 'warning');
						// make sure the message is not loaded again
						$this->fieldImportErrors[$type.$name] = true;
					}
					// remove the field & value
					unset($item->{$name});
				}
			}
		}
	}

	/**
	* get table columns
	*
	* @param string $table       The table
	*
	* @return array
	*/
	protected function getTableColumns($table)
	{
		// check if the columns are in memory
		if (!isset($this->tableColumns[$table]))
		{
			// get the columns
			$this->tableColumns[$table] = $this->_db->getTableColumns($table);
		}
		return $this->tableColumns[$table];
	}

	/**
	* Set the data that should be moved
	*
	* @param array/json    $values      The values/data to move
	* @param string          $table         The table to move the values to
	* @param string          $type          The type of values
	* @param array          $getters       The get values used to anchor the values to the new table
	*
	* @return bool
	*/
	protected function setDivergedDataMover($values, $table, $type, $getters)
	{
		// we need to move this to the new $table based on anchors
		if (ComponentbuilderHelper::checkArray($getters))
		{
			if (!isset($this->divergedDataMover[$table]))
			{
				$this->divergedDataMover[$table] = array();
			}
			// set unique key
			$uniqueKey = md5(serialize($getters));
			if (!isset($this->divergedDataMover[$table][$uniqueKey]))
			{
				$this->divergedDataMover[$table][$uniqueKey] = new stdClass;
				foreach ($getters as $name => $value)
				{
					$this->divergedDataMover[$table][$uniqueKey]->{$name} = $value;
				}
			}
			// add the data to the mover
			$this->divergedDataMover[$table][$uniqueKey]->{$type} = $values;
			// display more import info
			if ($this->moreInfo)
			{
				$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_WE_SUCCESSFULLY_MOVED_BSB', ComponentbuilderHelper::safeString($type, 'Ww') . ' to ('.ComponentbuilderHelper::safeString($table, 'w').')'), 'success');
			}
			// success
			return true;
		}
		$this->app->enqueueMessage(JText::sprintf('COM_COMPONENTBUILDER_WE_FAILED_TO_MOVE_BSB', ComponentbuilderHelper::safeString($type, 'Ww') . ' to ('.ComponentbuilderHelper::safeString($table, 'w').')'), 'warning');
		// failure
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
					$properties = ComponentbuilderHelper::convertRepeatable($properties, 'properties');
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
	protected function updateLocalItem(&$item, $type, &$canState)
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
				// return success
				return $update->id;
			}
		}
		return false;
	}

	/**
	* add the local item 
	*
	* @param object $item       The item to update
	* @param string $type        The type of values
	* @param bool   $diverged  The diverged data switch
	*
	* @return  mixed           false on failure
	*                          ID int on success
	*
	**/
	protected function addLocalItem(&$item, $type, $diverged = false)
	{
		// prep the item
		if ($add = $this->prepItem($item, $type, 'add', $diverged))
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
	* @param object $item       The item to get
	* @param string $type        The type of values
	* @param bool   $retry        The retry switch
	* @param bool   $get          The query get switch
	* @param bool   $diverged  The diverged data switch
	*
	* @return  mixed           false on failure
	*                          ID int on success
	*
	**/
	protected function getLocalItem($item, $type, $retry = false, $get = 1, $diverged = false)
	{
		$query = $this->_db->getQuery(true);
		$query->select('a.*');
		$query->from($this->_db->quoteName('#__componentbuilder_' . $type, 'a'));
		// only run query if where is set
		$runQuery = false;
		if ($get == 1 && isset($item->created) && isset($item->id) && (isset($item->name) || isset($item->system_name)))
		{
			// to prefent crazy mismatch with old IDs (I know very weired)
			if (isset($item->system_name))
			{
				$query->where($this->_db->quoteName('a.system_name') . ' = '. $this->_db->quote($item->system_name));
			}
			// to prefent crazy mismatch with old IDs (I know very weired)
			if (isset($item->name))
			{
				$query->where($this->_db->quoteName('a.name') . ' = '. $this->_db->quote($item->name));
			}
			// load the created and id
			$query->where($this->_db->quoteName('a.created') . ' = '. $this->_db->quote($item->created));
			$query->where($this->_db->quoteName('a.id') .' = '. (int) $item->id);
			// set to run query
			$runQuery = true;
		}
		elseif (componentbuilderHelper::checkArray($get))
		{
			foreach ($get as $field)
			{
				// set to run query
				$runQuery = true;
				if (isset($item->{$field}))
				{
					// set the value
					$value = $item->{$field};
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
						// do not run query
						$runQuery = false;
					}
				}
				else
				{
					// do not run query
					$runQuery = false;
				}
			}
		}
		elseif (isset($item->{$get}))
		{
			// set to run query
			$runQuery = true;
			// set the value
			$value = $item->{$get};
			// check if we have special value
			if ($this->specialValue && ComponentbuilderHelper::checkArray($this->specialValue) && isset($this->specialValue[$get]))
			{
				$value = $this->specialValue[$get];
			}
			// load to query
			if (is_numeric($value) && is_int($value))
			{
				$query->where($this->_db->quoteName('a.' . $get) . ' = '. (int) $value);
			}
			elseif (is_numeric($value) && is_float($value))
			{
				$query->where($this->_db->quoteName('a.' . $get) . ' = '. (float) $value);
			}
			elseif(componentbuilderHelper::checkString($value)) // do not allow empty strings (since it could be major mis match)
			{
				$query->where($this->_db->quoteName('a.' . $get) . ' = '. $this->_db->quote($value));
			}
			else
			{
				$runQuery = false; // really not needed but who knows for sure...
			}
		}
		// since where has been set run the query
		if ($runQuery)
		{
			// see if we get an item
			$this->_db->setQuery($query);
			$this->_db->execute();
			if ($this->_db->getNumRows())
			{
				return $this->_db->loadObject();
			}
		}
		// retry to get the item
		if ($retry)
		{
			$retryAgain = false;
			$this->specialValue = false;
			// set the getter
			switch ($type)
			{
				case 'admin_fields':
				case 'admin_fields_conditions':
				case 'admin_fields_relations':
				case 'admin_custom_tabs':
					// get by admin_view (since there should only be one of each name)
					$getter = array('admin_view');
					$this->specialValue = array();
					// Yet if diverged it makes sense that the ID is updated.
					if ($diverged)
					{
						$this->specialValue['admin_view'] = (int) $item->admin_view;
					}
					elseif (isset($this->newID['admin_view'][(int) $item->admin_view]))
					{
						$this->specialValue['admin_view'] = $this->newID['admin_view'][(int) $item->admin_view];
					}
					// (TODO) I have seen this happen, seems dangerous! 
					else
					{
						return false;
					}
					break;
				case 'validation_rule':
				case 'fieldtype':
					// get by name (since there should only be one of each name)
					$getter = 'name';
					break;
				case 'field':
					// get by name and xml to target correct field
					if ($retry == 2)
					{
						// get by name + xml...
						$getter = array('name','datatype','store','indexes','null_switch','xml');
						$retryAgain = 3;
					}
					elseif ($retry == 3)
					{
						// get by name + created...
						$getter = array('name','datatype','created');
					}
					else
					{
						// get by name + xml or type..
						$getter = array('name','datatype','store','indexes','null_switch');
						// lets try to add the fieldtype
						if (isset($item->fieldtype) && is_numeric($item->fieldtype) && $item->fieldtype > 0 && isset($this->newID['fieldtype'][(int) $item->fieldtype]) && $this->newID['fieldtype'][(int) $item->fieldtype] > 0)
						{
							$getter[] = 'fieldtype';
							$this->specialValue = array();
							$this->specialValue['fieldtype'] = $this->newID['fieldtype'][(int) $item->fieldtype];
							$retryAgain = 2;
						}
						else
						{
							$getter[] = 'xml';
							$retryAgain = 3;
						}
					}
					break;
				case 'site_view':
				case 'custom_admin_view':
					// get by name, system_name and codename
					$getter = array('name', 'system_name', 'codename');
					// lets try to add the main_get
					if (isset($item->main_get) && is_numeric($item->main_get) && $item->main_get > 0 && isset($this->newID['dynamic_get'][(int) $item->main_get]) && $this->newID['dynamic_get'][(int) $item->main_get] > 0)
					{
						$getter[] = 'main_get';
						$this->specialValue = array();
						$this->specialValue['main_get'] = $this->newID['dynamic_get'][(int) $item->main_get];
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
				case 'placeholder':
					// search for placeholder (since there should only be one)
					$getter = 'target';
					break;
				case 'custom_code':
					// search for custom code
					$getter = array('comment_type', 'target');
					$this->specialValue = array();
					// search for Hash (automation)
					if (isset($item->target) && $item->target == 1)
					{
						$getter[] = 'path';
						$getter[] = 'hashtarget';
						$getter[] = 'component';
						// Yet if diverged it makes sense that the ID is updated.
						if ($diverged)
						{
							// set a special value
							$this->specialValue['component'] = (int) $item->component;
						}
						elseif (isset($this->newID['joomla_component'][(int) $item->component]))
						{
							// set a special value
							$this->specialValue['component'] = $this->newID['joomla_component'][(int) $item->component];
						}
						// (TODO) I have seen this happen, seems dangerous! 
						else
						{
							return false;
						}
					}
					// search for JCB (manual)
					elseif (isset($item->target) && $item->target == 2)
					{
						$getter[] = 'function_name';
					}
					else
					{
						return false;
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
					if ($retry == 3)
					{
						// get by names only
						$getter = array('name', 'name_code', 'system_name');
					}
					elseif ($retry == 2)
					{
						// get by name ...
						$getter = array('name', 'name_code', 'short_description', 'author', 'email', 'component_version', 'companyname', 'system_name', 'website', 'bom', 'copyright', 'license'); 
						$retryAgain = 3;
					}
					else
					{
						// get by id name ...
						$getter = array('id', 'name', 'name_code', 'short_description', 'author', 'component_version', 'companyname', 'system_name');
						$retryAgain = 2;
					}
					break;
				case 'component_admin_views':
				case 'component_site_views':
				case 'component_custom_admin_views':
				case 'component_updates':
				case 'component_mysql_tweaks':
				case 'component_custom_admin_menus':
				case 'component_config':
				case 'component_dashboard':
				case 'component_placeholders':
				case 'component_files_folders':
				case 'component_modules':
				case 'component_plugins':
						// get by joomla_component (since there should only be one of each component)
						$getter = array('joomla_component');
						$this->specialValue = array();
						// Yet if diverged it makes sense that the ID is updated.
						if ($diverged)
						{
							$this->specialValue['joomla_component'] = (int) $item->joomla_component;
						}
						elseif (isset($this->newID['joomla_component'][(int) $item->joomla_component]))
						{
							$this->specialValue['joomla_component'] = $this->newID['joomla_component'][(int) $item->joomla_component];
						}
						// (TODO) I have seen this happen, seems dangerous! 
						else
						{
							return false;
						}
					break;
				case 'language_translation':
						// get by source translation since there should just be one
						$getter = 'source';
						if (isset($item->entranslation))
						{
							$item->source = $item->entranslation;
						}
					break;
				case 'language':
					// get by language tag since there should just be one
					$getter = 'langtag';
					break;
				case 'joomla_module':
					// get
					if ($retry == 3)
					{
						// get by names, exteneded and group only
						$getter = array('name', 'system_name');
					}
					elseif ($retry == 2)
					{
						// get by description
						$getter = array('name', 'system_name', 'description'); 
						$retryAgain = 3;
					}
					else
					{
						// get by id
						$getter = array('id', 'name', 'system_name');
						$retryAgain = 2;
					}
					break;
				case 'joomla_module_files_folders_urls':
				case 'joomla_module_updates':
					// get by admin_view (since there should only be one of each name)
					$getter = array('joomla_module');
					$this->specialValue = array();
					// Yet if diverged it makes sense that the ID is updated.
					if ($diverged)
					{
						$this->specialValue['joomla_module'] = (int) $item->joomla_module;
					}
					elseif (isset($this->newID['joomla_module'][(int) $item->joomla_module]))
					{
						$this->specialValue['joomla_module'] = $this->newID['joomla_module'][(int) $item->joomla_module];
					}
					// (TODO) I have seen this happen, seems dangerous! 
					else
					{
						return false;
					}
					break;
				case 'joomla_plugin':
					// get
					if ($retry == 3)
					{
						// get by names, exteneded and group only
						$getter = array('name', 'system_name', 'class_extends', 'joomla_plugin_group');
					}
					elseif ($retry == 2)
					{
						// get by description
						$getter = array('name', 'system_name', 'class_extends', 'joomla_plugin_group', 'description'); 
						$retryAgain = 3;
					}
					else
					{
						// get by id
						$getter = array('id', 'name', 'system_name', 'class_extends', 'joomla_plugin_group');
						$retryAgain = 2;
					}
					$this->specialValue = array();
					// Yet if diverged it makes sense that the ID is updated.
					if ($diverged)
					{
						$this->specialValue['class_extends'] = (int) $item->class_extends;
						$this->specialValue['joomla_plugin_group'] = (int) $item->joomla_plugin_group;
					}
					elseif (isset($this->newID['class_extends'][(int) $item->class_extends]) && isset($this->newID['joomla_plugin_group'][(int) $item->joomla_plugin_group]))
					{
						$this->specialValue['class_extends'] = $this->newID['class_extends'][(int) $item->class_extends];
						$this->specialValue['joomla_plugin_group'] = $this->newID['joomla_plugin_group'][(int) $item->joomla_plugin_group];
					}
					// (TODO) I have seen this happen, seems dangerous! 
					else
					{
						return false;
					}
					break;
				case 'joomla_plugin_files_folders_urls':
				case 'joomla_plugin_updates':
					// get by admin_view (since there should only be one of each name)
					$getter = array('joomla_plugin');
					$this->specialValue = array();
					// Yet if diverged it makes sense that the ID is updated.
					if ($diverged)
					{
						$this->specialValue['joomla_plugin'] = (int) $item->joomla_plugin;
					}
					elseif (isset($this->newID['joomla_plugin'][(int) $item->joomla_plugin]))
					{
						$this->specialValue['joomla_plugin'] = $this->newID['joomla_plugin'][(int) $item->joomla_plugin];
					}
					// (TODO) I have seen this happen, seems dangerous! 
					else
					{
						return false;
					}
					break;
				case 'joomla_plugin_group':
					// get by name since there should just be one
					$getter = array('name', 'class_extends');
					$this->specialValue = array();
					// Yet if diverged it makes sense that the ID is updated.
					if ($diverged)
					{
						$this->specialValue['class_extends'] = (int) $item->class_extends;
					}
					elseif (isset($this->newID['class_extends'][(int) $item->class_extends]))
					{
						$this->specialValue['class_extends'] = $this->newID['class_extends'][(int) $item->class_extends];
					}
					// (TODO) I have seen this happen, seems dangerous! 
					else
					{
						return false;
					}
					break;
				case 'class_extends':
				case 'class_method':
				case 'class_property':
					// get by name since there should just be one
					$getter = array('name', 'extension_type');
					// Yet if diverged it makes sense that the ID is updated.
					if ('plugins' === $item->extension_type && isset($item->joomla_plugin_group))
					{
						$getter[] = 'joomla_plugin_group';
						$this->specialValue = array();
						if ($diverged)
						{
							$this->specialValue['joomla_plugin_group'] = (int) $item->joomla_plugin_group;
						}
						elseif (isset($this->newID['joomla_plugin_group'][(int) $item->joomla_plugin_group]))
						{
							$this->specialValue['joomla_plugin_group'] = $this->newID['joomla_plugin_group'][(int) $item->joomla_plugin_group];
						}
						// (TODO) I have seen this happen, seems dangerous! 
						else
						{
							return false;
						}
					}
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
	 * Update constant path with real full path value
	 * 
	 * @param   string   $path  The full path
	 *
	 * @return  string   The updated path
	 * 
	 */
	protected function setFullPath($path)
	{
		return str_replace(array_keys(ComponentbuilderHelper::$constantPaths), array_values(ComponentbuilderHelper::$constantPaths), $path);
	}

	/**
	 * Convert the name to a path
	 * 
	 * @param   string   $path  The path name
	 *
	 * @return  string   The full path	 * 
	 */
	protected function setDynamicPath($path)
	{
		// now convert to path
		$path = str_replace('__v_d_m__', '/', $path);
		// add the full path if possible
		return str_replace('//', '/', $this->setFullPath($path));
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
