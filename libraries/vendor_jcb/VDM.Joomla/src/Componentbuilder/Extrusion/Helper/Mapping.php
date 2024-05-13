<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Helper;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseDriver;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\GetHelperExtrusion as GetHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Mapping class
 * 
 * @since 3.2.0
 */
class Mapping
{
	/**
	 *	Some default fields
	 */
	protected $buildcompsql;
	public $id;
	public $name_code;
	public array $addadmin_views;
	public array $addSql = [];
	public array $source = [];
	public array $sql = [];

	/**
	 *	The map of the needed fields and views
	 */
	public $map;

	/**
	 *	The app to load messages mostly
	 */
	public $app;

	/**
	 *	The database
	 */
	protected $db;

	/**
	 *	The needed set of keys needed to set
	 */
	protected array $setting = ['id' => 'default', 'buildcompsql' => 'base64', 'name_code' => 'safeString'];

	/**
	 *	The needed set of keys needed to set
	 */
	protected array $notRequired = [
		'id', 'asset_id', 'published', 
		'created_by', 'modified_by', 'created', 'modified', 'checked_out','checked_out_time',
		'version', 'hits', 'access', 'ordering', 
		'metakey', 'metadesc', 'metadata', 'params'
	];

	/**
	 *	The datatypes and it linked field types (basic)
	 *	(TODO) We may need to set this dynamicly
	 */
	protected array $dataTypes = [
		'VARCHAR' => 'Text', 'CHAR' => 'Text',
		'MEDIUMTEXT' => 'Textarea', 'LONGTEXT'  => 'Textarea',
		'TEXT' => 'Textarea', 'DATETIME' => 'Calendar',
		'DATE' => 'Text', 'TIME' => 'Text', 'TINYINT' => 'Text',
		'BIGINT' => 'Text', 'INT' => 'Text',  'FLOAT' => 'Text',
		'DECIMAL' => 'Text', 'DOUBLE' => 'Text'
	];

	/**
	 *	The datasize identifiers
	 */
	protected array $dataSize = [
		'CHAR', 'VARCHAR', 'INT', 'TINYINT',
		'BIGINT', 'FLOAT', 'DECIMAL', 'DOUBLE'
	];

	/**
	 *	The default identifiers
	 */
	protected $defaults = [
		'', 0, 1, "CURRENT_TIMESTAMP", "DATETIME"
	]; // Other

	/**
	 *	The sizes identifiers
	 */
	protected $sizes = [
		"1", "7", "10", "11", "50", "64", "100", "255", "1024", "2048"
	]; // Other

