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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\Utilities\ArrayHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * ###Component### ###View### Model
 */
class ###Component###Model###View### extends JModelLegacy
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
	protected $_context = 'com_###component###.###view###';
	
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

		$this->setState('message', $app->getUserState('com_###component###.message'));
		$app->setUserState('com_###component###.message', '');

		// Recall the 'Import from Directory' path.
		$path = $app->getUserStateFromRequest($this->_context . '.import_directory', 'import_directory', $app->get('tmp_path'));
		$this->setState('import.directory', $path);
		parent::populateState();
	}
	###IMPORT_METHOD_CUSTOM### 

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
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_WARNIMPORTFILE'), 'warning');
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile))
		{
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_NO_FILE_SELECTED'), 'warning');
			return false;
		}

		// Check if there was a problem uploading the file.
		if ($userfile['error'] || $userfile['size'] < 1)
		{
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_WARNIMPORTUPLOADERROR'), 'warning');
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
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY'), 'warning');
			return false;
		}

		// Detect the package type
		$type = $this->getType;

		// Did you give us a valid package?
		if (!$type)
		{
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE'), 'warning');
		}
		
		// check the extention
		if(!$this->checkExtension($p_dir))
		{
			// set error message
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE'), 'warning');
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
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_ENTER_A_URL'), 'warning');
			return false;
		}

		// Download the package at the URL given
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file)
		{
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_INVALID_URL'), 'warning');
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
			$app->enqueueMessage(JText::_('COM_###COMPONENT###_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE'), 'warning');
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
	###IMPORT_EXT_METHOD###

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
	###IMPORT_SETDATA_METHOD###
	###IMPORT_SAVE_METHOD###

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
