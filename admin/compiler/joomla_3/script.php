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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Installer\Adapter\ComponentAdapter;
use Joomla\CMS\Version;
use Joomla\CMS\HTML\HTMLHelper as Html;
HTML::_('bootstrap.renderModal');

/**
 * Script File of ###Component### Component
 */
class Com_###Component###InstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 */
	public function __construct(ComponentAdapter $parent) {}

	/**
	 * Called on installation
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install(ComponentAdapter $parent) {}

	/**
	 * Called on uninstallation
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 */
	public function uninstall(ComponentAdapter $parent)
	{###UNINSTALLSCRIPT###
		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:###AUTHOREMAIL###">###AUTHOREMAIL###</a>.
		<br />We at ###COMPANYNAME### are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="###AUTHORWEBSITE###" target="_blank">###AUTHORWEBSITE###</a> today!</p>';
	}

	/**
	 * Called on update
	 *
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update(ComponentAdapter $parent){}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $type  Which action is happening (install|uninstall|discover_install|update)
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($type, ComponentAdapter $parent)
	{
		// get application
		$app = Factory::getApplication();
		// is redundant or so it seems ...hmmm let me know if it works again
		if ($type === 'uninstall')
		{
			return true;
		}
		// the default for both install and update
		$jversion = new Version();
		if (!$jversion->isCompatible('3.8.0'))
		{
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.8.0 before continuing!', 'error');
			return false;
		}
		// do any updates needed
		if ($type === 'update')
		{###PREUPDATESCRIPT###
		}
		// do any install needed
		if ($type === 'install')
		{###PREINSTALLSCRIPT###
		}
		// check if the PHPExcel stuff is still around
		if (File::exists(JPATH_ADMINISTRATOR . '/components/com_###component###/helpers/PHPExcel.php'))
		{
			// We need to remove this old PHPExcel folder
			$this->removeFolder(JPATH_ADMINISTRATOR . '/components/com_###component###/helpers/PHPExcel');
			// We need to remove this old PHPExcel file
			File::delete(JPATH_ADMINISTRATOR . '/components/com_###component###/helpers/PHPExcel.php');
		}
		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $type  Which action is happening (install|uninstall|discover_install|update)
	 * @param   ComponentAdapter  $parent  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, ComponentAdapter $parent)
	{
		// get application
		$app = Factory::getApplication();###MOVEFOLDERSSCRIPT###
		// set the default component settings
		if ($type === 'install')
		{###POSTINSTALLSCRIPT###
		}
		// do any updates needed
		if ($type === 'update')
		{###POSTUPDATESCRIPT###
		}
		return true;
	}

	/**
	 * Remove folders with files (with ignore options)
	 *
	 * @param   string	    $dir	 The path to the folder to remove.
	 * @param   array|null  $ignore  The folders and files to ignore and not remove.
	 *
	 * @return  bool   True if all specified files/folders are removed, false otherwise.
	 * @since 3.2.2
	 */
	protected function removeFolder(string $dir, ?array $ignore = null): bool
	{
		if (!is_dir($dir))
		{
			return false;
		}

		$it = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
		$it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

		// Remove trailing slash
		$dir = rtrim($dir, '/');

		foreach ($it as $file)
		{
			$filePath = $file->getPathname();
			$relativePath = str_replace($dir . '/', '', $filePath);

			if ($ignore !== null && in_array($relativePath, $ignore, true))
			{
				continue;
			}

			if ($file->isDir())
			{
				Folder::delete($filePath);
			}
			else
			{
				File::delete($filePath);
			}
		}

		// Delete the root folder if there are no ignored files/folders left
		if ($ignore === null || $this->isDirEmpty($dir, $ignore))
		{
			return Folder::delete($dir);
		}

		return true;
	}

	/**
	 * Check if a directory is empty considering ignored files/folders.
	 *
	 * @param   string  $dir	 The path to the folder to check.
	 * @param   array   $ignore  The folders and files to ignore.
	 *
	 * @return  bool    True if the directory is empty or contains only ignored items, false otherwise.
     * @since 3.2.1
	 */
	protected function isDirEmpty(string $dir, array $ignore): bool
	{
		$it = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
		foreach ($it as $file)
		{
			$relativePath = str_replace($dir . '/', '', $file->getPathname());
			if (!in_array($relativePath, $ignore, true))
			{
				return false;
			}
		}
		return true;
	}

	/**
	 * Check if have an array with a length
	 *
	 * @input    array   The array to check
	 *
	 * @returns bool/int  number of items in array on success
	 * @since 3.2.2
	 */
	protected function checkArray($array, $removeEmptyString = false)
	{
		if (isset($array) && is_array($array) && ($nr = count((array)$array)) > 0)
		{
			// also make sure the empty strings are removed
			if ($removeEmptyString)
			{
				foreach ($array as $key => $string)
				{
					if (empty($string))
					{
						unset($array[$key]);
					}
				}
				return $this->checkArray($array, false);
			}
			return $nr;
		}
		return false;
	}

	/**
	 * Ensures that a class in the namespace is available.
	 * If the class is not already loaded, it attempts to load it via the specified autoloader.
	 *
	 * @param string  $className   The fully qualified name of the class to check.
	 *
	 * @return bool True if the class exists or was successfully loaded, false otherwise.
	 * @since 3.2.2
	 */
	protected function classExists(string $className): bool
	{
		if (!class_exists($className, true))
		{
###THREE_POWER_AUTOLOADER###

			// Check again if the class now exists after requiring the autoloader
			if (!class_exists($className, true))
			{
				return false;
			}
		}
		return true;
	}###INSTALLERMETHODS###
}