	/**
	 *	Constructor
	 */
	public function __construct($data = false)
	{
		// set the app to insure messages can be set
		$this->app = Factory::getApplication();

		// check that we have data
		if (ArrayHelper::check($data))
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
									$this->$key = base64_decode((string) $value);
									break;
								case 'json':
									// set needed value
									$this->$key = json_decode((string) $value, true);
									break;
								case 'safeString':
									// set needed value
									$this->$key = StringHelper::check($value);
									break;
								default :
									$this->$key = $value;
									break;
							}
						}
					}

					// get linked admin views
					$addadmin_views = GetHelper::var('component_admin_views', $data['id'], 'joomla_component', 'addadmin_views');
					if (JsonHelper::check($addadmin_views))
					{
						$this->addadmin_views = json_decode((string) $addadmin_views, true);
					}

					// set the map of the views needed
					if ($this->setMap())
					{
						return true;
					}
				}
				return false;
			}
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_PLEASE_TRY_AGAIN_THIS_ERROR_USUALLY_HAPPENS_IF_IT_IS_A_NEW_COMPONENT_BECAUSE_WE_NEED_A_COMPONENT_ID_TO_DO_THIS_BUILD_WITH_YOUR_SQL_DUMP'),
				'Error'
			);
			return false;
		}
		$this->app->enqueueMessage(
			Text::_('COM_COMPONENTBUILDER_COULD_NOT_FIND_THE_DATA_NEEDED_TO_CONTINUE'),
			'Error'
		);
		return false;
	}

	/**
	 *	The mapping function
	 *	To Map the views and fields that are needed
	 */
	protected function setMap(): bool
	{
		// set the database to make needed DB calls
		$this->db = Factory::getDbo();

		// start parsing the sql dump data
		$queries = DatabaseDriver::splitSql($this->buildcompsql);

		if (ArrayHelper::check($queries))
		{
			foreach ($queries as $sql)
			{
				// only use create table queries
				if (strpos($sql, 'CREATE TABLE IF NOT EXISTS') !== false ||
					strpos($sql, 'CREATE TABLE') !== false)
				{
					if (($tableName = $this->getTableName($sql)) !== null)
					{
						// now get the fields/columns of this view/table
						if (($fields = $this->getFields($sql)) !== null)
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
				if (strpos($sql, 'INSERT INTO `') !== false)
				{					
					if ($tableName = $this->getTableName($sql))
					{
						$tableName = strtolower($tableName);
						$this->addSql[$tableName] = 1;
						$this->source[$tableName] = 2;
						$this->sql[$tableName] = $sql;
					}
				}
			}

			// check if the mapping was done
			if (ArrayHelper::check($this->map))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 *	Get the table name
	 */
	protected function getTableName(string $sql): ?string
	{
		if (strpos($sql, '`#__') !== false)
		{
			// get table name
			$tableName = GetHelper::between($sql, '`#__', "`");
		}
		elseif (strpos($sql, "'#__") !== false)
		{
			// get table name
			$tableName = GetHelper::between($sql, "'#__", "'");
		}
		elseif (strpos($sql, "CREATE TABLE `") !== false)
		{
			// get table name
			$tableName = GetHelper::between($sql, "CREATE TABLE `", "`");
		}
		elseif (strpos($sql, "CREATE TABLE IF NOT EXISTS `") !== false)
		{
			// get table name
			$tableName = GetHelper::between($sql, "CREATE TABLE IF NOT EXISTS `", "`");
		}

		// if it still was not found
		if (!isset($tableName) || !StringHelper::check($tableName))
		{
			// skip this query
			return null;
		}

		// clean the table name (so only view name remain)
		if (strpos($tableName, $this->name_code) !== false)
		{
			$tableName = trim(str_replace($this->name_code, '', $tableName), '_');
		}

		// if found
		if (StringHelper::check($tableName))
		{
			return $tableName;
		}

		// skip this query
		return null;
	}

	/**
	 * Extracts the details of fields from a table based on SQL query.
	 *
	 * @param string $sql SQL query to create a table.
	 *
	 * @return array|null Returns an array of field details or null if no fields are found.
	 * @since 3.2.1
	 */
	protected function getFields(string $sql): ?array
	{
		$columns = $this->getColumns($sql);
		if ($columns === null)
		{
			return null;
		}

		$fields = [];
		foreach ($columns as $name => $data)
		{
			if (in_array(strtolower($name), $this->notRequired))
			{
				continue;
			}

			$fields[] = $this->prepareFieldDetails($name, $data);
		}

		return !empty($fields) ? $fields : null;
	}

	/**
	 * Prepares detailed array of field data.
	 *
	 * @param string $name Name of the field.
	 * @param object $data Data object containing field information.
	 *
	 * @return array Returns array containing detailed field information.
	 * @since 3.2.1
	 */
	protected function prepareFieldDetails(string $name, object $data): array
	{
		if (JsonHelper::check($data->Comment))
		{
			$data->config = json_decode($data->Comment);
		}

		$field = [
			'name' => $name,
			'label' => $this->getLabel($data, $name),
			'dataType' => $this->getDataType($data),
			'fieldType' => $this->getType($data),
			'size' => $this->getSize($data),
			'sizeOther' => '',
			'default' => $this->getDefault($data),
			'defaultOther' => '',
			'null' => $this->getNullValue($data),
			'key' => $this->getKeyStatus($data),
			'row' => $data
		];

		$this->handleSizeOther($field);
		$this->handleDefaultOther($field);

		return $field;
	}

	/**
	 * Handles non-standard sizes by setting appropriate labels.
	 *
	 * @param array $field Reference to the field array to update.
	 * @since 3.2.1
	 */
	protected function handleSizeOther(array &$field): void
	{
		if (!in_array($field['size'], $this->sizes) && !empty($field['size']))
		{
			$field['sizeOther'] = $field['size'];
			$field['size'] = 'Other';
		}
	}

	/**
	 * Handles non-standard defaults by setting appropriate labels.
	 *
	 * @param array $field Reference to the field array to update.
	 * @since 3.2.1
	 */
	protected function handleDefaultOther(array &$field): void
	{
		if (!in_array($field['default'], $this->defaults) && !empty($field['default']))
		{
			$field['defaultOther'] = $field['default'];
			$field['default'] = 'Other';
		}
	}

	/**
	 * Extracts columns from the SQL statement and retrieves details.
	 *
	 * @param string $sql SQL statement to extract column information.
	 *
	 * @return array|null Array of columns if successful, null otherwise.
	 * @since 3.2.1
	 */
	protected function getColumns(string $sql): ?array
	{
		$columnDefinitions = $this->extractColumnDefinitions($sql);
		if (!$columnDefinitions)
		{
			$this->app->enqueueMessage('Invalid SQL provided for table creation.', 'error');
			return null;
		}

		$tmpTableName = 'jcb_extrusion_' . uniqid();
		$createSql = "CREATE TABLE $tmpTableName ($columnDefinitions)";

		try
		{
			$this->db->setQuery($createSql)->execute();
			$columns = $this->db->getTableColumns($tmpTableName, false);

			$this->db->setQuery("DROP TABLE IF EXISTS $tmpTableName")->execute();

			return $columns;
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage($e->getMessage(), 'error');
			return null;
		}
	}

	/**
	 * Extracts the column definitions from the provided SQL statement.
	 *
	 * @param string $sql SQL statement for table creation.
	 *
	 * @return string|null Extracted column definitions as a string or null if definitions cannot be extracted.
	 * @since 3.2.1
	 */
	protected function extractColumnDefinitions(string $sql): ?string
	{
		$sql = preg_replace('/--.*?[\r\n]/', '', $sql); // Remove single-line comments
		$sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Remove multi-line comments
		$firstParenthesisPos = strpos($sql, '(');
		$lastParenthesisPos = strrpos($sql, ')');

		if ($firstParenthesisPos === false || $lastParenthesisPos === false)
		{
			return null;
		}

		return substr($sql, $firstParenthesisPos + 1, $lastParenthesisPos - $firstParenthesisPos - 1);
	}

	/**
	 * Retrieves the human-readable label for a field based on its metadata or name.
	 *
	 * @param object $data Field metadata.
	 * @param string $name Field name.
	 *
	 * @return string Human-readable label for the field.
	 * @since 3.2.1
	 */
	protected function getLabel(object $data, string $name): string
	{
		if (isset($data->config->label))
		{
			return $data->config->label;
		}

		return StringHelper::safe($name, 'W'); // Default label is the field name converted to title case
	}

	/**
	 * Determines the data type for a field based on its SQL type.
	 *
	 * @param object $data Field metadata containing type information.
	 *
	 * @return string Standardized data type.
	 * @since 3.2.1
	 */
	private function getDataType(object $data): string
	{
		if (preg_match('/^(\w+)/', $data->Type, $matches))
		{
			return strtoupper($matches[1]);
		}
		return 'TEXT'; // Default to TEXT if type cannot be determined
	}

	/**
	 * Determines the appropriate form field type for a data field based on its data type.
	 *
	 * @param object $data Field metadata.
	 *
	 * @return string Form field type suitable for the data type.
	 * @since 3.2.1
	 */
	protected function getType(object $data): string
	{
		if (isset($data->config->type))
		{
			return $data->config->type;
		}
		return $this->dataTypes[$data->Type] ?? 'Text'; // Default to 'Text' if no specific type is configured
	}

	/**
	 * Retrieves the size or dimensions of a field from its SQL type definition.
	 *
	 * @param object $data Field metadata containing type information.
	 *
	 * @return string|null Size or dimensions of the field, or null if not applicable.
	 * @since 3.2.1
	 */
	protected function getSize(object $data)
	{
		if (preg_match('/\((\d+)(?:,(\d+))?\)/', $data->Type, $matches))
		{
			return isset($matches[2]) ? "{$matches[1]},{$matches[2]}" : (int) $matches[1];
		}

		return null; // Return null if size information is not available
	}

	/**
	 * Determines the default value for a field from its metadata.
	 *
	 * @param object $data Field metadata.
	 *
	 * @return string Default value of the field.
	 * @since 3.2.1
	 */
	protected function getDefault(object $data): string
	{
		if (!empty($data->Default) && $data->Default !== "''")
		{
			return $data->Default;
		}
		return ''; // Return an empty string if no default is specified
	}

	/**
	 * Retrieves the nullability status of a field from its SQL definition.
	 *
	 * @param object $data Field metadata.
	 *
	 * @return string 'NOT NULL' if the field is not nullable, otherwise 'NULL'.
	 * @since 3.2.1
	 */
	protected function getNullValue(object $data): string
	{
		return strtoupper($data->Null) === 'NO' ? 'NOT NULL' : 'NULL';
	}

	/**
	 * Determines whether a field is a key and the type of key if applicable.
	 *
	 * @param object $data Field metadata.
	 *
	 * @return int Key status as an integer (0: not a key, 1: unique key, 2: primary key).
	 * @since 3.2.1
	 */
	protected function getKeyStatus(object $data): int
	{
		$key = strtoupper($data->Key);
		if ($key === 'PRI')
		{
			return 2; // Primary key
		}
		elseif ($key === 'UNI')
		{
			return 1; // Unique key
		}
		return 0; // Not a key
	}
}

