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

	@package		Component Builder
	@subpackage		componentbuilder.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * ###Component### ###View### Model
 */
class ###Component###Model###View### extends JModelLegacy
{
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
	protected $_context = 'com_###component###.import';
	
	/**
	 * Import Settings
	 */
	protected $getType 	= NULL;
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

		$this->setState('message', $app->getUserState('com_###component###.message'));
		$app->setUserState('com_###component###.message', '');

		// Recall the 'Import from Directory' path.
		$path = $app->getUserStateFromRequest($this->_context . '.import_directory', 'import_directory', $app->get('tmp_path'));
		$this->setState('import.directory', $path);
		// set uploading values
		$this->use_streams = false;
		$this->allow_unsafe = false;
		$this->safeFileOptions = array();
		parent::populateState();
	}

	/**
	 * Import an spreadsheet from either folder, url or upload.
	 *
	 * @return  boolean result of import
	 *
	 */
	public function import()
	{
		$this->setState('action', 'import');
		$app 		= JFactory::getApplication();
		$session 	= JFactory::getSession();
		$package 	= null;
		$continue	= false;
		// get import type
		$this->getType = $app->input->getString('gettype', NULL);
		// get import type
		$this->dataType	= $session->get('dataType_VDM_IMPORTINTO', NULL);

		if ($package === null)
		{
			switch ($this->getType)
			{
				case 'folder':
					// Remember the 'Import from Directory' path.
					$app->getUserStateFromRequest($this->_context . '.import_directory', 'import_directory');
					$package = $this->_getPackageFromFolder();
					break;

				case 'upload':
					$package = $this->_getPackageFromUpload();
					break;

				case 'url':
					$package = $this->_getPackageFromUrl();
					break;

				case 'continue':
					$continue 	= true;
					$package	= $session->get('package', null);
					$package	= json_decode($package, true);
					// clear session
					$session->clear('package');
					$session->clear('dataType');
					$session->clear('hasPackage');
					break;

				default:
					$app->setUserState('com_###component###.message', JText::_('COM_###COMPONENT###_IMPORT_NO_IMPORT_TYPE_FOUND'));

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

			$app->setUserState('com_###component###.message', JText::_('COM_###COMPONENT###_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE'));
			return false;
		}
		
		// first link data to table headers
		if(!$continue){
			$package	= json_encode($package);
			$session->set('package', $package);
			$session->set('dataType', $this->dataType);
			$session->set('hasPackage', true);
			return true;
		}
        
		// set the data
		$headerList = json_decode($session->get($this->dataType.'_VDM_IMPORTHEADERS', false), true);
		if (!$this->setData($package,$this->dataType,$headerList))
		{
			// There was an error importing the package
			$msg = JText::_('COM_###COMPONENT###_IMPORT_ERROR');
			$back = $session->get('backto_VDM_IMPORT', NULL);
			if ($back)
			{
				$app->setUserState('com_###component###.redirect_url', 'index.php?option=com_###component###&view='.$back);
				$session->clear('backto_VDM_IMPORT');
			}
			$result = false;
		}
		else
		{
			// Package imported sucessfully
			$msg = JText::sprintf('COM_###COMPONENT###_IMPORT_SUCCESS', $package['packagename']);
			$back = $session->get('backto_VDM_IMPORT', NULL);
			if ($back)
			{
			    $app->setUserState('com_###component###.redirect_url', 'index.php?option=com_###component###&view='.$back);
			    $session->clear('backto_VDM_IMPORT');
			}
			$result = true;
		}

		// Set some model state values
		$app->enqueueMessage($msg);

		// remove file after import
		$this->remove($package['packagename']);
		$session->clear($this->getType.'_VDM_IMPORTHEADERS');
        
		return $result;
	}

	/**
	 * Works out an importation spreadsheet from a HTTP upload
	 *
	 * @return spreadsheet definition or false on failure
	 */
	protected function _getPackageFromUpload()
	{		
		// Get the uploaded file information
		$input    = JFactory::getApplication()->input;

		// Do not change the filter type 'raw'. We need this to let files containing PHP code to upload. See JInputFiles::get.
		$userfile = $input->files->get('import_package', null, 'raw');
		
		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads'))
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_WARNIMPORTFILE'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile))
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_NO_FILE_SELECTED'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ($userfile['error'] || $userfile['size'] < 1)
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_WARNIMPORTUPLOADERROR'));
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
		$input = JFactory::getApplication()->input;

		// Get the path to the package to import
		$p_dir = $input->getString('import_directory');
		$p_dir = JPath::clean($p_dir);
		// Did you give us a valid path?
		if (!file_exists($p_dir))
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY'));
			return false;
		}

		// Detect the package type
		$type = $this->getType;

		// Did you give us a valid package?
		if (!$type)
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE'));
		}
		
		// check the extention
		switch(strtolower(pathinfo($p_dir, PATHINFO_EXTENSION))){
			case 'xls':
			case 'ods':
			case 'csv':
			break;
			
			default:
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE'));
			return false;
			break;
		}
		
		$package['packagename'] = null;
		$package['dir'] 		= $p_dir;
		$package['type'] 		= $type;

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
		$input = JFactory::getApplication()->input;

		// Get the URL of the package to import
		$url = $input->getString('import_url');

		// Did you give us a URL?
		if (!$url)
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_ENTER_A_URL'));
			return false;
		}

		// Download the package at the URL given
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file)
		{
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_INVALID_URL'));
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
		// Clean the name
		$archivename = JPath::clean($archivename);
		
		// check the extention
		switch(strtolower(pathinfo($archivename, PATHINFO_EXTENSION))){
			case 'xls':
			case 'ods':
			case 'csv':
			break;
			
			default:
			// Cleanup the import files
			$this->remove($archivename);
			JError::raiseWarning('', JText::_('COM_###COMPONENT###_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE'));
			return false;
			break;
		}	
		
		$config					= JFactory::getConfig();
		// set Package Name
		$check['packagename']	= $archivename;
		
		// set directory
		$check['dir']		= $config->get('tmp_path'). '/' .$archivename;
		
		// set type
		$check['type']		= $this->getType;
		
		return $check;
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
	protected function setData($package,$table,$target_headers)
	{###IMPORT_SETDATE_METOD_CUSTOM###
	}
	
	/**
	* Save the data from the file to the database
	*
	* @param string  $package Paths to the uploaded package file
	*
	* @return  boolean false on failure
	*
	**/
	protected function save($data,$table)
	{###IMPORT_SAVE_METOD_CUSTOM###
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
		$columns = $db->getTableColumns('#__###component###_'.$table);
		if(isset($columns['alias'])){
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('alias')));
			$query->from($db->quoteName('#__###component###_'.$table));
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
