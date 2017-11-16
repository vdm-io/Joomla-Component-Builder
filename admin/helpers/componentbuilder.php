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
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder component helper.
 */
abstract class ComponentbuilderHelper
{

	/**
	*	The Global Admin Event Method.
	**/
	public static function globalEvent($document)
	{
		// the Session keeps track of all data related to the current session of this user
		self::loadSession();
	} 

	/*
	 * Convert repeatable field to subform
	 * 
	 * @param   array    $item       The array to convert
	 * @param   string   $name      The main field name
	 * @param   array   $updater    The updater (dynamic) option
	 *
	 * @return  array
	 */
	public static function convertRepeatable($item, $name)
	{
		// continue only if we have an array
		if (self::checkArray($item))
		{
			$bucket = array();
			foreach ($item as $key => $values)
			{
				foreach ($values as $nr => $value)
				{
					if (!isset($bucket[$name . $nr]) || !self::checkArray($bucket[$name . $nr]))
					{
						$bucket[$name . $nr] = array();
					}
					$bucket[$name . $nr][$key] = $value;
				}
			}
			return $bucket;
		}
		return $item;
	}

	/**
	* 	The global updater
	**/
	protected static $globalUpdater = array();

	/*
	 * Convert repeatable field to subform
	 * 
	 * @param   object     $item            The item to update
	 * @param   array      $searcher        The fields to check and update
	 * @param   array      $updater         To update the local table
	 *
	 * @return void
	 */
	public static function convertRepeatableFields($object, $searcher, $updater = array())
	{
		// update the repeatable fields
		foreach ($searcher as  $key => $sleutel)
		{
			$isJson = false;
			if (isset($object->{$key}) && self::checkJson($object->{$key}))
			{
				$object->{$key} = json_decode($object->{$key}, true);
				$isJson = true;
			}
			// check if this is old values for repeatable fields
			if (self::checkArray($object->{$key}) && isset($object->{$key}[$sleutel]))
			{
				// load it back
				$object->{$key} = self::convertRepeatable($object->{$key}, $key);
				// add to global updater
				if (
					self::checkArray($object->{$key}) && self::checkArray($updater) && 
					(
						( isset($updater['table']) && isset($updater['val']) && isset($updater['key']) ) || 
						( isset($updater['unique']) && isset($updater['unique'][$key]) && isset($updater['unique'][$key]['table']) && isset($updater['unique'][$key]['val']) && isset($updater['unique'][$key]['key']) )
					)
				   )
				{
					$_key = null;
					$_value = null;
					$_table = null;
					// check if we have unique id table for this repeatable/subform field
					if ( isset($updater['unique']) && isset($updater['unique'][$key]) && isset($updater['unique'][$key]['table']) && isset($updater['unique'][$key]['val']) && isset($updater['unique'][$key]['key']) )
					{
						$_key = $updater['unique'][$key]['key'];
						$_value = $updater['unique'][$key]['val'];
						$_table = $updater['unique'][$key]['table'];
					}
					elseif ( isset($updater['table']) && isset($updater['val']) && isset($updater['key']) )
					{
						$_key = $updater['key'];
						$_value = $updater['val'];
						$_table = $updater['table'];
					}
					// continue only if values are valid
					if (self::checkString($_table) && self::checkString($_key) && $_value > 0)
					{
						// set target table & item
						$target = trim($_table) . '.' . trim($_key) . '.' . trim($_value);
						if (!isset(self::$globalUpdater[$target]))
						{
							self::$globalUpdater[$target] = new stdClass;
							self::$globalUpdater[$target]->{$_key} = (int) $_value;
						}
						// load the new subform values to global updater
						self::$globalUpdater[$target]->{$key} = json_encode($object->{$key});
					}
				}
			}
			// no set back to json if came in as json
			if (isset($object->{$key}) && $isJson && self::checkArray($object->{$key}))
			{
				$object->{$key} = json_encode($object->{$key}); 
			}
			// remove if not json or array
			elseif (isset($object->{$key}) && !self::checkArray($object->{$key}) && !self::checkJson($object->{$key}))
			{
				unset($object->{$key});
			}
		}
		return $object;
	}

	/**
	 * Run Global Updater if any are set
	 * 
	 * @return  void
	 * 
	 */
	public static function runGlobalUpdater()
	{
		// check if any updates are set to run
		if (self::checkArray(self::$globalUpdater))
		{
			// get the database object
			$db = JFactory::getDbo();
			foreach (self::$globalUpdater as $tableKeyID => $object)
			{
				// get the table
				$table = explode('.', $tableKeyID);
				// update the item
				$db->updateObject('#__componentbuilder_' . (string) $table[0] , $object, (string) $table[1]);
			}
			// rest updater
			self::$globalUpdater = array();
		}
	}

	/**
	 * Copy Any Item (only use for direct database copying)
	 * 
	 * @param   int        $id         The item to copy
	 * @param   string   $table     The table and model to copy from and with
	 * @param   array    $config   The values that should change
	 *
	 * @return  boolean   True if success
	 * 
	 */
	public static function copyItem($id, $type, $config = array())
	{
		// only continue if we have an id
		if ((int) $id > 0)
		{
			// get the model
			$model = self::getModel($type);
			$app   = \JFactory::getApplication();
			// get item
			if ($item = $model->getItem($id))
			{
				// update values that should change
				if (self::checkArray($config))
				{
					foreach($config as $key => $value)
					{
						if (isset($item->{$key}))
						{
							$item->{$key} = $value;
						}
					}
				}
				// clone the object
				$data = array();
				foreach ($item as $key => $value)
				{
					$data[$key] = $value;
				}			
				// reset some values
				$data['id'] = 0;
				$data['version'] = 1;
				if (isset($data['tags']))
				{
					$data['tags'] = null;
				}
				if (isset($data['associations']))
				{
					$data['associations'] = array();
				}
				// remove some unneeded values
				unset($data['params']);
				unset($data['asset_id']);
				unset($data['checked_out']);
				unset($data['checked_out_time']);
				// Attempt to save the data.
				if ($model->save($data))
				{
					return true;
				}
			}
		}
		return false;
	} 

	/**
	* 	The global params
	**/
	protected static $params = false;

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
			
