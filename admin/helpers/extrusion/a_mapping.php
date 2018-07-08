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

	@version			1.0.0
	@created		26th December, 2016
	@package		Component Builder
	@subpackage		mapping.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Mapping class
 */
class Mapping
{
	/**
	 *	Some default fields
	 */
	protected	$buildcompsql;
	public		$id;
	public		$name_code;
	public		$addadmin_views;
	public		$addSql = array();
	public		$source = array();
	public		$sql = array();
	
	/**
	 *	The map of the needed fields and views
	 */
	public $map;
	
	/**
	 *	The app to load messages mostly
	 */
	public $app;
	
	/**
	 *	The needed set of keys needed to set
	 */
	protected $setting = array('id' => 'default', 'buildcompsql' => 'base64', 'name_code' => 'safeString');
	
	/**
	 *	The needed set of keys needed to set
	 */
	protected $notRequiered = array('id', 'asset_id', 'published', 
		'created_by', 'modified_by', 'created', 'modified', 'checked_out','checked_out_time',
		'version', 'hits', 'access', 'ordering', 
		'metakey', 'metadesc', 'metadata', 'params');
	
	/**
	 *	The datatypes and it linked field types (basic)
	 *	(TODO) We may need to set this dynamicly
	 */
	protected $dataTypes = array(	'VARCHAR' => 'Text', 'CHAR' => 'Text',
		'MEDIUMTEXT' => 'Textarea', 'LONGTEXT'  => 'Textarea',
		'TEXT' => 'Textarea', 'DATETIME' => 'Calendar',
		'DATE' => 'Text', 'TIME' => 'Text', 'TINYINT' => 'Text',
		'BIGINT' => 'Text', 'INT' => 'Text',  'FLOAT' => 'Text',
		'DECIMAL' => 'Text', 'DOUBLE' => 'Text');
	
	/**
	 *	The datasize identifiers
	 */
	protected $dataSize = array(
		'CHAR', 'VARCHAR', 'INT', 'TINYINT',
		'BIGINT', 'FLOAT', 'DECIMAL', 'DOUBLE');
	
	/**
	 *	The default identifiers
	 */
	protected $defaults = array(0, 1, "CURRENT_TIMESTAMP", "DATETIME"); // Other
	
	/**
	 *	The sizes identifiers
	 */
	protected $sizes = array("1", "7", "10", "11", "50", "64", "100", "255", "1024", "2048"); // Other

	
	/**
	 *	Constructor
	 */
	public function __construct($data = false)
	{
		// set the app to insure messages can be set
		$this->app = JFactory::getApplication();
		// check that we have data
		if (ComponentbuilderHelper::checkArray($data))
		{
			// make sure we have an id
			if (isset($data['id']) && $data['id'] > 0)
			{
				if (isset($data['buildcomp']) && 1 == $data['buildcomp'] && isset($data['buildcompsql']))
				{
					foreach ($data as $key => $value)
					{
						if (isset($this->setting[$key]))
						{
							switch($this->setting[$key])
							{
								case 'base64':
									// set needed value
									$this->$key = base64_decode($value);
									break;
								case 'json':
									// set needed value
									$this->$key = json_decode($value, true);
									break;
								case 'safeString':
									// set needed value
									$this->$key = ComponentbuilderHelper::safeString($value);
									break;
								default :
									$this->$key = $value;
									break;
							}
						}
					}
					// get linked admin views
					$addadmin_views = ComponentbuilderHelper::getVar('component_admin_views', $data['id'], 'joomla_component', 'addadmin_views');
					if (ComponentbuilderHelper::checkJson($addadmin_views))
					{
						$this->addadmin_views = json_decode($addadmin_views, true);
					}
					// set the map of the views needed
					if ($this->setMap())
					{
						return true;
					}
					$this->app->enqueueMessage(
						JText::_('No "CREATE TABLE.." were found, please check your sql.'),
						'Error'
					);
					return false;
				}
				return false; // not set so just return without any error
			}
			$this->app->enqueueMessage(
				JText::_('Please try again, this error usualy happens if it is a new component, beacues we need a component ID to do this build with your sql dump.'),
				'Error'
			);
			return false;
		}
		$this->app->enqueueMessage(
			JText::_('Could not find the data needed to continue.'),
			'Error'
		);
		return false;
	}

