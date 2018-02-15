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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		componentbuilder.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder component helper
 */
abstract class ComponentbuilderHelper
{  

	/**
	* 	Locked Libraries (we can not have these change)
	**/
	public static $libraryNames = array(1 => 'No Library', 2 => 'Bootstrap v4', 3 => 'Uikit v3', 4 => 'Uikit v2', 5 => 'FooTable v2', 6 => 'FooTable v3');

	/**
	* 	The global params
	**/
	protected static $params = false;

	/**
	* 	The local company details
	**/
	protected static $localCompany = array();

	/**
	* 	The snippet paths
	**/
	public static $snippetPath = 'https://raw.githubusercontent.com/vdm-io/Joomla-Component-Builder-Snippets/master/';
	public static $snippetsPath = 'https://api.github.com/repos/vdm-io/Joomla-Component-Builder-Snippets/git/trees/master';

	/**
	*	Get the snippet contributor details
	* 
	*	@param  string   $filename   The file name
	*	@param  string   $type         The type of file
	*
	*	@return  array    On success the contributor details
	* 
	*/
	public static function getContributorDetails($filename, $type = 'snippet')
	{
		// start loading he contributor details
		$contributor = array();
		// get the path & content
		switch ($type)
		{
			case 'snippet':
				$path = $snippetPath.$filename;
				// get the file if available
				$content = self::getFileContents($path);
				if (self::checkJson($content))
				{
					$content = json_decode($content, true);
				}
			break;
			default:
				// only allow types that are being targeted
				return false;
			break;
		}
		// see if we have content and all needed details
		if (isset($content) && self::checkArray($content)
				&& isset($content['contributor_company'])
				&& isset($content['contributor_name'])
				&& isset($content['contributor_email'])
				&& isset($content['contributor_website']))
		{
			// got the details from file
			return array('contributor_company' => $content['contributor_company'] ,'contributor_name' => $content['contributor_name'], 'contributor_email' => $content['contributor_email'], 'contributor_website' => $content['contributor_website'], 'origin' => 'file');
		}
		// get the global settings
		if (!self::checkObject(self::$params))
		{
			self::$params = JComponentHelper::getParams('com_componentbuilder');
		}
		// get the global company details
		if (!self::checkArray(self::$localCompany))
		{
			// Set the person sharing information (default VDM ;)
			self::$localCompany['company']		= self::$params->get('export_company', 'Vast Development Method');
			self::$localCompany['owner']		= self::$params->get('export_owner', 'Llewellyn van der Merwe');
			self::$localCompany['email']		= self::$params->get('export_email', 'joomla@vdm.io');
			self::$localCompany['website']		= self::$params->get('export_website', 'https://www.vdm.io/');
		}
		// default global
		return array('contributor_company' => self::$localCompany['company']	,'contributor_name' => self::$localCompany['owner'], 'contributor_email' => self::$localCompany['email'], 'contributor_website' => self::$localCompany['website'], 'origin' => 'global');
	}

