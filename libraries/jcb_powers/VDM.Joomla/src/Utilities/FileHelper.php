<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\Archive\Archive;


/**
 * File helper
 * 
 * @since  3.0.9
 */
abstract class FileHelper
{
	/**
	 * Trigger error notice only once
	 *
	 * @var    bool
	 *
	 * @since  3.0.9
	 */
	protected static $curlError = false;

	/**
	 * The zipper method
	 * 
	 * @param  string   $workingDirectory    The directory where the items must be zipped
	 * @param  string   $filepath          The path to where the zip file must be placed
	 *
	 * @return  bool true   On success
	 *
	 * @since  3.0.9
	 */
	public static function zip($workingDirectory, &$filepath)
	{
		// store the current joomla working directory
		$joomla = getcwd();

		// we are changing the working directory to the component temp folder
		chdir($workingDirectory);

		// the full file path of the zip file
		$filepath = Path::clean($filepath);

		// delete an existing zip file (or use an exclusion parameter in Folder::files()
		File::delete($filepath);

		// get a list of files in the current directory tree (also the hidden files)
		$files = Folder::files('.', '', true, true, array('.svn', 'CVS', '.DS_Store', '__MACOSX'), array('.*~'));

		$zipArray = array();
		// setup the zip array
		foreach ($files as $file)
		{
			$tmp = array();
			$tmp['name'] = str_replace('./', '', $file);
			$tmp['data'] = self::getContent($file);
			$tmp['time'] = filemtime($file);
			$zipArray[] = $tmp;
		}

		// change back to joomla working directory
		chdir($joomla);

		// get the zip adapter
		$adapter = new Archive();
		$zip = $adapter->getAdapter('zip');

		//create the zip file
		if ($zip->create($filepath, $zipArray))
		{
			return true;
		}
		return false;
	}

	/**
	 * get the content of a file
	 *
	 * @param  string        $path   The path to the file
	 * @param  string/bool   $none   The return value if no content was found
	 *
	 * @return  string   On success
	 *
	 * @since  3.0.9
	 */
	public static function getContent($path, $none = '')
	{
		if (StringHelper::check($path))
		{
			// use basic file get content for now
			if (($content = @file_get_contents($path)) !== FALSE)
			{
				return $content;
			}
			// use curl if available
			elseif (function_exists('curl_version'))
			{
				// start curl
				$ch = curl_init();
				// set the options
				$options = array();
				$options[CURLOPT_URL] = $path;
				$options[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12';
				$options[CURLOPT_RETURNTRANSFER] = TRUE;
				$options[CURLOPT_SSL_VERIFYPEER] = FALSE;
				// load the options
				curl_setopt_array($ch, $options);
				// get the content
				$content = curl_exec($ch);
				// close the connection
				curl_close($ch);

				// return if found
				if (StringHelper::check($content))
				{
					return $content;
				}
			}
			elseif (!self::$curlError)
			{
				// set the notice
				Factory::getApplication()->enqueueMessage(Text::_('COM_COMPONENTBUILDER_HTWOCURL_NOT_FOUNDHTWOPPLEASE_SETUP_CURL_ON_YOUR_SYSTEM_OR_BCOMPONENTBUILDERB_WILL_NOT_FUNCTION_CORRECTLYP'), 'Error');
				// load this notice only once
				self::$curlError = true;
			}
		}
		return $none;
	}

	/**
	 * Write a file to the server
	 *
	 * @param  string   $path    The path and file name where to safe the data
	 * @param  string   $data    The data to safe
	 *
	 * @return  bool true   On success
	 *
	 * @since  3.0.9
	 */
	public static function write($path, $data)
	{
		$klaar = false;
		if (StringHelper::check($data))
		{
			// open the file
			$fh = fopen($path, "w");
			if (!is_resource($fh))
			{
				return $klaar;
			}
			// write to the file
			if (fwrite($fh, $data))
			{
				// has been done
				$klaar = true;
			}
			// close file.
			fclose($fh);
		}
		return $klaar;
	}

}