	public static function getImportScripts($type, $fieldName = false)
	{
		// if field name is pased the convert to type
		if ($fieldName)
		{
			$fieldNames = array(
				'php_import_display' => 'display',
				'php_import_setdata' => 'setdata',
				'php_import_save' => 'save',
				'html_import_view' => 'view',
				'php_import' => 'import',
				'php_import_ext' => 'ext'
			);
			// first check if the field name is found
			if (isset($fieldNames[$type]))
			{
				$type = $fieldNames[$type];
			}
			else
			{
				return '';
			}
		}
		$script = array();
		if ('display' === $type)
		{
			// set the display script
			$script['display'][] = "\tprotected \$headerList;";
			$script['display'][] = "\tprotected \$hasPackage = false;";
			$script['display'][] = "\tprotected \$headers;";
			$script['display'][] = "\tprotected \$hasHeader = 0;";
			$script['display'][] = "\tprotected \$dataType;";
			$script['display'][] = "\n\tpublic function display(\$tpl = null)";
			$script['display'][] = "\t{";
			$script['display'][] = "\t\tif (\$this->getLayout() !== 'modal')";
			$script['display'][] = "\t\t{";
			$script['display'][] = "\t\t\t// Include helper submenu";
			$script['display'][] = "\t\t\t###-#-#-Component###Helper::addSubmenu('import');";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t\$paths = new stdClass;";
			$script['display'][] = "\t\t\$paths->first = '';";
			$script['display'][] = "\t\t\$state = \$this->get('state');";
			$script['display'][] = "\n\t\t\$this->paths = &\$paths;";
			$script['display'][] = "\t\t\$this->state = &\$state;";
			$script['display'][] = "\t\t// get global action permissions";
			$script['display'][] = "\t\t\$this->canDo = ###-#-#-Component###Helper::getActions('import');";
			$script['display'][] = "\n\t\t// We don't need toolbar in the modal window.";
			$script['display'][] = "\t\tif (\$this->getLayout() !== 'modal')";
			$script['display'][] = "\t\t{";
			$script['display'][] = "\t\t\t\$this->addToolbar();";
			$script['display'][] = "\t\t\t\$this->sidebar = JHtmlSidebar::render();";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t// get the session object";
			$script['display'][] = "\t\t\$session = JFactory::getSession();";
			$script['display'][] = "\t\t// check if it has package";
			$script['display'][] = "\t\t\$this->hasPackage \t= \$session->get('hasPackage', false);";
			$script['display'][] = "\t\t\$this->dataType \t= \$session->get('dataType', false);";
			$script['display'][] = "\t\tif(\$this->hasPackage && \$this->dataType)";
			$script['display'][] = "\t\t{";
			$script['display'][] = "\t\t\t\$this->headerList \t= json_decode(\$session->get(\$this->dataType.'_VDM_IMPORTHEADERS', false),true);";
			$script['display'][] = "\t\t\t\$this->headers \t\t= ###-#-#-Component###Helper::getFileHeaders(\$this->dataType);";
			$script['display'][] = "\t\t\t// clear the data type";
			$script['display'][] = "\t\t\t\$session->clear('dataType');";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t// Check for errors.";
			$script['display'][] = "\t\tif (count(\$errors = \$this->get('Errors'))){";
			$script['display'][] = "\t\t\tthrow new Exception(implode(".'"\n", $errors), 500);';
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t// Display the template";
			$script['display'][] = "\t\tparent::display(\$tpl);";
			$script['display'][] = "\t}";
		}
		elseif ('setdata' === $type)
		{
			// set the setdata script
			$script['setdata'] = array();
			$script['setdata'][] = "\t/**";
			$script['setdata'][] = "\t* Set the data from the spreadsheet to the database";
			$script['setdata'][] = "\t*";
			$script['setdata'][] = "\t* @param string  \$package Paths to the uploaded package file";
			$script['setdata'][] = "\t*";
			$script['setdata'][] = "\t* @return  boolean false on failure";
			$script['setdata'][] = "\t*";
			$script['setdata'][] = "\t**/";
			$script['setdata'][] = "\tprotected function setData(\$package,\$table,\$target_headers)";
			$script['setdata'][] = "\t{";
			$script['setdata'][] = "\t\tif (###-#-#-Component###Helper::checkArray(\$target_headers))";
			$script['setdata'][] = "\t\t{";
			$script['setdata'][] = "\t\t\t// make sure the file is loaded\t\t";
			$script['setdata'][] = "\t\t\tJLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$script['setdata'][] = "\t\t\t\$jinput = JFactory::getApplication()->input;";
			$script['setdata'][] = "\t\t\tforeach(\$target_headers as \$header)";
			$script['setdata'][] = "\t\t\t{";
			$script['setdata'][] = "\t\t\t\t\$data['target_headers'][\$header] = \$jinput->getString(\$header, null);";
			$script['setdata'][] = "\t\t\t}";
			$script['setdata'][] = "\t\t\t// set the data";
			$script['setdata'][] = "\t\t\tif(isset(\$package['dir']))";
			$script['setdata'][] = "\t\t\t{";
			$script['setdata'][] = "\t\t\t\t\$inputFileType = PHPExcel_IOFactory::identify(\$package['dir']);";
			$script['setdata'][] = "\t\t\t\t\$excelReader = PHPExcel_IOFactory::createReader(\$inputFileType);";
			$script['setdata'][] = "\t\t\t\t\$excelReader->setReadDataOnly(true);";
			$script['setdata'][] = "\t\t\t\t\$excelObj = \$excelReader->load(\$package['dir']);";
			$script['setdata'][] = "\t\t\t\t\$data['array'] = \$excelObj->getActiveSheet()->toArray(null, true,true,true);";
			$script['setdata'][] = "\t\t\t\t\$excelObj->disconnectWorksheets();";
			$script['setdata'][] = "\t\t\t\tunset(\$excelObj);";
			$script['setdata'][] = "\t\t\t\treturn \$this->save(\$data,\$table);";
			$script['setdata'][] = "\t\t\t}";
			$script['setdata'][] = "\t\t}";
			$script['setdata'][] = "\t\treturn false;";
			$script['setdata'][] = "\t}";
		}
		elseif ('save' === $type)
		{
			$script['save'] = array();
			$script['save'][] = "\t/**";
			$script['save'][] = "\t* Save the data from the file to the database";
			$script['save'][] = "\t*";
			$script['save'][] = "\t* @param string  \$package Paths to the uploaded package file";
			$script['save'][] = "\t*";
			$script['save'][] = "\t* @return  boolean false on failure";
			$script['save'][] = "\t*";
			$script['save'][] = "\t**/";
			$script['save'][] = "\tprotected function save(\$data,\$table)";
			$script['save'][] = "\t{";
			$script['save'][] = "\t\t// import the data if there is any";
			$script['save'][] = "\t\tif(###-#-#-Component###Helper::checkArray(\$data['array']))";
			$script['save'][] = "\t\t{";
			$script['save'][] = "\t\t\t// get user object";
			$script['save'][] = "\t\t\t\$user  \t\t= JFactory::getUser();";
			$script['save'][] = "\t\t\t// remove header if it has headers";
			$script['save'][] = "\t\t\t\$id_key \t= \$data['target_headers']['id'];";
			$script['save'][] = "\t\t\t\$published_key \t= \$data['target_headers']['published'];";
			$script['save'][] = "\t\t\t\$ordering_key \t= \$data['target_headers']['ordering'];";
			$script['save'][] = "\t\t\t// get the first array set";
			$script['save'][] = "\t\t\t\$firstSet = reset(\$data['array']);";
			$script['save'][] = "";
			$script['save'][] = "\t\t\t// check if first array is a header array and remove if true";
			$script['save'][] = "\t\t\tif(\$firstSet[\$id_key] == 'id' || \$firstSet[\$published_key] == 'published' || \$firstSet[\$ordering_key] == 'ordering')";
			$script['save'][] = "\t\t\t{";
			$script['save'][] = "\t\t\t\tarray_shift(\$data['array']);";
			$script['save'][] = "\t\t\t}";
			$script['save'][] = "\t\t\t";
			$script['save'][] = "\t\t\t// make sure there is still values in array and that it was not only headers";
			$script['save'][] = "\t\t\tif(###-#-#-Component###Helper::checkArray(\$data['array']) && \$user->authorise(\$table.'.import', 'com_###-#-#-component###') && \$user->authorise('core.import', 'com_###-#-#-component###'))";
			$script['save'][] = "\t\t\t{";
			$script['save'][] = "\t\t\t\t// set target.";
			$script['save'][] = "\t\t\t\t\$target\t= array_flip(\$data['target_headers']);";
			$script['save'][] = "\t\t\t\t// Get a db connection.";
			$script['save'][] = "\t\t\t\t\$db = JFactory::getDbo();";
			$script['save'][] = "\t\t\t\t// set some defaults";
			$script['save'][] = "\t\t\t\t\$todayDate\t\t= JFactory::getDate()->toSql();";
			$script['save'][] = "\t\t\t\t// get global action permissions";
			$script['save'][] = "\t\t\t\t\$canDo\t\t\t= ###-#-#-Component###Helper::getActions(\$table);";
			$script['save'][] = "\t\t\t\t\$canEdit\t\t= \$canDo->get('core.edit');";
			$script['save'][] = "\t\t\t\t\$canState\t\t= \$canDo->get('core.edit.state');";
			$script['save'][] = "\t\t\t\t\$canCreate\t\t= \$canDo->get('core.create');";
			$script['save'][] = "\t\t\t\t\$hasAlias\t\t= \$this->getAliasesUsed(\$table);";
			$script['save'][] = "\t\t\t\t// prosses the data";
			$script['save'][] = "\t\t\t\tforeach(\$data['array'] as \$row)";
			$script['save'][] = "\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\$found = false;";
			$script['save'][] = "\t\t\t\t\tif (isset(\$row[\$id_key]) && is_numeric(\$row[\$id_key]) && \$row[\$id_key] > 0)";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t// raw items import & update!";
			$script['save'][] = "\t\t\t\t\t\t\$query = \$db->getQuery(true);";
			$script['save'][] = "\t\t\t\t\t\t\$query";
			$script['save'][] = "\t\t\t\t\t\t\t->select('version')";
			$script['save'][] = "\t\t\t\t\t\t\t->from(\$db->quoteName('#__###-#-#-component###_'.\$table))";
			$script['save'][] = "\t\t\t\t\t\t\t->where(\$db->quoteName('id') . ' = '. \$db->quote(\$row[\$id_key]));";
			$script['save'][] = "\t\t\t\t\t\t// Reset the query using our newly populated query object.";
			$script['save'][] = "\t\t\t\t\t\t\$db->setQuery(\$query);";
			$script['save'][] = "\t\t\t\t\t\t\$db->execute();";
			$script['save'][] = "\t\t\t\t\t\t\$found = \$db->getNumRows();";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t";
			$script['save'][] = "\t\t\t\t\tif(\$found && \$canEdit)";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t// update item";
			$script['save'][] = "\t\t\t\t\t\t\$id \t\t= \$row[\$id_key];";
			$script['save'][] = "\t\t\t\t\t\t\$version\t= \$db->loadResult();";
			$script['save'][] = "\t\t\t\t\t\t// reset all buckets";
			$script['save'][] = "\t\t\t\t\t\t\$query \t\t= \$db->getQuery(true);";
			$script['save'][] = "\t\t\t\t\t\t\$fields \t= array();";
			$script['save'][] = "\t\t\t\t\t\t// Fields to update.";
			$script['save'][] = "\t\t\t\t\t\tforeach(\$row as \$key => \$cell)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t// ignore column";
			$script['save'][] = "\t\t\t\t\t\t\tif ('IGNORE' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update modified";
			$script['save'][] = "\t\t\t\t\t\t\tif ('modified_by' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update modified";
			$script['save'][] = "\t\t\t\t\t\t\tif ('modified' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update version";
			$script['save'][] = "\t\t\t\t\t\t\tif ('version' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$cell = (int) \$version + 1;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// verify publish authority";
			$script['save'][] = "\t\t\t\t\t\t\tif ('published' == \$target[\$key] && !\$canState)";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// set to update array";
			$script['save'][] = "\t\t\t\t\t\t\tif(in_array(\$key, \$data['target_headers']) && is_numeric(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$fields[] = \$db->quoteName(\$target[\$key]) . ' = ' . \$cell;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_string(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$fields[] = \$db->quoteName(\$target[\$key]) . ' = ' . \$db->quote(\$cell);";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_null(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t// if import data is null then set empty";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$fields[] = \$db->quoteName(\$target[\$key]) . \" = ''\";";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t// load the defaults";
			$script['save'][] = "\t\t\t\t\t\t\$fields[]\t= \$db->quoteName('modified_by') . ' = ' . \$db->quote(\$user->id);";
			$script['save'][] = "\t\t\t\t\t\t\$fields[]\t= \$db->quoteName('modified') . ' = ' . \$db->quote(\$todayDate);";
			$script['save'][] = "\t\t\t\t\t\t// Conditions for which records should be updated.";
			$script['save'][] = "\t\t\t\t\t\t\$conditions = array(";
			$script['save'][] = "\t\t\t\t\t\t\t\$db->quoteName('id') . ' = ' . \$id";
			$script['save'][] = "\t\t\t\t\t\t);";
			$script['save'][] = "\t\t\t\t\t\t";
			$script['save'][] = "\t\t\t\t\t\t\$query->update(\$db->quoteName('#__###-#-#-component###_'.\$table))->set(\$fields)->where(\$conditions);";
			$script['save'][] = "\t\t\t\t\t\t\$db->setQuery(\$query);";
			$script['save'][] = "\t\t\t\t\t\t\$db->execute();";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\telseif (\$canCreate)";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t// insert item";
			$script['save'][] = "\t\t\t\t\t\t\$query = \$db->getQuery(true);";
			$script['save'][] = "\t\t\t\t\t\t// reset all buckets";
			$script['save'][] = "\t\t\t\t\t\t\$columns \t= array();";
			$script['save'][] = "\t\t\t\t\t\t\$values \t= array();";
			$script['save'][] = "\t\t\t\t\t\t\$version\t= false;";
			$script['save'][] = "\t\t\t\t\t\t// Insert columns. Insert values.";
			$script['save'][] = "\t\t\t\t\t\tforeach(\$row as \$key => \$cell)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t// ignore column";
			$script['save'][] = "\t\t\t\t\t\t\tif ('IGNORE' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// remove id";
			$script['save'][] = "\t\t\t\t\t\t\tif ('id' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update created";
			$script['save'][] = "\t\t\t\t\t\t\tif ('created_by' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update created";
			$script['save'][] = "\t\t\t\t\t\t\tif ('created' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// Make sure the alias is incremented";
			$script['save'][] = "\t\t\t\t\t\t\tif ('alias' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$cell = \$this->getAlias(\$cell,\$table);";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update version";
			$script['save'][] = "\t\t\t\t\t\t\tif ('version' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$cell = 1;";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$version = true;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// set to insert array";
			$script['save'][] = "\t\t\t\t\t\t\tif(in_array(\$key, \$data['target_headers']) && is_numeric(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$columns[] \t= \$target[\$key];";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$values[] \t= \$cell;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_string(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$columns[] \t= \$target[\$key];";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$values[] \t= \$db->quote(\$cell);";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_null(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t// if import data is null then set empty";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$columns[] \t= \$target[\$key];";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$values[] \t= \"''\";";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t// load the defaults";
			$script['save'][] = "\t\t\t\t\t\t\$columns[] \t= 'created_by';";
			$script['save'][] = "\t\t\t\t\t\t\$values[] \t= \$db->quote(\$user->id);";
			$script['save'][] = "\t\t\t\t\t\t\$columns[] \t= 'created';";
			$script['save'][] = "\t\t\t\t\t\t\$values[] \t= \$db->quote(\$todayDate);";
			$script['save'][] = "\t\t\t\t\t\tif (!\$version)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\$columns[] \t= 'version';";
			$script['save'][] = "\t\t\t\t\t\t\t\$values[] \t= 1;";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t// Prepare the insert query.";
			$script['save'][] = "\t\t\t\t\t\t\$query";
			$script['save'][] = "\t\t\t\t\t\t\t->insert(\$db->quoteName('#__###-#-#-component###_'.\$table))";
			$script['save'][] = "\t\t\t\t\t\t\t->columns(\$db->quoteName(\$columns))";
			$script['save'][] = "\t\t\t\t\t\t\t->values(implode(',', \$values));";
			$script['save'][] = "\t\t\t\t\t\t// Set the query using our newly populated query object and execute it.";
			$script['save'][] = "\t\t\t\t\t\t\$db->setQuery(\$query);";
			$script['save'][] = "\t\t\t\t\t\t\$done = \$db->execute();";
			$script['save'][] = "\t\t\t\t\t\tif (\$done)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\$aId = \$db->insertid();";
			$script['save'][] = "\t\t\t\t\t\t\t// make sure the access of asset is set";
			$script['save'][] = "\t\t\t\t\t\t\t###-#-#-Component###Helper::setAsset(\$aId,\$table);";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\telse";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\treturn false;";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t}";
			$script['save'][] = "\t\t\t\treturn true;";
			$script['save'][] = "\t\t\t}";
			$script['save'][] = "\t\t}";
			$script['save'][] = "\t\treturn false;";
			$script['save'][] = "\t}";
		}
		elseif ('view' === $type)
		{
			$script['view'] = array();
			$script['view'][] = "<script type=\"text/javascript\">";
			$script['view'][] = "<?php if (\$this->hasPackage && ###-#-#-Component###Helper::checkArray(\$this->headerList)) : ?>";
			$script['view'][] = "\tJoomla.continueImport = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "\t\tvar error = false;";
			$script['view'][] = "\t\tvar therequired = [<?php \$i = 0; foreach(\$this->headerList as \$name => \$title) { echo (\$i != 0)? ', \"vdm_'.\$name.'\"':'\"vdm_'.\$name.'\"'; \$i++; } ?>];";
			$script['view'][] = "\t\tfor(i = 0; i < therequired.length; i++)";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tif(jQuery('#'+therequired[i]).val() == \"\" )";
			$script['view'][] = "\t\t\t{";
			$script['view'][] = "\t\t\t\terror = true;";
			$script['view'][] = "\t\t\t\tbreak;";
			$script['view'][] = "\t\t\t}";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\t// do field validation";
			$script['view'][] = "\t\tif (error)";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'continue';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "<?php else: ?>";
			$script['view'][] = "\tJoomla.submitbutton = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t// do field validation";
			$script['view'][] = "\t\tif (form.import_package.value == \"\")";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_PLEASE_SELECT_A_FILE', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'upload';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "";
			$script['view'][] = "\n\tJoomla.submitbutton3 = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t// do field validation";
			$script['view'][] = "\t\tif (form.import_directory.value == \"\"){";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'folder';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "";
			$script['view'][] = "\n\tJoomla.submitbutton4 = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t// do field validation";
			$script['view'][] = "\t\tif (form.import_url.value == \"\" || form.import_url.value == \"http://\")";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_ENTER_A_URL', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'url';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "<?php endif; ?>";
			$script['view'][] = "";
			$script['view'][] = "\n// Add spindle-wheel for importations:";
			$script['view'][] = "jQuery(document).ready(function(\$) {";
			$script['view'][] = "\tvar outerDiv = \$('body');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\$('<div id=\"loading\"></div>')";
			$script['view'][] = "\t\t.css(\"background\", \"rgba(255, 255, 255, .8) url('components/com_###-#-#-component###/assets/images/import.gif') 50% 15% no-repeat\")";
			$script['view'][] = "\t\t.css(\"top\", outerDiv.position().top - \$(window).scrollTop())";
			$script['view'][] = "\t\t.css(\"left\", outerDiv.position().left - \$(window).scrollLeft())";
			$script['view'][] = "\t\t.css(\"width\", outerDiv.width())";
			$script['view'][] = "\t\t.css(\"height\", outerDiv.height())";
			$script['view'][] = "\t\t.css(\"position\", \"fixed\")";
			$script['view'][] = "\t\t.css(\"opacity\", \"0.80\")";
			$script['view'][] = "\t\t.css(\"-ms-filter\", \"progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)\")";
			$script['view'][] = "\t\t.css(\"filter\", \"alpha(opacity = 80)\")";
			$script['view'][] = "\t\t.css(\"display\", \"none\")";
			$script['view'][] = "\t\t.appendTo(outerDiv);";
			$script['view'][] = "});";
			$script['view'][] = "";
			$script['view'][] = "\n</script>";
			$script['view'][] = "";
			$script['view'][] = "\n<div id=\"installer-import\" class=\"clearfix\">";
			$script['view'][] = "<form enctype=\"multipart/form-data\" action=\"<?php echo JRoute::_('index.php?option=com_###-#-#-component###&view=import_###-#-#-views###');?>\" method=\"post\" name=\"adminForm\" id=\"adminForm\" class=\"form-horizontal form-validate\">";
			$script['view'][] = "";
			$script['view'][] = "\n\t<?php if (!empty( \$this->sidebar)) : ?>";
			$script['view'][] = "\t\t<div id=\"j-sidebar-container\" class=\"span2\">";
			$script['view'][] = "\t\t\t<?php echo \$this->sidebar; ?>";
			$script['view'][] = "\t\t</div>";
			$script['view'][] = "\t\t<div id=\"j-main-container\" class=\"span10\">";
			$script['view'][] = "\t<?php else : ?>";
			$script['view'][] = "\t\t<div id=\"j-main-container\">";
			$script['view'][] = "\t<?php endif;?>";
			$script['view'][] = "";
			$script['view'][] = "\n\t<?php if (\$this->hasPackage && ###-#-#-Component###Helper::checkArray(\$this->headerList) && ###-#-#-Component###Helper::checkArray(\$this->headers)) : ?>";
			$script['view'][] = "\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_LINK_FILE_TO_TABLE_COLUMNS'); ?></legend>";
			$script['view'][] = "\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t<label class=\"control-label\" ><h4><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_TABLE_COLUMNS'); ?></h4></label>";
			$script['view'][] = "\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t<label class=\"control-label\" ><h4><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FILE_COLUMNS'); ?></h4></label>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t</div>";
			$script['view'][] = "\t\t\t<?php foreach(\$this->headerList as \$name => \$title): ?>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"<?php echo \$name; ?>\" class=\"control-label\" ><?php echo \$title; ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<select  name=\"<?php echo \$name; ?>\"  id=\"vdm_<?php echo \$name; ?>\" required class=\"required input_box\" >";
			$script['view'][] = "\t\t\t\t\t\t\t<option value=\"\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_PLEASE_SELECT_COLUMN'); ?></option>";
			$script['view'][] = "\t\t\t\t\t\t\t<option value=\"IGNORE\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_IGNORE_COLUMN'); ?></option>";
			$script['view'][] = "\t\t\t\t\t\t\t<?php foreach(\$this->headers as \$value => \$option): ?>";
			$script['view'][] = "\t\t\t\t\t\t\t\t<?php \$selected = (strtolower(\$option) ==  strtolower (\$title) || strtolower(\$option) == strtolower(\$name))? 'selected=\"selected\"':''; ?>";
			$script['view'][] = "\t\t\t\t\t\t\t\t<option value=\"<?php echo ###-#-#-Component###Helper::htmlEscape(\$value); ?>\" class=\"required\" <?php echo \$selected ?>><?php echo ###-#-#-Component###Helper::htmlEscape(\$option); ?></option>";
			$script['view'][] = "\t\t\t\t\t\t\t<?php endforeach; ?>";
			$script['view'][] = "\t\t\t\t\t\t</select>";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t<?php endforeach; ?>";
			$script['view'][] = "\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t<input class=\"btn btn-primary\" type=\"button\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_CONTINUE'); ?>\" onclick=\"Joomla.continueImport()\" />";
			$script['view'][] = "\t\t\t</div>";
			$script['view'][] = "\t\t</fieldset>";
			$script['view'][] = "\t\t<input type=\"hidden\" name=\"gettype\" value=\"continue\" />";
			$script['view'][] = "\t<?php else: ?>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'upload')); ?>";
			$script['view'][] = "\t\t";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'upload', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FROM_UPLOAD', true)); ?>";
			$script['view'][] = "\t\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPDATE_DATA'); ?></legend>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"import_package\" class=\"control-label\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_SELECT_FILE'); ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<input class=\"input_box\" id=\"import_package\" name=\"import_package\" type=\"file\" size=\"57\" />";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t\t<input class=\"btn btn-primary\" type=\"button\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPLOAD_BOTTON'); ?>\" onclick=\"Joomla.submitbutton()\" />&nbsp;&nbsp;&nbsp;<small><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FORMATS_ACCEPTED'); ?> (.csv .xls .ods)</small>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t</fieldset>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$script['view'][] = "\t\t";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'directory', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FROM_DIRECTORY', true)); ?>";
			$script['view'][] = "\t\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPDATE_DATA'); ?></legend>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"import_directory\" class=\"control-label\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_SELECT_FILE_DIRECTORY'); ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<input type=\"text\" id=\"import_directory\" name=\"import_directory\" class=\"span5 input_box\" size=\"70\" value=\"<?php echo \$this->state->get('import.directory'); ?>\" />";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t\t<input type=\"button\" class=\"btn btn-primary\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_GET_BOTTON'); ?>\" onclick=\"Joomla.submitbutton3()\" />&nbsp;&nbsp;&nbsp;<small><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FORMATS_ACCEPTED'); ?> (.csv .xls .ods)</small>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</fieldset>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'url', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FROM_URL', true)); ?>";
			$script['view'][] = "\t\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPDATE_DATA'); ?></legend>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"import_url\" class=\"control-label\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_SELECT_FILE_URL'); ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<input type=\"text\" id=\"import_url\" name=\"import_url\" class=\"span5 input_box\" size=\"70\" value=\"http://\" />";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t\t<input type=\"button\" class=\"btn btn-primary\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_GET_BOTTON'); ?>\" onclick=\"Joomla.submitbutton4()\" />&nbsp;&nbsp;&nbsp;<small><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FORMATS_ACCEPTED'); ?> (.csv .xls .ods)</small>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t</fieldset>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$script['view'][] = "\t\t<input type=\"hidden\" name=\"gettype\" value=\"upload\" />";
			$script['view'][] = "\t<?php endif; ?>";
			$script['view'][] = "\t<input type=\"hidden\" name=\"task\" value=\"import_###-#-#-views###.import\" />";
			$script['view'][] = "\t<?php echo JHtml::_('form.token'); ?>";
			$script['view'][] = "</form>";
			$script['view'][] = "</div>";
		}
		elseif ('import' === $type)
		{
			$script['import'] = array();
			$script['import'][] = "\t/**";
			$script['import'][] = "\t * Import an spreadsheet from either folder, url or upload.";
			$script['import'][] = "\t *";
			$script['import'][] = "\t * @return  boolean result of import";
			$script['import'][] = "\t *";
			$script['import'][] = "\t */";
			$script['import'][] = "\tpublic function import()";
			$script['import'][] = "\t{";
			$script['import'][] = "\t\t\$this->setState('action', 'import');";
			$script['import'][] = "\t\t\$app \t\t= JFactory::getApplication();";
			$script['import'][] = "\t\t\$session \t= JFactory::getSession();";
			$script['import'][] = "\t\t\$package \t= null;";
			$script['import'][] = "\t\t\$continue\t= false;";
			$script['import'][] = "\t\t// get import type";
			$script['import'][] = "\t\t\$this->getType = \$app->input->getString('gettype', NULL);";
			$script['import'][] = "\t\t// get import type";
			$script['import'][] = "\t\t\$this->dataType\t= \$session->get('dataType_VDM_IMPORTINTO', NULL);";
			$script['import'][] = "\n\t\tif (\$package === null)";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\tswitch (\$this->getType)";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t\tcase 'folder':";
			$script['import'][] = "\t\t\t\t\t// Remember the 'Import from Directory' path.";
			$script['import'][] = "\t\t\t\t\t\$app->getUserStateFromRequest(\$this->_context . '.import_directory', 'import_directory');";
			$script['import'][] = "\t\t\t\t\t\$package = \$this->_getPackageFromFolder();";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tcase 'upload':";
			$script['import'][] = "\t\t\t\t\t\$package = \$this->_getPackageFromUpload();";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tcase 'url':";
			$script['import'][] = "\t\t\t\t\t\$package = \$this->_getPackageFromUrl();";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tcase 'continue':";
			$script['import'][] = "\t\t\t\t\t\$continue \t= true;";
			$script['import'][] = "\t\t\t\t\t\$package\t= \$session->get('package', null);";
			$script['import'][] = "\t\t\t\t\t\$package\t= json_decode(\$package, true);";
			$script['import'][] = "\t\t\t\t\t// clear session";
			$script['import'][] = "\t\t\t\t\t\$session->clear('package');";
			$script['import'][] = "\t\t\t\t\t\$session->clear('dataType');";
			$script['import'][] = "\t\t\t\t\t\$session->clear('hasPackage');";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tdefault:";
			$script['import'][] = "\t\t\t\t\t\$app->setUserState('com_###-#-#-component###.message', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_NO_IMPORT_TYPE_FOUND'));";
			$script['import'][] = "\n\t\t\t\t\treturn false;";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\t// Was the package valid?";
			$script['import'][] = "\t\tif (!\$package || !\$package['type'])";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\tif (in_array(\$this->getType, array('upload', 'url')))";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t\t\$this->remove(\$package['packagename']);";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\n\t\t\t\$app->setUserState('com_###-#-#-component###.message', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE'));";
			$script['import'][] = "\t\t\treturn false;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\t";
			$script['import'][] = "\t\t// first link data to table headers";
			$script['import'][] = "\t\tif(!\$continue){";
			$script['import'][] = "\t\t\t\$package\t= json_encode(\$package);";
			$script['import'][] = "\t\t\t\$session->set('package', \$package);";
			$script['import'][] = "\t\t\t\$session->set('dataType', \$this->dataType);";
			$script['import'][] = "\t\t\t\$session->set('hasPackage', true);";
			$script['import'][] = "\t\t\treturn true;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\t// set the data";
			$script['import'][] = "\t\t\$headerList = json_decode(\$session->get(\$this->dataType.'_VDM_IMPORTHEADERS', false), true);";
			$script['import'][] = "\t\tif (!\$this->setData(\$package,\$this->dataType,\$headerList))";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\t// There was an error importing the package";
			$script['import'][] = "\t\t\t\$msg = JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_ERROR');";
			$script['import'][] = "\t\t\t\$back = \$session->get('backto_VDM_IMPORT', NULL);";
			$script['import'][] = "\t\t\tif (\$back)";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t\t\$app->setUserState('com_###-#-#-component###.redirect_url', 'index.php?option=com_###-#-#-component###&view='.\$back);";
			$script['import'][] = "\t\t\t\t\$session->clear('backto_VDM_IMPORT');";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\t\t\t\$result = false;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\telse";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\t// Package imported sucessfully";
			$script['import'][] = "\t\t\t\$msg = JTe-#-#-xt::sprintf('COM_###-#-#-COMPONENT###_IMPORT_SUCCESS', \$package['packagename']);";
			$script['import'][] = "\t\t\t\$back = \$session->get('backto_VDM_IMPORT', NULL);";
			$script['import'][] = "\t\t\tif (\$back)";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t    \$app->setUserState('com_###-#-#-component###.redirect_url', 'index.php?option=com_###-#-#-component###&view='.\$back);";
			$script['import'][] = "\t\t\t    \$session->clear('backto_VDM_IMPORT');";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\t\t\t\$result = true;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\n\t\t// Set some model state values";
			$script['import'][] = "\t\t\$app->enqueueMessage(\$msg);";
			$script['import'][] = "\n\t\t// remove file after import";
			$script['import'][] = "\t\t\$this->remove(\$package['packagename']);";
			$script['import'][] = "\t\t\$session->clear(\$this->getType.'_VDM_IMPORTHEADERS');";
			$script['import'][] = "\t\treturn \$result;";
			$script['import'][] = "\t}";
		}
		elseif ('ext' === $type)
		{
			$script['ext'][] = "\t/**";
			$script['ext'][] = "\t * Check the extension";
			$script['ext'][] = "\t *";
			$script['ext'][] = "\t * @param   string  \$file    Name of the uploaded file";
			$script['ext'][] = "\t *";
			$script['ext'][] = "\t * @return  boolean  True on success";
			$script['ext'][] = "\t *";
			$script['ext'][] = "\t */";
			$script['ext'][] = "\tprotected function checkExtension(\$file)";
			$script['ext'][] = "\t{";
			$script['ext'][] = "\t\t// check the extention";
			$script['ext'][] = "\t\tswitch(strtolower(pathinfo(\$file, PATHINFO_EXTENSION)))";
			$script['ext'][] = "\t\t{";
			$script['ext'][] = "\t\t\tcase 'xls':";
			$script['ext'][] = "\t\t\tcase 'ods':";
			$script['ext'][] = "\t\t\tcase 'csv':";
			$script['ext'][] = "\t\t\treturn true;";
			$script['ext'][] = "\t\t\tbreak;";
			$script['ext'][] = "\t\t}";
			$script['ext'][] = "\t\treturn false;";
			$script['ext'][] = "\t}";
		}
		// return the needed script
		if (isset($script[$type]))
		{
			return str_replace('-#-#-', '', implode("\n",$script[$type]));
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
		}
		return $none;
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
			if ((NULL !== $params->get("showContributor".$nr)) && ($params->get("showContributor".$nr) == 1 || $params->get("showContributor".$nr) == 3))
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
		$query->where('a.admin_view = '.$db->quote($view));
		$query->where('a.location = 1');
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
	*	Configure the Linkbar.
	**/
	public static function addSubmenu($submenu)
	{
                // load user for access menus
                $user = JFactory::getUser();
                // load the submenus to sidebar
                JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_DASHBOARD'), 'index.php?option=com_componentbuilder&view=componentbuilder', $submenu === 'componentbuilder');
		// Access control (compiler.submenu).
		if ($user->authorise('compiler.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_COMPILER'), 'index.php?option=com_componentbuilder&view=compiler', $submenu === 'compiler');
		}
		if ($user->authorise('joomla_component.access', 'com_componentbuilder') && $user->authorise('joomla_component.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_JOOMLA_COMPONENTS'), 'index.php?option=com_componentbuilder&view=joomla_components', $submenu === 'joomla_components');
		}
		if ($user->authorise('admin_view.access', 'com_componentbuilder') && $user->authorise('admin_view.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_ADMIN_VIEWS'), 'index.php?option=com_componentbuilder&view=admin_views', $submenu === 'admin_views');
		}
		if ($user->authorise('custom_admin_view.access', 'com_componentbuilder') && $user->authorise('custom_admin_view.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_CUSTOM_ADMIN_VIEWS'), 'index.php?option=com_componentbuilder&view=custom_admin_views', $submenu === 'custom_admin_views');
		}
		if ($user->authorise('site_view.access', 'com_componentbuilder') && $user->authorise('site_view.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_SITE_VIEWS'), 'index.php?option=com_componentbuilder&view=site_views', $submenu === 'site_views');
		}
		if ($user->authorise('template.access', 'com_componentbuilder') && $user->authorise('template.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_TEMPLATES'), 'index.php?option=com_componentbuilder&view=templates', $submenu === 'templates');
		}
		if ($user->authorise('layout.access', 'com_componentbuilder') && $user->authorise('layout.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_LAYOUTS'), 'index.php?option=com_componentbuilder&view=layouts', $submenu === 'layouts');
		}
		if ($user->authorise('dynamic_get.access', 'com_componentbuilder') && $user->authorise('dynamic_get.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_DYNAMIC_GETS'), 'index.php?option=com_componentbuilder&view=dynamic_gets', $submenu === 'dynamic_gets');
		}
		if ($user->authorise('custom_code.access', 'com_componentbuilder') && $user->authorise('custom_code.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_CUSTOM_CODES'), 'index.php?option=com_componentbuilder&view=custom_codes', $submenu === 'custom_codes');
		}
		if ($user->authorise('snippet.access', 'com_componentbuilder') && $user->authorise('snippet.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_SNIPPETS'), 'index.php?option=com_componentbuilder&view=snippets', $submenu === 'snippets');
		}
		if ($user->authorise('field.access', 'com_componentbuilder') && $user->authorise('field.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_FIELDS'), 'index.php?option=com_componentbuilder&view=fields', $submenu === 'fields');
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_FIELD_FIELD_CATEGORY'), 'index.php?option=com_categories&view=categories&extension=com_componentbuilder.fields', $submenu === 'categories.fields');
		}
		if ($user->authorise('fieldtype.access', 'com_componentbuilder') && $user->authorise('fieldtype.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_FIELDTYPES'), 'index.php?option=com_componentbuilder&view=fieldtypes', $submenu === 'fieldtypes');
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_FIELDTYPE_FIELDTYPE_CATEGORY'), 'index.php?option=com_categories&view=categories&extension=com_componentbuilder.fieldtypes', $submenu === 'categories.fieldtypes');
		}
		if ($user->authorise('language_translation.access', 'com_componentbuilder') && $user->authorise('language_translation.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_LANGUAGE_TRANSLATIONS'), 'index.php?option=com_componentbuilder&view=language_translations', $submenu === 'language_translations');
		}
		if ($user->authorise('language.access', 'com_componentbuilder') && $user->authorise('language.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_LANGUAGES'), 'index.php?option=com_componentbuilder&view=languages', $submenu === 'languages');
		}
		if ($user->authorise('ftp.access', 'com_componentbuilder') && $user->authorise('ftp.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_FTPS'), 'index.php?option=com_componentbuilder&view=ftps', $submenu === 'ftps');
		}
		if ($user->authorise('help_document.access', 'com_componentbuilder') && $user->authorise('help_document.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_HELP_DOCUMENTS'), 'index.php?option=com_componentbuilder&view=help_documents', $submenu === 'help_documents');
		}
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

	/**
	 * Prepares the xml document
	 */
	public static function xls($rows,$fileName = null,$title = null,$subjectTab = null,$creator = 'Vast Development Method',$description = null,$category = null,$keywords = null,$modified = null)
	{
		// set the user
		$user = JFactory::getUser();
		
		// set fieldname if not set
		if (!$fileName)
		{
			$fileName = 'exported_'.JFactory::getDate()->format('jS_F_Y');
		}
		// set modiefied if not set
		if (!$modified)
		{
			$modified = $user->name;
		}
		// set title if not set
		if (!$title)
		{
			$title = 'Book1';
		}
		// set tab name if not set
		if (!$subjectTab)
		{
			$subjectTab = 'Sheet1';
		}
		
		// make sure the file is loaded		
		JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator($creator)
									 ->setCompany('Vast Development Method')
									 ->setLastModifiedBy($modified)
									 ->setTitle($title)
									 ->setSubject($subjectTab);
		if (!$description)
		{
			$objPHPExcel->getProperties()->setDescription($description);
		}
		if (!$keywords)
		{
			$objPHPExcel->getProperties()->setKeywords($keywords);
		}
		if (!$category)
		{
			$objPHPExcel->getProperties()->setCategory($category);
		}
		
		// Some styles
		$headerStyles = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '1171A3'),
				'size'  => 12,
				'name'  => 'Verdana'
		));
		$sideStyles = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '444444'),
				'size'  => 11,
				'name'  => 'Verdana'
		));
		$normalStyles = array(
			'font'  => array(
				'color' => array('rgb' => '444444'),
				'size'  => 11,
				'name'  => 'Verdana'
		));
		
		// Add some data
		if (self::checkArray($rows))
		{
			$i = 1;
			foreach ($rows as $array){
				$a = 'A';
				foreach ($array as $value){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($a.$i, $value);
					if ($i == 1){
						$objPHPExcel->getActiveSheet()->getColumnDimension($a)->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->applyFromArray($headerStyles);
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					} elseif ($a === 'A'){
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->applyFromArray($sideStyles);
					} else {
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->applyFromArray($normalStyles);
					}
					$a++;
				}
				$i++;
			}
		}
		else
		{
			return false;
		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($subjectTab);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client's web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		jexit();
	}
	
	/**
	* Get CSV Headers
	*/
	public static function getFileHeaders($dataType)
	{		
		// make sure these files are loaded		
		JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
		JLoader::import('ChunkReadFilter', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/PHPExcel/Reader');
		// get session object
		$session	= JFactory::getSession();
		$package	= $session->get('package', null);
		$package	= json_decode($package, true);
		// set the headers
		if(isset($package['dir']))
		{
			$chunkFilter = new PHPExcel_Reader_chunkReadFilter();
			// only load first three rows
			$chunkFilter->setRows(2,1);
			// identify the file type
			$inputFileType = PHPExcel_IOFactory::identify($package['dir']);
			// create the reader for this file type
			$excelReader = PHPExcel_IOFactory::createReader($inputFileType);
			// load the limiting filter
			$excelReader->setReadFilter($chunkFilter);
			$excelReader->setReadDataOnly(true);
			// load the rows (only first three)
			$excelObj = $excelReader->load($package['dir']);
			$headers = array();
			foreach ($excelObj->getActiveSheet()->getRowIterator() as $row)
			{
				if($row->getRowIndex() == 1)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell)
					{
						if (!is_null($cell))
						{
							$headers[$cell->getColumn()] = $cell->getValue();
						}
					}
					$excelObj->disconnectWorksheets();
					unset($excelObj);
					break;
				}
			}
			return $headers;
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
			$fallback= true;
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
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
						elseif ($user->authorise($view.'edit.own', 'com_componentbuilder.'.$view.'.' . (int) $record->id))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
						elseif ($user->authorise('core.edit.own', 'com_componentbuilder'))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
						elseif ($user->authorise($view.'edit.own', 'com_componentbuilder'))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
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
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
							elseif ($user->authorise($view.'edit.own', 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
							elseif ($user->authorise('core.edit.own', 'com_componentbuilder'))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
							elseif ($user->authorise($view.'edit.own', 'com_componentbuilder'))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
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

	/**
	*	Get any component's model
	**/
	public static function getModel($name, $path = JPATH_COMPONENT_ADMINISTRATOR, $component = 'componentbuilder')
	{
		// load the model file
		JModelLegacy::addIncludePath( $path . '/models' );
		// get instance
		$model = JModelLegacy::getInstance( $name, $component.'Model' );
		// if model not found
		if ($model == false)
		{
			// build class name
			$class = $prefix.$name;
			// initilize the model
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