	/**
	*	Get the library files
	* 
	*	@param  int   $id   The library id to target
	*
	*	@return  array    On success the array of files that belong to this library
	* 
	*/
	public static function getLibraryFiles($id)
	{
		// get the library files, folders, and urls
		$files = array();
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('b.name','a.addurls','a.addfolders','a.addfiles')));
		$query->from($db->quoteName('#__componentbuilder_library_files_folders_urls','a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_library', 'b') . ' ON (' . $db->quoteName('a.library') . ' = ' . $db->quoteName('b.id') . ')');
		$query->where($db->quoteName('a.library') . ' = ' . (int) $id);
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{			
			// prepare the files
 			$result = $db->loadObject();
 			// first we load the URLs
			if (self::checkJson($result->addurls))
			{
				// convert to array
				$result->addurls = json_decode($result->addurls, true);
				// set urls
				if (self::checkArray($result->addurls))
				{
					// build media folder path
					$mediaPath = '/media/' . strtolower( preg_replace('/\s+/', '-', self::safeString($result->name, 'filename', ' ', false)));
					// load the urls
					foreach($result->addurls as $url)
					{
						if (isset($url['url']) && self::checkString($url['url']))
						{
							// set the path if needed
							if (isset($url['type']) && $url['type'] > 1)
							{
								$fileName = basename($url['url']);
								// build sub path
								if (strpos($fileName, '.js') !== false)
								{
									$path = '/js';
								}
								elseif (strpos($fileName, '.css') !== false)
								{
									$path = '/css';
								}
								else
								{
									$path = '';
								}
								// set the path to library file
								$url['path'] = $mediaPath . $path . '/' . $fileName; // we need this for later
							}
							// if local path is set, then use it first
							if (isset($url['path']))
							{
								// load document script
								$files[md5($url['path'])] =  '(' . JText::_('URL') . ') ' . basename($url['url']) . ' - ' . JText::_('COM_COMPONENTBUILDER_LOCAL');
							}
							// check if link must be added
							if (isset($url['url']) && ((isset($url['type']) && $url['type'] == 1) || (isset($url['type']) && $url['type'] == 3) || !isset($url['type'])))
							{
								// load url also if not building document
								$files[md5($url['url'])] = '(' . JText::_('URL') . ') ' . basename($url['url']) . ' - ' . JText::_('COM_COMPONENTBUILDER_LINK');
							}
						}
					}
				}
			}
			// load the local files
			if (self::checkJson($result->addfiles))
			{
				// convert to array
				$result->addfiles = json_decode($result->addfiles, true);
				// set files
				if (self::checkArray($result->addfiles))
				{
					foreach($result->addfiles as $file)
					{
						if (isset($file['file']) && isset($file['path']))
						{
							$path = '/'.trim($file['path'], '/');
							// check if path has new file name (has extetion)
							$pathInfo = pathinfo($path);
							if (isset($pathInfo['extension']) && $pathInfo['extension'])
							{
								// load document script
								$files[md5($path)] = '(' . JText::_('COM_COMPONENTBUILDER_FILE') . ') ' . $file['file'];
							}
							else
							{
								// load document script
								$files[md5($path.'/'.trim($file['file'],'/'))] = '(' . JText::_('COM_COMPONENTBUILDER_FILE') . ') ' . $file['file'];
							}
						}
					}
				}
			}
 			// load the files in the folder	
			if (self::checkJson($result->addfolders))
			{
				// convert to array
				$result->addfolders = json_decode($result->addfolders, true);
				// set folder
				if (self::checkArray($result->addfolders))
				{
					// get the global settings
					if (!self::checkObject(self::$params))
					{
						self::$params = JComponentHelper::getParams('com_componentbuilder');
					}
					// reset bucket
					$bucket = array();
					// get custom folder path
					$customPath = '/'.trim(self::$params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom'), '/');
					// get all the file paths
					foreach ($result->addfolders as $folder)
					{
						if (isset($folder['path']) && isset($folder['folder']))
						{
							$_path = '/'.trim($folder['path'], '/');
							$customFolder = '/'.trim($folder['folder'], '/');
							if (isset($folder['rename']) && 1 == $folder['rename'])
							{
								if ($_paths = self::getAllFilePaths($customPath.$customFolder))
								{
									$bucket[$_path] = $_paths;
								}
							}
							else
							{
								$path = $_path.$customFolder;
								if ($_paths = self::getAllFilePaths($customPath.$customFolder))
								{
									$bucket[$path] = $_paths;
								}
							}
						}
					}
					// now load the script
					if (self::checkArray($bucket))
					{
						foreach ($bucket as $root => $paths)
						{
							// load per path
							foreach($paths as $path)
							{
								$files[md5($root.'/'.trim($path, '/'))] = '(' . JText::_('COM_COMPONENTBUILDER_FOLDER') . ') ' . basename($path) . ' - ' . basename($root);
							}
						}
					}
				}
			}
			// return files if found
			if (self::checkArray($files))
			{
				return $files;
			}
		}
		return false;
	}
	
	/**
	 * get all the file paths in folder and sub folders
	 * 
	 * @param   string  $folder     The local path to parse
	 * @param   array   $fileTypes  The type of files to get
	 *
	 * @return  void
	 * 
	 */
	public static function getAllFilePaths($folder, $fileTypes = array('\.php', '\.js', '\.css', '\.less'))
	{
		if (JFolder::exists($folder))
		{
			// we must first store the current woking directory
			$joomla = getcwd();
			// we are changing the working directory to the componet path
			chdir($folder);
			// get the files
			foreach ($fileTypes as $type)
			{
				// get a list of files in the current directory tree
				$files[] = JFolder::files('.', $type, true, true);
			}
			// change back to Joomla working directory
			chdir($joomla);
			// return array of files
			return array_map( function($file) { return str_replace('./', '/', $file); }, (array) self::mergeArrays($files));
		}
		return false;
	}

	/**
	 * get all component IDs
	 */
	public static function getComponentIDs()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));
		$query->where($db->quoteName('published') . ' >= 1'); // do not backup trash
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{			
				return $db->loadColumn();
		}
		return false;
	}

	/**
	 * Autoloader
	 */
	public static function autoLoader($type = 'compiler')
	{
		// load the type classes
		if ('smart' !== $type)
		{
			foreach (glob(JPATH_ADMINISTRATOR."/components/com_componentbuilder/helpers/".$type."/*.php") as $autoFile)
			{
				require_once $autoFile;
			}
		}
		// load only if compiler
		if ('compiler' === $type)
		{
			// import the Joomla librarys
			jimport('joomla.filesystem.file');
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.archive');
			jimport('joomla.application.component.modellist');
			// include class to minify js
			require_once JPATH_ADMINISTRATOR.'/components/com_componentbuilder/helpers/js.php';
		}
		// load only if smart
		if ('smart' === $type)
		{
			// import the Joomla libraries
			jimport('joomla.filesystem.file');
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.archive');
			jimport('joomla.application.component.modellist');
		}
		// load this for all
		jimport('joomla.application');
	}
			
	/**
	 * Remove folders with files
	 * 
	 * @param   string   $dir     The path to folder to remove
	 * @param   boolean  $ignore  The folders and files to ignore and not remove
	 *
	 * @return  boolean   True in all is removed
	 * 
	 */
	public static function removeFolder($dir, $ignore = false)
	{
		if (JFolder::exists($dir))
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
				if ($file->isDir())
				{
					$keeper = false;
					if (self::checkArray($ignore))
					{
						foreach ($ignore as $keep)
						{
							if (strpos($file->getPathname(), $dir.'/'.$keep) !== false)
							{
								$keeper = true;
							}
						}
					}
					if ($keeper)
					{
						continue;
					}
					JFolder::delete($file->getPathname());
				}
				else
				{
					$keeper = false;
					if (self::checkArray($ignore))
					{
						foreach ($ignore as $keep)
						{
							if (strpos($file->getPathname(), $dir.'/'.$keep) !== false)
							{
								$keeper = true;
							}
						}
					}
					if ($keeper)
					{
						continue;
					}
					JFile::delete($file->getPathname());
				}
			}
			if (!self::checkArray($ignore))
			{
				return JFolder::delete($dir);
			}
			return true;
		}
		return false;
	}
			
	/**
	* 	The dynamic builder of views, tables and fields
	**/
	public static function dynamicBuilder(&$data, $type)
	{
		self::autoLoader('extrusion');
		$extruder = new Extrusion($data);
	}
			
	/**
	*	The zipper method
	* 
	*	@param  string   $workingDIR    The directory where the items must be zipped
	*	@param  string   $filepath          The path to where the zip file must be placed
	*
	*	@return  bool true   On success
	* 
	*/
	public static function zip($workingDIR, &$filepath)
	{
		// store the current joomla working directory
		$joomla = getcwd();

		// we are changing the working directory to the component temp folder
		chdir($workingDIR);

		// the full file path of the zip file
		$filepath = JPath::clean($filepath);

		// delete an existing zip file (or use an exclusion parameter in JFolder::files()
		JFile::delete($filepath);

		// get a list of files in the current directory tree
		$files = JFolder::files('.', '', true, true);
		$zipArray = array();
		// setup the zip array
		foreach ($files as $file)
		{
		   $tmp = array();
		   $tmp['name'] = str_replace('./', '', $file);
		   $tmp['data'] = JFile::read($file);
		   $tmp['time'] = filemtime($file);
		   $zipArray[] = $tmp;
		}

		// change back to joomla working directory
		chdir($joomla);

		// get the zip adapter
		$zip = JArchive::getAdapter('zip');

		//create the zip file
		if ($zip->create($filepath, $zipArray))
		{
			return true;
		}
		return false;
	}
			
			
	/**
	*	Write a file to the server
	* 
	*	@param  string   $path    The path and file name where to safe the data
	*	@param  string   $data    The data to safe
	*
	*	@return  bool true   On success
	* 
	*/
	public static function writeFile($path, $data)
	{
		$klaar = false;
		if (self::checkString($data))
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
				
	public static function getFieldOptions($value, $type, $settings = array())
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('properties', 'short_description', 'description')));
		$query->from($db->quoteName('#__componentbuilder_fieldtype'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->where($db->quoteName($type) . ' = '. $value);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$result = $db->loadObject();
			$properties = json_decode($result->properties,true);
			$field = array('values' => "<field ", 'values_description' => '<ul>', 'short_description' => $result->short_description, 'description' => $result->description);
			foreach ($properties as $property)
			{
				$field['values_description'] .= '<li><b>'.$property['name'].'</b> '.$property['description'].'</li>';
				if(isset($settings[$property['name']]))
				{
					$field['values'] .= "\n\t".$property['name'].'="'.$settings[$property['name']].'" ';
				}
				else
				{
					$field['values'] .= "\n\t".$property['name'].'="'.$property['example'].'" ';
				}
			}
			$field['values'] .= "\n/>";
			$field['values_description'] .= '</ul>';
			// return found field options
			return $field;
		}
		return false;
	}

	/**
	* 	get the localkey
	**/
	protected static $localkey = false;
	
	public static function getLocalKey()
	{
		if (!self::$localkey)
		{
			// get the main key
			self::$localkey = md5(JComponentHelper::getParams('com_componentbuilder')->get('basic_key', 'localKey34fdWEkl'));
		}
		return self::$localkey;
	}

	/**
	 *	indent HTML
	 */
	public static function indent($html)
	{
		// load the class
		require_once JPATH_ADMINISTRATOR.'/components/com_componentbuilder/helpers/indenter.php';
		// set new indenter
		$indenter = new Indenter();
		// return indented html
		return $indenter->indent($html);
	}

	public static function checkFileType($file, $sufix)
	{
		// now check if the file ends with the sufix
		return $sufix === "" || ($sufix == substr(strrchr($file, "."), -strlen($sufix)));
	}

	public static function imageInfo($path,$request = 'type')
	{
		// set image
		$image = JPATH_SITE.'/'.$path;
		// check if exists
		if (file_exists($image) && $result = @getimagesize($image))
		{
			// return type request
			switch ($request)
			{
				case 'width':
					return $result[0];
					break;
				case 'height':
					return $result[1];
					break;
				case 'type':
					$extensions = array(
						IMAGETYPE_GIF => "gif",
						IMAGETYPE_JPEG => "jpg",
						IMAGETYPE_PNG => "png",
						IMAGETYPE_SWF => "swf",
						IMAGETYPE_PSD => "psd",
						IMAGETYPE_BMP => "bmp",
						IMAGETYPE_TIFF_II => "tiff",
						IMAGETYPE_TIFF_MM => "tiff",
						IMAGETYPE_JPC => "jpc",
						IMAGETYPE_JP2 => "jp2",
						IMAGETYPE_JPX => "jpx",
						IMAGETYPE_JB2 => "jb2",
						IMAGETYPE_SWC => "swc",
						IMAGETYPE_IFF => "iff",
						IMAGETYPE_WBMP => "wbmp",
						IMAGETYPE_XBM => "xbm",
						IMAGETYPE_ICO => "ico"
					);
					return $extensions[$result[2]];
					break;
				case 'attr':
					return $result[3];
					break;
				case 'all':
				default:
					return $result;
					break;
			}
		}
		return false;
	}
	
	public static function getBetween($content,$start,$end)
	{
		$r = explode($start, $content);
		if (isset($r[1]))
		{
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}
	
	public static function getAllBetween($content,$start,$end)
	{
		$buket = array();
		for ($i = 0; ; $i++)
		{
			$found = self::getBetween($content,$start,$end);
			if (self::checkString($found))
			{
				$buket[] = $found;
				$remove = $start.$found.$end;
				$content = str_replace($remove,'',$content);
			}
			else
			{
				break;
			}
			// safety catch
			if ($i == 500)
			{
				break;
			}
		}
		return  array_unique($buket);
	}
	
	public static function typeField($type,$option = 'default')
	{
		// list of default fields
		// https://docs.joomla.org/Form_field
		$fields = array(
			'default' => array(
				'accesslevel','cachehandler','calendar','captcha','category','checkbox',
				'checkboxes','color','combo','componentlayout','contentlanguage','editor',
				'chromestyle','contenttype','databaseconnection','editors','email','file',
				'filelist','folderlist','groupedlist','hidden','file','headertag','helpsite',
				'imagelist','integer','language','list','media','menu','note','password',
				'plugins','range','radio','repeatable','rules','subform','sessionhandler','spacer','sql','tag',
				'tel','menuitem','modulelayout','meter','moduleorder','moduleposition','moduletag',
				'templatestyle','text','textarea','timezone','url','user','usergroup'
			), 
			'text' => array(
				'calendar','color','editor','email','password','tel','text','textarea','url','number','range'
			), 
			'list' => array(
				'checkboxes','checkbox','list','radio'
			), 
			'dynamic' => array(
				'category','headertag','tag','rules','user','file','filelist','folderlist','imagelist','integer','timezone','media','meter'
			)
		);
		
		if (in_array($type,$fields[$option]))
		{
			return true;
		}
		return false;		
	}

	/**
	* 	set the session defaults if not set
	**/
	protected static function setSessionDefaults()
	{
		// noting for now
		return true;
	}
			
	/**
	* 	the Butler
	**/
	public static $session = array();

	/**
	* 	the Butler Assistant 
	**/
	protected static $localSession = array();

	/**
	* 	start a session if not already set, and load with data
	**/
	public static function loadSession()
	{
		if (!isset(self::$session) || !self::checkObject(self::$session))
		{
			self::$session = JFactory::getSession();
		}
		// set the defaults
		self::setSessionDefaults();
	}

	/**
	* 	give Session more to keep
	**/
	public static function set($key, $value)
	{
		// set to local memory to speed up program
		self::$localSession[$key] = $value;
		// load to session for later use
		return self::$session->set($key, self::$localSession[$key]);
	}

	/**
	* 	get info from Session
	**/
	public static function get($key, $default = null)
	{
		// check if in local memory
		if (!isset(self::$localSession[$key]))
		{
			// set to local memory to speed up program
			self::$localSession[$key] = self::$session->get($key, $default);
		}
		return self::$localSession[$key];
	}
			
	/**
	* 	check if it is a new hash
	**/
	public static function newHash($hash, $name = 'backup', $type = 'hash', $key = '',  $fileType = 'txt')
	{
		// make sure we have a hash
		if (self::checkString($hash))
		{
			// first get the file path
			$path_filename = self::getFilePath('path', $name.$type, $fileType, $key, JPATH_COMPONENT_ADMINISTRATOR);
			// set as read if not already set
			if ($content = self::getFileContents($path_filename, false))
			{
				if ($hash == $content)
				{
					return false;
				}
			}
			// set the hash
			return self::writeFile($path_filename, $hash);
		}
		return false;
	}
			
	/**
	*	Check if the url exist
	* 
	*	@param  string   $url   The url to check
	*
	*	@return  bool      If exist true
	* 
	*/
	public static function urlExists($url)
	{
		$exists = false;
		// check if we can use curl
		if (function_exists('curl_version'))
		{
			// initiate curl
			$ch = curl_init($url);
			// CURLOPT_NOBODY (do not return body)
			curl_setopt($ch, CURLOPT_NOBODY, true);
			// make call
			$result = curl_exec($ch);
			// check return value
			if ($result !== false)
			{
				// get the http CODE
				$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($statusCode !== 404)
				{
					$exists = true;
				}
			}
			// close the connection
			curl_close($ch);
		}
		elseif ($headers = @get_headers($url))
		{
			if(isset($headers[0]) && is_string($headers[0]) && strpos($headers[0],'404') === false)
			{
				$exists = true;
			}
		}
		return $exists;
	}			
			
	/**
	*	Get the file path or url
	* 
	*	@param  string   $type              The (url/path) type to return
	*	@param  string   $target            The Params Target name (if set)
	*	@param  string   $fileType          The kind of filename to generate (if not set no file name is generated)
	*	@param  string   $key               The key to adjust the filename (if not set ignored)
	*	@param  string   $default           The default path if not set in Params (fallback path)
	*	@param  bool     $createIfNotSet    The switch to create the folder if not found
	*
	*	@return  string    On success the path or url is returned based on the type requested
	* 
	*/
	public static function getFilePath($type = 'path', $target = 'filepath', $fileType = null, $key = '', $default = JPATH_SITE . '/images/', $createIfNotSet = true)
	{
		// get the global settings
		if (!self::checkObject(self::$params))
		{
			self::$params = JComponentHelper::getParams('com_componentbuilder');
		}
		$filePath = self::$params->get($target, $default);
		// check the file path (revert to default only of not a hidden file path)
		if ('hiddenfilepath' !== $target && strpos($filePath, JPATH_SITE) === false)
		{
			$filePath = $default;
		}
		jimport('joomla.filesystem.folder');
		// create the folder if it does not exist
		if ($createIfNotSet && !JFolder::exists($filePath))
		{
			JFolder::create($filePath);
		}
		// setup the file name
		$fileName = '';
		// Get basic key
		$basickey = 'Th!s_iS_n0t_sAfe_buT_b3tter_then_n0thiug';
		if (method_exists(get_called_class(), "getCryptKey")) 
		{
			$basickey = self::getCryptKey('basic', $basickey);
		}
		// check the key
		if (!self::checkString($key))
		{
			$key = 'vDm';
		}
		// set the file name
		if (self::checkString($fileType))
		{
			// set the name
			$fileName = trim(md5($type.$target.$basickey.$key) . '.' . trim($fileType, '.'));
		}
		else
		{
			$fileName = trim(md5($type.$target.$basickey.$key)) . '.txt';
		}
		// return the url
		if ('url' === $type)
		{
			if (strpos($filePath, JPATH_SITE) !== false)
			{
				$filePath = trim( str_replace( JPATH_SITE, '', $filePath), '/');
				return JURI::root() . $filePath . '/' . $fileName;
			}
			// since the path is behind the root folder of the site, return only the root url (may be used to build the link)
			return JURI::root();
		}
		// sanitize the path
		return '/' . trim( $filePath, '/' ) . '/' . $fileName;
	}
			
			
	/**
	*	Get the file path or url
	* 
	*	@param  string   $type              The (url/path) type to return
	*	@param  string   $target            The Params Target name (if set)
	*	@param  string   $default           The default path if not set in Params (fallback path)
	*	@param  bool     $createIfNotSet    The switch to create the folder if not found
	*
	*	@return  string    On success the path or url is returned based on the type requested
	* 
	*/
	public static function getFolderPath($type = 'path', $target = 'folderpath', $default = JPATH_SITE . '/images/', $createIfNotSet = true)
	{
		// get the global settings
		if (!self::checkObject(self::$params))
		{
			self::$params = JComponentHelper::getParams('com_componentbuilder');
		}
		$folderPath = self::$params->get($target, $default);
		jimport('joomla.filesystem.folder');
		// create the folder if it does not exist
		if ($createIfNotSet && !JFolder::exists($folderPath))
		{
			JFolder::create($folderPath);
		}
		// return the url
		if ('url' === $type)
		{
			if (strpos($folderPath, JPATH_SITE) !== false)
			{
				$folderPath = trim( str_replace( JPATH_SITE, '', $folderPath), '/');
				return JURI::root() . $folderPath . '/';
			}
			// since the path is behind the root folder of the site, return only the root url (may be used to build the link)
			return JURI::root();
		}
		// sanitize the path
		return '/' . trim( $folderPath, '/' ) . '/';
	}
			
			
	/**
	*	get the content of a file
	* 
	*	@param  string          $path    The path to the file
	*	@param  string/bool   $none   The return value if no content was found
	*
	*	@return  string   On success
	* 
	*/
	public static function getFileContents($path, $none = '')
	{
		if (self::checkString($path))
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
				if (self::checkString($content))
				{
					return $content;
				}
			}
			elseif (property_exists('ComponentbuilderHelper', 'curlErrorLoaded') && !self::$curlErrorLoaded)
			{
				// set the notice
				JFactory::getApplication()->enqueueMessage(JText::_('COM_COMPONENTBUILDER_HTWOCURL_NOT_FOUNDHTWOPPLEASE_SETUP_CURL_ON_YOUR_SYSTEM_OR_BCOMPONENTBUILDERB_WILL_NOT_FUNCTION_CORRECTLYP'), 'Error');
				// load this notice only once
				self::$curlErrorLoaded = true;
			}
		}
		return $none;
	}
			
	
	public static function jsonToString($value, $sperator = ", ", $table = null)
	{
		// check if string is JSON
		$result = json_decode($value, true);
		if (json_last_error() === JSON_ERROR_NONE)
		{
			// is JSON
			if (self::checkArray($result))
			{
				if (self::checkString($table))
				{
					$names = array();
					foreach ($result as $val)
					{
						if ($name = self::getVar($table, $val, 'id', 'name'))
						{
							$names[] = $name;
						}
					}
					if (self::checkArray($names))
					{
						return (string) implode($sperator,$names);
					}	
				}
				return (string) implode($sperator,$result);
			}
			return (string) json_decode($value);
		}
		return $value;
	}
	
	/**
	*	Load the Component xml manifest.
	**/
	public static function manifest()
	{
		$manifestUrl = JPATH_ADMINISTRATOR."/components/com_componentbuilder/componentbuilder.xml";
		return simplexml_load_file($manifestUrl);
	}
	
	/**
	*	Joomla version object
	**/	
	protected static $JVersion;
	
	/**
	*	set/get Joomla version
	**/
	public static function jVersion()
	{
		// check if set
		if (!self::checkObject(self::$JVersion))
		{
			self::$JVersion = new JVersion();
		}
		return self::$JVersion;
	}

	/**
	*	Load the Contributors details.
	**/
	public static function getContributors()
	{
		// get params
		$params	= JComponentHelper::getParams('com_componentbuilder');
		// start contributors array
		$contributors = array();
		// get all Contributors (max 20)
		$searchArray = range('0','20');
		foreach($searchArray as $nr)
		{
			if ((NULL !== $params->get("showContributor".$nr)) && ($params->get("showContributor".$nr) == 2 || $params->get("showContributor".$nr) == 3))
			{
				// set link based of selected option
				if($params->get("useContributor".$nr) == 1)
                                {
					$link_front = '<a href="mailto:'.$params->get("emailContributor".$nr).'" target="_blank">';
					$link_back = '</a>';
				}
                                elseif($params->get("useContributor".$nr) == 2)
                                {
					$link_front = '<a href="'.$params->get("linkContributor".$nr).'" target="_blank">';
					$link_back = '</a>';
				}
                                else
                                {
					$link_front = '';
					$link_back = '';
				}
				$contributors[$nr]['title']	= self::htmlEscape($params->get("titleContributor".$nr));
				$contributors[$nr]['name']	= $link_front.self::htmlEscape($params->get("nameContributor".$nr)).$link_back;
			}
		}
		return $contributors;
	}

	/**
	*	Load the Component Help URLs.
	**/
	public static function getHelpUrl($view)
	{
		$user	= JFactory::getUser();
		$groups = $user->get('groups');
		$db	= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(array('a.id','a.groups','a.target','a.type','a.article','a.url'));
		$query->from('#__componentbuilder_help_document AS a');
		$query->where('a.site_view = '.$db->quote($view));
		$query->where('a.location = 2');
		$query->where('a.published = 1');
		$db->setQuery($query);
		$db->execute();
		if($db->getNumRows())
		{
			$helps = $db->loadObjectList();
			if (self::checkArray($helps))
			{
				foreach ($helps as $nr => $help)
				{
					if ($help->target == 1)
					{
						$targetgroups = json_decode($help->groups, true);
						if (!array_intersect($targetgroups, $groups))
						{
							// if user not in those target groups then remove the item
							unset($helps[$nr]);
							continue;
						}
					}
					// set the return type
					switch ($help->type)
					{
						// set joomla article
						case 1:
							return self::loadArticleLink($help->article);
						break;
						// set help text
						case 2:
							return self::loadHelpTextLink($help->id);
						break;
						// set Link
						case 3:
							return $help->url;
						break;
					}
				}
			}
		}
		return false;
	}

	/**
	*	Get the Article Link.
	**/
	protected static function loadArticleLink($id)
	{
		return JURI::root().'index.php?option=com_content&view=article&id='.$id.'&tmpl=component&layout=modal';
	}

	/**
	*	Get the Help Text Link.
	**/
	protected static function loadHelpTextLink($id)
	{
		$token = JSession::getFormToken();
		return 'index.php?option=com_componentbuilder&task=help.getText&id=' . (int) $id . '&token=' . $token;
	}

	/**
	*	Get any component's model
	**/
	public static function getModel($name, $path = JPATH_COMPONENT_SITE, $component = 'componentbuilder')
	{
		// full path
		$fullPath = $path . '/models';
		// load the model file
		JModelLegacy::addIncludePath($fullPath);
		// get instance
		$model = JModelLegacy::getInstance( $name, $component.'Model' );
		// if model not found
		if ($model == false)
		{
			require_once $fullPath.'/'.strtolower($name).'.php';
			// build class name
			$class = $prefix.$name;
			// initialize the model
			new $class();
			$model = JModelLegacy::getInstance($name, $prefix);
		}
		return $model;
	}
	
	/**
	*	Add to asset Table
	*/
	public static function setAsset($id,$table)
	{
		$parent = JTable::getInstance('Asset');
		$parent->loadByName('com_componentbuilder');
		
		$parentId = $parent->id;
		$name     = 'com_componentbuilder.'.$table.'.'.$id;
		$title    = '';

		$asset = JTable::getInstance('Asset');
		$asset->loadByName($name);

		// Check for an error.
		$error = $asset->getError();

		if ($error)
		{
			$this->setError($error);

			return false;
		}
		else
		{
			// Specify how a new or moved node asset is inserted into the tree.
			if ($asset->parent_id != $parentId)
			{
				$asset->setLocation($parentId, 'last-child');
			}

			// Prepare the asset to be stored.
			$asset->parent_id = $parentId;
			$asset->name      = $name;
			$asset->title     = $title;
			// get the default asset rules
			$rules = self::getDefaultAssetRules('com_componentbuilder',$table);
			if ($rules instanceof JAccessRules)
			{
				$asset->rules = (string) $rules;
			}

			if (!$asset->check() || !$asset->store())
			{
				JFactory::getApplication()->enqueueMessage($asset->getError(), 'warning');
				return false;
			}
			else
			{
				// Create an asset_id or heal one that is corrupted.
				$object = new stdClass();

				// Must be a valid primary key value.
				$object->id = $id;
				$object->asset_id = (int) $asset->id;

				// Update their asset_id to link to the asset table.
				return JFactory::getDbo()->updateObject('#__componentbuilder_'.$table, $object, 'id');
			}
		}
		return false;
	}
	
	/**
	 *	Gets the default asset Rules for a component/view.
	 */
	protected static function getDefaultAssetRules($component,$view)
	{
		// Need to find the asset id by the name of the component.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName('id'))
			->from($db->quoteName('#__assets'))
			->where($db->quoteName('name') . ' = ' . $db->quote($component));
		$db->setQuery($query);
		$db->execute();
		if ($db->loadRowList())
		{
			// asset alread set so use saved rules
			$assetId = (int) $db->loadResult();
			$result =  JAccess::getAssetRules($assetId);
			if ($result instanceof JAccessRules)
			{
				$_result = (string) $result;
				$_result = json_decode($_result);
				foreach ($_result as $name => &$rule)
				{
					$v = explode('.', $name);
					if ($view !== $v[0])
					{
						// remove since it is not part of this view
						unset($_result->$name);
					}
					else
					{
						// clear the value since we inherit
						$rule = array();
					}
				}
				// check if there are any view values remaining
				if (count($_result))
				{
					$_result = json_encode($_result);
					$_result = array($_result);
					// Instantiate and return the JAccessRules object for the asset rules.
					$rules = new JAccessRules($_result);

					return $rules;
				}
				return $result;
			}
		}
		return JAccess::getAssetRules(0);
	}

	public static function renderBoolButton()
	{
		$args = func_get_args();

		// get the radio element
		$button = JFormHelper::loadFieldType('radio');

		// setup the properties
		$name	 	= self::htmlEscape($args[0]);
		$additional = isset($args[1]) ? (string) $args[1] : '';
		$value		= $args[2];
		$yes 	 	= isset($args[3]) ? self::htmlEscape($args[3]) : 'JYES';
		$no 	 	= isset($args[4]) ? self::htmlEscape($args[4]) : 'JNO';

		// prepare the xml
		$element = new SimpleXMLElement('<field name="'.$name.'" type="radio" class="btn-group"><option '.$additional.' value="0">'.$no.'</option><option '.$additional.' value="1">'.$yes.'</option></field>');

		// run
		$button->setup($element, $value);

		return $button->input;

	}

	/**
	* 	UIKIT Component Classes
	**/
	public static $uk_components = array(
			'data-uk-grid' => array(
				'grid' ),
			'uk-accordion' => array(
				'accordion' ),
			'uk-autocomplete' => array(
				'autocomplete' ),
			'data-uk-datepicker' => array(
				'datepicker' ),
			'uk-form-password' => array(
				'form-password' ),
			'uk-form-select' => array(
				'form-select' ),
			'data-uk-htmleditor' => array(
				'htmleditor' ),
			'data-uk-lightbox' => array(
				'lightbox' ),
			'uk-nestable' => array(
				'nestable' ),
			'UIkit.notify' => array(
				'notify' ),
			'data-uk-parallax' => array(
				'parallax' ),
			'uk-search' => array(
				'search' ),
			'uk-slider' => array(
				'slider' ),
			'uk-slideset' => array(
				'slideset' ),
			'uk-slideshow' => array(
				'slideshow',
				'slideshow-fx' ),
			'uk-sortable' => array(
				'sortable' ),
			'data-uk-sticky' => array(
				'sticky' ),
			'data-uk-timepicker' => array(
				'timepicker' ),
			'data-uk-tooltip' => array(
				'tooltip' ),
			'uk-placeholder' => array(
				'placeholder' ),
			'uk-dotnav' => array(
				'dotnav' ),
			'uk-slidenav' => array(
				'slidenav' ),
			'uk-form' => array(
				'form-advanced' ),
			'uk-progress' => array(
				'progress' ),
			'upload-drop' => array(
				'upload', 'form-file' )
			);
	
	/**
	* 	Add UIKIT Components
	**/
	public static $uikit = false;

	/**
	* 	Get UIKIT Components
	**/
	public static function getUikitComp($content,$classes = array())
	{
		if (strpos($content,'class="uk-') !== false)
		{
			// reset
			$temp = array();
			foreach (self::$uk_components as $looking => $add)
			{
				if (strpos($content,$looking) !== false)
				{
					$temp[] = $looking;
				}
			}
			// make sure uikit is loaded to config
			if (strpos($content,'class="uk-') !== false)
			{
				self::$uikit = true;
			}
			// sorter
			if (self::checkArray($temp))
			{
				// merger
				if (self::checkArray($classes))
				{
					$newTemp = array_merge($temp,$classes);
					$temp = array_unique($newTemp);
				}
				return $temp;
			}
		}	
		if (self::checkArray($classes))
		{
			return $classes;
		}
		return false;
	} 

	public static function getVar($table, $where = null, $whereString = 'user', $what = 'id', $operator = '=', $main = 'componentbuilder')
	{
		if(!$where)
		{
			$where = JFactory::getUser()->id;
		}
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array($what)));		
		if (empty($table))
		{
			$query->from($db->quoteName('#__'.$main));
		}
		else
		{
			$query->from($db->quoteName('#__'.$main.'_'.$table));
		}
		if (is_numeric($where))
		{
			$query->where($db->quoteName($whereString) . ' '.$operator.' '.(int) $where);
		}
		elseif (is_string($where))
		{
			$query->where($db->quoteName($whereString) . ' '.$operator.' '. $db->quote((string)$where));
		}
		else
		{
			return false;
		}
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			return $db->loadResult();
		}
		return false;
	}

	public static function getVars($table, $where = null, $whereString = 'user', $what = 'id', $operator = 'IN', $main = 'componentbuilder', $unique = true)
	{
		if(!$where)
		{
			$where = JFactory::getUser()->id;
		}

		if (!self::checkArray($where) && $where > 0)
		{
			$where = array($where);
		}

		if (self::checkArray($where))
		{
			// prep main <-- why? well if $main='' is empty then $table can be categories or users
			if (self::checkString($main))
			{
				$main = '_'.ltrim($main, '_');
			}
			// Get a db connection.
			$db = JFactory::getDbo();
			// Create a new query object.
			$query = $db->getQuery(true);

			$query->select($db->quoteName(array($what)));
			if (empty($table))
			{
				$query->from($db->quoteName('#__'.$main));
			}
			else
			{
				$query->from($db->quoteName('#_'.$main.'_'.$table));
			}
			$query->where($db->quoteName($whereString) . ' '.$operator.' (' . implode(',',$where) . ')');
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				if ($unique)
				{
					return array_unique($db->loadColumn());
				}
				return $db->loadColumn();
			}
		}
		return false;
	} 

	public static function isPublished($id,$type)
	{
		if ($type == 'raw')
		{
			$type = 'item';
		}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.published'));
		$query->from('#__componentbuilder_'.$type.' AS a');
		$query->where('a.id = '. (int) $id);
		$query->where('a.published = 1');
		$db->setQuery($query);
		$db->execute();
		$found = $db->getNumRows();
		if($found)
		{
			return true;
		}
		return false;
	}

	public static function getGroupName($id)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(array('a.title'));
		$query->from('#__usergroups AS a');
		$query->where('a.id = '. (int) $id);
		$db->setQuery($query);
		$db->execute();
		$found = $db->getNumRows();
		if($found)
		{
			return $db->loadResult();
		}
		return $id;
	}
	
	/**
	*	Get the actions permissions
	**/
	public static function getActions($view,&$record = null,$views = null)
	{
		jimport('joomla.access.access');

		$user	= JFactory::getUser();
		$result	= new JObject;
		$view	= self::safeString($view);
		if (self::checkString($views))
		{
			$views = self::safeString($views);
		}
		// get all actions from component
		$actions = JAccess::getActions('com_componentbuilder', 'component');
		// set acctions only set in component settiongs
		$componentActions = array('core.admin','core.manage','core.options','core.export');
		// loop the actions and set the permissions
		foreach ($actions as $action)
		{
			// set to use component default
			$fallback = true;
			if (self::checkObject($record) && isset($record->id) && $record->id > 0 && !in_array($action->name,$componentActions))
			{
				// The record has been set. Check the record permissions.
				$permission = $user->authorise($action->name, 'com_componentbuilder.'.$view.'.' . (int) $record->id);
				if (!$permission) // TODO removed && !is_null($permission)
				{
					if ($action->name == 'core.edit' || $action->name == $view.'.edit')
					{
						if ($user->authorise('core.edit.own', 'com_componentbuilder.'.$view.'.' . (int) $record->id))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback = false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback = false;
							}
						}
						elseif ($user->authorise($view.'edit.own', 'com_componentbuilder.'.$view.'.' . (int) $record->id))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback = false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback = false;
							}
						}
						elseif ($user->authorise('core.edit.own', 'com_componentbuilder'))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback = false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback = false;
							}
						}
						elseif ($user->authorise($view.'edit.own', 'com_componentbuilder'))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback = false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback = false;
							}
						}
					}
				}
				elseif (self::checkString($views) && isset($record->catid) && $record->catid > 0)
				{
					// make sure we use the core. action check for the categories
					if (strpos($action->name,$view) !== false && strpos($action->name,'core.') === false ) {
						$coreCheck		= explode('.',$action->name);
						$coreCheck[0]	= 'core';
						$categoryCheck	= implode('.',$coreCheck);
					}
					else
					{
						$categoryCheck = $action->name;
					}
					// The record has a category. Check the category permissions.
					$catpermission = $user->authorise($categoryCheck, 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid);
					if (!$catpermission && !is_null($catpermission))
					{
						if ($action->name == 'core.edit' || $action->name == $view.'.edit')
						{
							if ($user->authorise('core.edit.own', 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback = false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback = false;
								}
							}
							elseif ($user->authorise($view.'edit.own', 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback = false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback = false;
								}
							}
							elseif ($user->authorise('core.edit.own', 'com_componentbuilder'))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback = false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback = false;
								}
							}
							elseif ($user->authorise($view.'edit.own', 'com_componentbuilder'))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback = false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback = false;
								}
							}
						}
					}
				}
			}
			// if allowed then fallback on component global settings
			if ($fallback)
			{
				$result->set($action->name, $user->authorise($action->name, 'com_componentbuilder'));
			}
		}
		return $result;
	}
	
	public static function checkJson($string)
	{
		if (self::checkString($string))
		{
			json_decode($string);
			return (json_last_error() === JSON_ERROR_NONE);
		}
		return false;
	}

	public static function checkObject($object)
	{
		if (isset($object) && is_object($object) && count($object) > 0)
		{
			return true;
		}
		return false;
	}

	public static function checkArray($array, $removeEmptyString = false)
	{
		if (isset($array) && is_array($array) && count($array) > 0)
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
				return self::checkArray($array, false);
			}
			return true;
		}
		return false;
	}

	public static function checkString($string)
	{
		if (isset($string) && is_string($string) && strlen($string) > 0)
		{
			return true;
		}
		return false;
	}
	
	/**
	*	Check if we are connected
	*	Thanks https://stackoverflow.com/a/4860432/1429677
	*
	*	@returns bool true on success
	**/
	public static function isConnected()
	{
		// If example.com is down, then probably the whole internet is down, since IANA maintains the domain. Right?
		$connected = @fsockopen("www.example.com", 80); 
			// website, port  (try 80 or 443)
		if ($connected)
		{
			//action when connected
			$is_conn = true;
			fclose($connected);
		}
		else
		{
			//action in connection failure
			$is_conn = false;
		}
		return $is_conn;
	}

	public static function mergeArrays($arrays)
	{
		if(self::checkArray($arrays))
		{
			$arrayBuket = array();
			foreach ($arrays as $array)
			{
				if (self::checkArray($array))
				{
					$arrayBuket = array_merge($arrayBuket, $array);
				}
			}
			return $arrayBuket;
		}
		return false;
	}

	// typo sorry!
	public static function sorten($string, $length = 40, $addTip = true)
	{
		return self::shorten($string, $length, $addTip);
	}

	public static function shorten($string, $length = 40, $addTip = true)
	{
		if (self::checkString($string))
		{
			$initial = strlen($string);
			$words = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
			$words_count = count($words);

			$word_length = 0;
			$last_word = 0;
			for (; $last_word < $words_count; ++$last_word)
			{
				$word_length += strlen($words[$last_word]);
				if ($word_length > $length)
				{
					break;
				}
			}

			$newString	= implode(array_slice($words, 0, $last_word));
			$final	= strlen($newString);
			if ($initial != $final && $addTip)
			{
				$title = self::shorten($string, 400 , false);
				return '<span class="hasTip" title="'.$title.'" style="cursor:help">'.trim($newString).'...</span>';
			}
			elseif ($initial != $final && !$addTip)
			{
				return trim($newString).'...';
			}
		}
		return $string;
	}

	public static function safeString($string, $type = 'L', $spacer = '_', $replaceNumbers = true)
	{
		if ($replaceNumbers === true)
		{
			// remove all numbers and replace with english text version (works well only up to millions)
			$string = self::replaceNumbers($string);
		}
		// 0nly continue if we have a string
		if (self::checkString($string))
		{
			// create file name without the extention that is safe
			if ($type === 'filename')
			{
				// make sure VDM is not in the string
				$string = str_replace('VDM', 'vDm', $string);
				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_()
				// If you don't need to handle multi-byte characters
				// you can use preg_replace rather than mb_ereg_replace
				// Thanks @Łukasz Rysiak!
				// $string = mb_ereg_replace("([^\w\s\d\-_\(\)])", '', $string);
				$string = preg_replace("([^\w\s\d\-_\(\)])", '', $string);
				// http://stackoverflow.com/a/2021729/1429677
				return preg_replace('/\s+/', ' ', $string);
			}
			// remove all other characters
			$string = trim($string);
			$string = preg_replace('/'.$spacer.'+/', ' ', $string);
			$string = preg_replace('/\s+/', ' ', $string);
			$string = preg_replace("/[^A-Za-z ]/", '', $string);
			// select final adaptations
			if ($type === 'L' || $type === 'strtolower')
			{
				// replace white space with underscore
				$string = preg_replace('/\s+/', $spacer, $string);
				// default is to return lower
				return strtolower($string);
			}
			elseif ($type === 'W')
			{
				// return a string with all first letter of each word uppercase(no undersocre)
				return ucwords(strtolower($string));
			}
			elseif ($type === 'w' || $type === 'word')
			{
				// return a string with all lowercase(no undersocre)
				return strtolower($string);
			}
			elseif ($type === 'Ww' || $type === 'Word')
			{
				// return a string with first letter of the first word uppercase and all the rest lowercase(no undersocre)
				return ucfirst(strtolower($string));
			}
			elseif ($type === 'WW' || $type === 'WORD')
			{
				// return a string with all the uppercase(no undersocre)
				return strtoupper($string);
			}
			elseif ($type === 'U' || $type === 'strtoupper')
			{
				// replace white space with underscore
				$string = preg_replace('/\s+/', $spacer, $string);
				// return all upper
				return strtoupper($string);
			}
			elseif ($type === 'F' || $type === 'ucfirst')
			{
				// replace white space with underscore
				$string = preg_replace('/\s+/', $spacer, $string);
				// return with first caracter to upper
				return ucfirst(strtolower($string));
			}
			elseif ($type === 'cA' || $type === 'cAmel' || $type === 'camelcase')
			{
				// convert all words to first letter uppercase
				$string = ucwords(strtolower($string));
				// remove white space
				$string = preg_replace('/\s+/', '', $string);
				// now return first letter lowercase
				return lcfirst($string);
			}
			// return string
			return $string;
		}
		// not a string
		return '';
	}

	public static function htmlEscape($var, $charset = 'UTF-8', $shorten = false, $length = 40)
	{
		if (self::checkString($var))
		{
			$filter = new JFilterInput();
			$string = $filter->clean(html_entity_decode(htmlentities($var, ENT_COMPAT, $charset)), 'HTML');
			if ($shorten)
			{
           		return self::shorten($string,$length);
			}
			return $string;
		}
		else
		{
			return '';
		}
	}

	public static function replaceNumbers($string)
	{
		// set numbers array
		$numbers = array();
		// first get all numbers
		preg_match_all('!\d+!', $string, $numbers);
		// check if we have any numbers
		if (isset($numbers[0]) && self::checkArray($numbers[0]))
		{
			foreach ($numbers[0] as $number)
			{
				$searchReplace[$number] = self::numberToString((int)$number);
			}
			// now replace numbers in string
			$string = str_replace(array_keys($searchReplace), array_values($searchReplace),$string);
			// check if we missed any, strange if we did.
			return self::replaceNumbers($string);
		}
		// return the string with no numbers remaining.
		return $string;
	}
	
	/**
	*	Convert an integer into an English word string
	*	Thanks to Tom Nicholson <http://php.net/manual/en/function.strval.php#41988>
	*
	*	@input	an int
	*	@returns a string
	**/
	public static function numberToString($x)
	{
		$nwords = array( "zero", "one", "two", "three", "four", "five", "six", "seven",
			"eight", "nine", "ten", "eleven", "twelve", "thirteen",
			"fourteen", "fifteen", "sixteen", "seventeen", "eighteen",
			"nineteen", "twenty", 30 => "thirty", 40 => "forty",
			50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty",
			90 => "ninety" );

		if(!is_numeric($x))
		{
			$w = $x;
		}
		elseif(fmod($x, 1) != 0)
		{
			$w = $x;
		}
		else
		{
			if($x < 0)
			{
				$w = 'minus ';
				$x = -$x;
			}
			else
			{
				$w = '';
				// ... now $x is a non-negative integer.
			}

			if($x < 21)   // 0 to 20
			{
				$w .= $nwords[$x];
			}
			elseif($x < 100)  // 21 to 99
			{ 
				$w .= $nwords[10 * floor($x/10)];
				$r = fmod($x, 10);
				if($r > 0)
				{
					$w .= ' '. $nwords[$r];
				}
			}
			elseif($x < 1000)  // 100 to 999
			{
				$w .= $nwords[floor($x/100)] .' hundred';
				$r = fmod($x, 100);
				if($r > 0)
				{
					$w .= ' and '. self::numberToString($r);
				}
			}
			elseif($x < 1000000)  // 1000 to 999999
			{
				$w .= self::numberToString(floor($x/1000)) .' thousand';
				$r = fmod($x, 1000);
				if($r > 0)
				{
					$w .= ' ';
					if($r < 100)
					{
						$w .= 'and ';
					}
					$w .= self::numberToString($r);
				}
			} 
			else //  millions
			{    
				$w .= self::numberToString(floor($x/1000000)) .' million';
				$r = fmod($x, 1000000);
				if($r > 0)
				{
					$w .= ' ';
					if($r < 100)
					{
						$w .= 'and ';
					}
					$w .= self::numberToString($r);
				}
			}
		}
		return $w;
	}

	/**
	*	Random Key
	*
	*	@returns a string
	**/
	public static function randomkey($size)
	{
		$bag = "abcefghijknopqrstuwxyzABCDDEFGHIJKLLMMNOPQRSTUVVWXYZabcddefghijkllmmnopqrstuvvwxyzABCEFGHIJKNOPQRSTUWXYZ";
		$key = array();
		$bagsize = strlen($bag) - 1;
		for ($i = 0; $i < $size; $i++)
		{
			$get = rand(0, $bagsize);
			$key[] = $bag[$get];
		}
		return implode($key);
	}

	public static function getCryptKey($type, $default = null)
	{
		if ('basic' === $type)
		{
			// Get the global params
			$params = JComponentHelper::getParams('com_componentbuilder', true);
			$basic_key = $params->get('basic_key', $default);
			if ($basic_key)
			{
				return $basic_key;
			}
		}
		return false;
	}
}
