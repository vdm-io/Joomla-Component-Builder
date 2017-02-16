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

	@version		@update number 18 of this MVC
	@build			16th February, 2017
	@created		1st February, 2017
	@package		Component Builder
	@subpackage		compiler.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * Componentbuilder Model for Compiler
 */
class ComponentbuilderModelCompiler extends JModelList
{
        /**
	 * Model user data.
	 *
	 * @var        strings
	 */
        protected $user;
        protected $userId;
        protected $guest;
        protected $groups;
        protected $levels;
	protected $app;
	protected $input;
	protected $uikitComp;

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
                // Get the current user for authorisation checks
		$this->user		= JFactory::getUser();
		$this->userId		= $this->user->get('id');
		$this->guest		= $this->user->get('guest');
                $this->groups		= $this->user->get('groups');
                $this->authorisedGroups	= $this->user->getAuthorisedGroups();
		$this->levels		= $this->user->getAuthorisedViewLevels();
		$this->app		= JFactory::getApplication();
		$this->input		= $this->app->input;
		$this->initSet		= true; 
		// Make sure all records load, since no pagination allowed.
		$this->setState('list.limit', 0);
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get from #__componentbuilder_joomla_component as a
		$query->select($db->quoteName(
			array('a.id','a.system_name','a.name','a.name_code','a.component_version','a.debug_linenr','a.short_description','a.image','a.companyname','a.author','a.email','a.website','a.copyright','a.modified','a.created','a.version'),
			array('id','system_name','name','name_code','component_version','debug_linenr','short_description','image','companyname','author','email','website','copyright','modified','created','version')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));
		$query->where('a.published = 1');
		$query->order('a.modified DESC');
		$query->order('a.created DESC');

		// return the query object
		return $query;
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 */
	public function getItems()
	{
                $user = JFactory::getUser();
                // check if this user has permission to access items
                if (!$user->authorise('compiler.access', 'com_componentbuilder'))
                {
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('Not authorised!'), 'error');
			// redirect away if not a correct (TODO for now we go to default view)
			$app->redirect('index.php?option=com_componentbuilder');
			return false;
                } 
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = JComponentHelper::getParams('com_componentbuilder', true);

		// Convert the parameter fields into objects.
		if (ComponentbuilderHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// Always create a slug for sef URL's
				$item->slug = (isset($item->alias) && isset($item->id)) ? $item->id.':'.$item->alias : $item->id;
				// Make sure the content prepare plugins fire on copyright.
				$item->copyright = JHtml::_('content.prepare',$item->copyright);
				// Checking if copyright has uikit components that must be loaded.
				$this->uikitComp = ComponentbuilderHelper::getUikitComp($item->copyright,$this->uikitComp);
			}
		} 

		// return items
		return $items;
	}


	/**
	* Get the uikit needed components
	*
	* @return mixed  An array of objects on success.
	*
	*/
	public function getUikitComp()
	{
		if (isset($this->uikitComp) && ComponentbuilderHelper::checkArray($this->uikitComp))
		{
			return $this->uikitComp;
		}
		return false;
	}  

	protected $compiler;
	
	public function getComponents()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		$query->select($db->quoteName(array('id', 'system_name'),array('id', 'name')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->order('modified DESC');
		$query->order('created DESC');
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		// return the result
		return $db->loadObjectList();
	}
	
	public function builder($version, $id, $backup, $git, $addPlaceholders, $debugLinenr) 
	{	
		$set['joomlaVersion']		= $version;
		$set['componentId']		= $id;
		$set['addBackup']		= $backup;
		$set['addGit']			= $git;
		$set['addPlaceholders']	= $addPlaceholders;
		$set['debugLinenr']		= $debugLinenr;
		// start up Compiler
		$this->compiler			= new Compiler($set);
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
			'filename' => $this->compiler->componentFolderName,
			'time' => $this->compiler->secondsCompiled
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
		$app->setUserState('com_componentbuilder.message', $installer->message);
		$app->setUserState('com_componentbuilder.extension_message', $installer->get('extension_message'));
		$app->setUserState('com_componentbuilder.redirect_url', $installer->get('redirect_url'));

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