	/**
	 *	The mapping function
	 *	To Map the views and fields that are needed
	 */
	protected function setMap()
	{
		// start parsing the sql dump data
		$queries = JDatabaseDriver::splitSql($this->buildcompsql);
		if (ComponentbuilderHelper::checkArray($queries))
		{
			foreach ($queries as $query)
			{
				// only use create table queries
				if (strpos($query, 'CREATE TABLE IF NOT EXISTS') !== false ||
					strpos($query, 'CREATE TABLE') !== false)
				{
					if ($tableName = $this->getTableName($query))
					{
						// now get the fields/columns of this view/table
						if ($fields = $this->getFields($query))
						{
							// make sure it is all lower case from here on
							$tableName = strtolower($tableName);
							$this->map[$tableName] = $fields;
						}
					}
					else
					{
						continue;
					}
				}
				// get the insert data if set
				if (strpos($query, 'INSERT INTO `') !== false)
				{					
					if ($tableName = $this->getTableName($query))
					{
						$this->addSql[$tableName] = 1;
						$this->source[$tableName] = 2;
						$this->sql[$tableName] = $query;
					}
				}
			}
			// check if the mapping was done
			if (ComponentbuilderHelper::checkArray($this->map))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 *	Get the table name
	 */
	protected function getTableName(&$query)
	{
		if (strpos($query, '`#__') !== false)
		{
			// get table name
			$tableName = ComponentbuilderHelper::getBetween($query, '`#__', "`");
		}
		elseif (strpos($query, "'#__") !== false)
		{
			// get table name
			$tableName = ComponentbuilderHelper::getBetween($query, "'#__", "'");
		}
		// if it still was not found
		if (!isset($tableName) || !ComponentbuilderHelper::checkString($tableName))
		{
			// skip this query
			return false;
		}
		// clean the table name (so only view name remain)
		if (strpos($tableName, $this->name_code) !== false)
		{
			$tableName = trim(str_replace($this->name_code, '', $tableName), '_');
		}
		// if found
		if (ComponentbuilderHelper::checkString($tableName))
		{
			return $tableName;
		}
		// skip this query
		return false;
	}

	/**
	 *	Get the field details
	 */
	protected function getFields(&$query)
	{	
		$rows = array_map('trim', explode(PHP_EOL, $query));
		$fields = array();
		foreach ($rows as $row)
		{
			// make sure we have a lower case string
			$row = strtoupper($row);
			$field = array();
			$name = '';
			if (0 === strpos($row, '`'))
			{
				// get field name
				$name = ComponentbuilderHelper::getBetween($row, '`', '`');
			}
			if (0 === strpos($row, "'"))
			{
				// get field name
				$name = ComponentbuilderHelper::getBetween($row, "'", "'");
			}
			// check if the name was found
			if (ComponentbuilderHelper::checkString($name))
			{
				// insure we have the name in lower case from here on
				$name = strtolower($name);
				// only continue if field is requered
				if (in_array($name, $this->notRequiered))
				{
					continue;
				}
				// check if the field type is found
				if ($fieldType = $this->getType($row, $field, $name))
				{
					$field['row']		= $row;
					$field['name']		= $name;
					$field['label']		= ComponentbuilderHelper::safeString($name, 'W');
					$field['fieldType']	= $fieldType;
					$field['size']		= $this->getSize($row, $field);
					$field['sizeOther']	= '';
					if (!in_array($field['size'], $this->sizes))
					{
						if (ComponentbuilderHelper::checkString($field['size']))
						{
							$field['sizeOther'] = $field['size'];
							$field['size'] = 'Other';
						}
					}
					$field['default']	= $this->getDefault($row);
					$field['defaultOther']	= '';
					if (!in_array($field['default'], $this->defaults))
					{
						if (ComponentbuilderHelper::checkString($field['default']))
						{
							$field['defaultOther'] = $field['default'];
							$field['default'] = 'Other';
						}
					}
					$field['null']		= $this->getNullValue($row, $field);
					// check if field is a key
					$field['key']		= $this->getKeyStatus($rows, $name);
					// load to fields
					$fields[] = $field;
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($fields))
		{
			return $fields;
		}
		return false;
	}

	/**
	 *	Get the field types
	 */
	protected function getType($row, &$field, &$name)
	{
		// first remove field name
		$row = str_replace($name, '', $row);
		// get the data type first
		foreach ($this->dataTypes as $type => $fieldType)
		{
			if (strpos($row, $type) !== false)
			{
				$field['dataType'] = $type;
				return $fieldType;
			}
		}
		return false;
	}

	/**
	 *	Get the field size
	 */
	protected function getSize(&$row, $field)
	{
		if (in_array($field['dataType'], $this->dataSize))
		{
			return ComponentbuilderHelper::getBetween($row, $field['dataType'].'(', ')');
		}
		return '';
	}

	/**
	 *	Get the field default
	 */
	protected function getDefault(&$row)
	{
		// get default value
		if (strpos($row, 'DEFAULT "') !== false) // to sure it this is correct...
		{
			return ComponentbuilderHelper::getBetween($row, 'DEFAULT "', '"');
		}
		// get default value
		if (strpos($row, "DEFAULT '") !== false)
		{
			return ComponentbuilderHelper::getBetween($row, "DEFAULT '", "'");
		}
		return '';
	}

	/**
	 *	Get the field Null Value
	 */
	protected function getNullValue(&$row, &$field)
	{
		// get the result of null
		if (strpos($row, 'NOT NULL') !== false)
		{
			return 'NOT NULL';
		}
		if (strpos($row, 'DEFAULT NULL') !== false)
		{
			$field['default'] = 'NULL';
			return '';
		}
		return 'NULL';
	}

	/**
	 *	Get the field key status
	 */
	protected function getKeyStatus(&$rows, &$name)
	{
		// get the data type first
		foreach ($rows as $row)
		{
			if (strpos($row, 'UNIQUE KEY ') !== false && stripos($row, $name) !== false)
			{
				return 1;
			}
			if ((strpos($row, 'PRIMARY KEY ') !== false && stripos($row, $name) !== false) || (strpos($row, 'KEY ') !== false && stripos($row, $name) !== false))
			{
				return 2;
			}
		}
		return 0;
	}
}
