<?php
/**
*
*  @version		2.0.0 - September 03, 2014
*  @package		Component Builder
*  @author		Llewellyn van de Merwe <http://www.vdm.io>
*  @copyright		Copyright (C) 2014. All Rights Reserved
*  @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
*
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

// include component compiler
require_once JPATH_ADMINISTRATOR.'/components/com_###component###/helpers/compiler.php';

/**
 * ###Component### Model
 */
class ###Component###ModelCompiler extends JModelList
{
	protected $compiler;
	
	public function getComponents()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		$query->select($db->quoteName(array('id', 'system_name'),array('id', 'name')));
		$query->from($db->quoteName('#__###component###_component'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->order('ordering ASC');
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		// return the result
		return $db->loadObjectList();
	}
	
	public function builder($version,$id,$backup,$git) 
	{	
		$set['joomlaVersion']	= $version;
		$set['componentId']	= $id;
		$set['addBackup']	= $backup;
		$set['addGit']		= $git;
		// start up Compiler
		$this->compiler		= new Compiler($set);
		if($this->compiler){
			return true;
		}
		return false;
	}
    
	public function getCount()
	{
		return array(
			'lines' => $this->compiler->lineCount, 
			'files' => $this->compiler->fileCount, 
			'folders' => $this->compiler->folderCount, 
			'filePath' => $this->compiler->filepath, 
			'filename' => $this->compiler->componentFolderName
		);
	}
	
	public function emptyFolder($dir, $removeDir = false)
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		if (JFolder::exists($dir))
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
				if ($file->isDir())
				{
					JFolder::delete($file->getPathname());	
				}
				else
				{
					if ($file->getBasename() !== 'index.html')
					{
						JFile::delete($file->getPathname());
					}
				}
			}
			if ($removeDir)
			{
				if (JFolder::delete($dir))
				{
					return true;
				}
			}
			else
			{
				return true;
			}
		}
		return false;
	}
	
	public function install($p_file)
	{
		// Set FTP credentials, if given.
		JClientHelper::setCredentialsFromRequest('ftp');
		$app = JFactory::getApplication();

		// Load installer plugins for assistance if required:
		JPluginHelper::importPlugin('installer');
		$dispatcher = JEventDispatcher::getInstance();
		
		$package = null;

		// This event allows an input pre-treatment, a custom pre-packing or custom installation.
		// (e.g. from a JSON description).
		$results = $dispatcher->trigger('onInstallerBeforeInstallation', array($this, &$package));

		if (in_array(true, $results, true))
		{
			return true;
		}
		elseif (in_array(false, $results, true))
		{
			return false;
		}
		
		$config   = JFactory::getConfig();
		$tmp_dest = $config->get('tmp_path');

		// Unpack the downloaded package file.
		$package = JInstallerHelper::unpack($tmp_dest . '/' . $p_file, true);
		// insure the install type is folder
		$installType = 'folder';
		// This event allows a custom installation of the package or a customization of the package:
		$results = $dispatcher->trigger('onInstallerBeforeInstaller', array($this, &$package));

		if (in_array(true, $results, true))
		{
			return true;
		}
		elseif (in_array(false, $results, true))
		{
			return false;
		}
		
		// Was the package unpacked?
		if (!$package || !$package['type'])
		{
			$app->enqueueMessage(JText::_('COM_INSTALLER_UNABLE_TO_FIND_INSTALL_PACKAGE'), 'error');
			return false;
		}

		// Get an installer instance.
		$installer = JInstaller::getInstance();

		// Install the package.
		if (!$installer->install($package['dir']))
		{
			// There was an error installing the package.
			$msg = JText::sprintf('COM_INSTALLER_INSTALL_ERROR', JText::_('COM_INSTALLER_TYPE_TYPE_' . strtoupper($package['type'])));
			$result = false;
			$msgType = 'error';
		}
		else
		{
			// Package installed sucessfully.
			$msg = JText::sprintf('COM_INSTALLER_INSTALL_SUCCESS', JText::_('COM_INSTALLER_TYPE_TYPE_' . strtoupper($package['type'])));
			$result = true;
			$msgType = 'message';
		}

		// This event allows a custom a post-flight:
		$dispatcher->trigger('onInstallerAfterInstaller', array($this, &$package, $installer, &$result, &$msg));

		// Set some model state values.
		$app	= JFactory::getApplication();
		$app->enqueueMessage($msg, $msgType);
		$this->setState('name', $installer->get('name'));
		$this->setState('result', $result);
		$app->setUserState('com_###component###.message', $installer->message);
		$app->setUserState('com_###component###.extension_message', $installer->get('extension_message'));
		$app->setUserState('com_###component###.redirect_url', $installer->get('redirect_url'));

		// Cleanup the install files.
		if (!is_file($package['packagefile']))
		{
			$config = JFactory::getConfig();
			$package['packagefile'] = $config->get('tmp_path') . '/' . $package['packagefile'];
		}

		JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);

		return $result;
	}
}
