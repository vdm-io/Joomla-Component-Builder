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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Helper\Compiler;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Installer\InstallerHelper;
use Joomla\CMS\Installer\Installer;

/**
 * Componentbuilder List Model for Compiler
 */
class ComponentbuilderModelCompiler extends ListModel
{
	/**
	 * Model user data.
	 *
	 * @var  strings
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
		$this->user = Factory::getUser();
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups    = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->app = Factory::getApplication();
		$this->input = $this->app->input;
		$this->initSet = true;
		// Make sure all records load, since no pagination allowed.
		$this->setState('list.limit', 0);
		// Get a db connection.
		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get from #__componentbuilder_joomla_component as a
		$query->select($db->quoteName(
			array('a.id','a.system_name','a.name','a.name_code','a.component_version','a.debug_linenr','a.short_description','a.image','a.companyname','a.author','a.email','a.website','a.copyright','a.modified','a.created','a.version'),
			array('id','system_name','name','name_code','component_version','debug_linenr','short_description','image','companyname','author','email','website','copyright','modified','created','version')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));
		// Get where a.published is 1
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
		$user = Factory::getUser();
		// check if this user has permission to access items
		if (!$user->authorise('compiler.access', 'com_componentbuilder'))
		{
			$app = Factory::getApplication();
			$app->enqueueMessage(Text::_('Not authorised!'), 'error');
			// redirect away if not a correct (TODO for now we go to default view)
			$app->redirect('index.php?option=com_componentbuilder');
			return false;
		}
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = ComponentHelper::getParams('com_componentbuilder', true);

		// Insure all item fields are adapted where needed.
		if (UtilitiesArrayHelper::check($items))
		{
			// Load the JEvent Dispatcher
			PluginHelper::importPlugin('content');
			$this->_dispatcher = Factory::getApplication();
			foreach ($items as $nr => &$item)
			{
				// Always create a slug for sef URL's
				$item->slug = ($item->id ?? '0') . (isset($item->alias) ? ':' . $item->alias : '');
				// Check if item has params, or pass whole item.
				$params = (isset($item->params) && JsonHelper::check($item->params)) ? json_decode($item->params) : $item;
				// Make sure the content prepare plugins fire on copyright
				$_copyright = new \stdClass();
				$_copyright->text =& $item->copyright; // value must be in text
				// Since all values are now in text (Joomla Limitation), we also add the field name (copyright) to context
				$this->_dispatcher->triggerEvent("onContentPrepare", array('com_componentbuilder.compiler.copyright', &$_copyright, &$params, 0));
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
		if (isset($this->uikitComp) && UtilitiesArrayHelper::check($this->uikitComp))
		{
			return $this->uikitComp;
		}
		return false;
	}

	public $compiler;

	public function builder() 
	{
		// run compiler
		$this->compiler = new Compiler();
		if($this->compiler)
		{
			return true;
		}
		return false;
	}

	public function emptyFolder($dir, $removeDir = false)
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		if (is_dir($dir))
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
				if ($file->isDir())
				{
					Folder::delete($file->getPathname());	
				}
				else
				{
					if ($file->getBasename() !== 'index.html')
					{
						File::delete($file->getPathname());
					}
				}
			}
			if ($removeDir)
			{
				if (Folder::delete($dir))
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
		$this->setState('action', 'install');

		// Set FTP credentials, if given.
		JClientHelper::setCredentialsFromRequest('ftp');
		$app = Factory::getApplication();

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

		if (in_array(false, $results, true))
		{
			return false;
		}

		$config   = Factory::getConfig();
		$tmp_dest = $config->get('tmp_path');

		// Unpack the downloaded package file.
		$package = InstallerHelper::unpack($tmp_dest . '/' . $p_file, true);

		// insure the install type is folder (JCB zip file is in the folder)
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
			$app->enqueueMessage(Text::_('COM_INSTALLER_UNABLE_TO_FIND_INSTALL_PACKAGE'), 'error');
			return false;
		}

		// Get an installer instance.
		$installer = Installer::getInstance();

		// Install the package.
		if (!$installer->install($package['dir']))
		{
			// There was an error installing the package.
			$msg = Text::sprintf('COM_INSTALLER_INSTALL_ERROR', Text::_('COM_INSTALLER_TYPE_TYPE_' . strtoupper($package['type'])));
			$result = false;
			$msgType = 'error';
		}
		else
		{
			// Package installed successfully.
			$msg = Text::sprintf('COM_INSTALLER_INSTALL_SUCCESS', Text::_('COM_INSTALLER_TYPE_TYPE_' . strtoupper($package['type'])));
			$result = true;
			$msgType = 'message';
		}

		// This event allows a custom a post-flight:
		$dispatcher->trigger('onInstallerAfterInstaller', array($this, &$package, $installer, &$result, &$msg));

		// Set some model state values.
		$app = Factory::getApplication();
		$app->enqueueMessage($msg, $msgType);
		$this->setState('name', $installer->get('name'));
		$this->setState('result', $result);
		$app->setUserState('com_componentbuilder.message', $installer->message);
		$app->setUserState('com_componentbuilder.extension_message', $installer->get('extension_message'));
		$app->setUserState('com_componentbuilder.redirect_url', $installer->get('redirect_url'));

		// Cleanup the install files.
		if (!is_file($package['packagefile']))
		{
			$config = Factory::getConfig();
			$package['packagefile'] = $config->get('tmp_path') . '/' . $package['packagefile'];
		}

		InstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);

		// Clear the cached extension data and menu cache
		$this->cleanCache('_system', 0);
		$this->cleanCache('_system', 1);
		$this->cleanCache('com_modules', 0);
		$this->cleanCache('com_modules', 1);
		$this->cleanCache('com_plugins', 0);
		$this->cleanCache('com_plugins', 1);
		$this->cleanCache('mod_menu', 0);
		$this->cleanCache('mod_menu', 1);

		return $result;
	}

	/**
	 * Get all components in the system
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function getComponents(): ?array
	{
		// Get a db connection.
		$db = $this->getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select only id and system name
		$query->select($db->quoteName(array('id', 'system_name'),array('id', 'name')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));

		// only the active components
		$query->where($db->quoteName('published') . ' = 1');

		// Order it by the ordering field.
		$query->order('modified DESC');
		$query->order('created DESC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// return the result
		return $db->loadObjectList() ?? null;
	}

	/**
	 * Get all dynamic content
	 *
	 * @return  bool
	 * @since   3.2.0
	 **/
	public function getDynamicContent(&$errorMessage): bool
	{
		// convert error message to array
		$errorMessage = [];
		$searchArray = [
			// add banners (width - height)
			'banner' => [
					'728-90',
					'160-600'
				],
			// The build-gif by size (width - height)
			'builder-gif' => [
					'480-540'
				]
			];
		// start search, and get
		foreach ($searchArray as $type => $sizes)
		{
			// per size
			foreach ($sizes as $size)
			{
				// get size
				if (($set_size = ComponentbuilderHelper::getDynamicContentSize($type, $size)) !== 0)
				{
					// we loop over all type size artwork
					for ($target = 1; $target <= $set_size; $target++)
					{
    						if (!ComponentbuilderHelper::getDynamicContent($type, $size, false, 0, $target))
    						{
    							$errorMessage[] = Text::sprintf('COM_COMPONENTBUILDER_S_S_NUMBER_BSB_COULD_NOT_BE_DOWNLOADED_SUCCESSFULLY_TO_THIS_JOOMLA_INSTALL', $type, $size, $target);
    						}
					}
				}
			}
		}
		// check if we had any errors
		if (UtilitiesArrayHelper::check($errorMessage))
		{
			// flatten the error message array
			$errorMessage = implode('<br />', $errorMessage);

			return false;
		}
		return true;
	}

}
