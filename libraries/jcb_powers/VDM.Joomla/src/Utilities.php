<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\MathHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Utilities\String\TypeHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Utilities\String\PluginHelper;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Basic shared utilities, a legacy implementation
 * 
 * @since  3.0.9
 */
trait Utilities
{
	/**
	 * The Main Active Language
	 * 
	 * @var      string
	 * 
	 * @since  3.0.9
	 */
	public static $langTag;

	/**
	 * Check if have a string with a length
	 *
	 * @input    string  $string The string to check
	 *
	 * @returns bool true on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use StringHelper::check($string);
	 */
	public static function checkString($string): bool
	{
		return StringHelper::check($string);
	}

	/**
	 * Shorten a string
	 *
	 * @input    string  $string That you would like to shorten
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use StringHelper::shorten($string, $length, $addTip);
	 */
	public static function shorten($string, $length = 40, $addTip = true)
	{
		return StringHelper::shorten($string, $length, $addTip);
	}

	/**
	 * Making strings safe (various ways)
	 *
	 * @input    string  $string That you would like to make safe
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use StringHelper::safe($string, $type, $spacer, $replaceNumbers, $keepOnlyCharacters);
	 */
	public static function safeString($string, $type = 'L', $spacer = '_', $replaceNumbers = true, $keepOnlyCharacters = true)
	{
		// set the local component option
		self::setComponentOption();

		return StringHelper::safe($string, $type, $spacer, $replaceNumbers, $keepOnlyCharacters);
	}

	/**
	 * Making class or function name safe
	 *
	 * @input	string       The name you would like to make safe
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use ClassfunctionHelper::safe($name);
	 */
	public static function safeClassFunctionName($name)
	{
		return ClassfunctionHelper::safe($name);
	}

	/**
	 * Making field names safe
	 *
	 * @input	string       The you would like to make safe
	 * @input	boolean      The switch to return an ALL UPPER CASE string
	 * @input	string       The string to use in white space
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use FieldHelper::safe($string, $allcap, $spacer);
	 */
	public static function safeFieldName($string, $allcap = false, $spacer = '_')
	{
		// set the local component option
		self::setComponentOption();

		return FieldHelper::safe($string, $allcap, $spacer);
	}

	/**
	 * Making field type name safe
	 *
	 * @input	string       The you would like to make safe
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use TypeHelper::safe($string);
	 */
	public static function safeTypeName($string)
	{
		// set the local component option
		self::setComponentOption();

		return TypeHelper::safe($string);
	}

	/**
	 * Making namespace safe
	 *
	 * @input	string       The you would like to make safe
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use NamespaceHelper::safe($string);
	 */
	public static function safeNamespace($string)
	{
		return NamespaceHelper::safe($string);
	}

	/**
	 * @since  3.0.9
	 * 
	 * @deprecated  4.0 - Use StringHelper::transliterate($string);
	 */
	public static function transliterate($string)
	{
		// set the local component option
		self::setComponentOption();

		return StringHelper::transliterate($string);
	}

	/**
	 * @since  3.0.9
	 * 
	 * @deprecated  4.0 - Use StringHelper::html($var, $charset, $shorten, $length);
	 */
	public static function htmlEscape($var, $charset = 'UTF-8', $shorten = false, $length = 40)
	{
		// set the local component option
		self::setComponentOption();

		return StringHelper::html($var, $charset, $shorten, $length);
	}

	/**
	 * @since  3.0.9
	 * 
	 * @deprecated  4.0 - Use StringHelper::numbers($string);
	 */
	public static function replaceNumbers($string)
	{
		return StringHelper::numbers($string);
	}

	/**
	 * Convert an integer into an English word string
	 * Thanks to Tom Nicholson <http://php.net/manual/en/function.strval.php#41988>
	 *
	 * @input    int $x an int
	 *
	 * @returns string a string
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use StringHelper::number($x);
	 */
	public static function numberToString($x)
	{
		return StringHelper::number($x);
	}

	/**
	 * Random Key
	 *
	 * @input int $size the length of the string
	 *
	 * @returns string a string of random characters
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use StringHelper::random($size);
	 */
	public static function randomkey($size): string
	{
		return StringHelper::random($size);
	}

	/**
	 * Check if you have a json string
	 *
	 * @input    string  $string  The json string to check
	 *
	 * @returns bool true on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use JsonHelper::check($string);
	 */
	public static function checkJson($string): bool
	{
		return JsonHelper::check($string);
	}

	/**
	 * @since  3.0.9
	 * 
	 * @deprecated  4.0 - Use JsonHelper::string($value, $sperator, $table, $id, $name);
	 */
	public static function jsonToString($value, $sperator = ", ", $table = null, $id = 'id', $name = 'name')
	{
		return JsonHelper::string($value, $sperator, $table, $id, $name);
	}

	/**
	 * Check if you have an array with a length
	 *
	 * @input    mixed $array              The array to check
	 * @input    bool  $removeEmptyString  Should we remove empty values
	 *
	 * @returns int  number of items in array on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use ArrayHelper::check($array, $removeEmptyString);
	 */
	public static function checkArray($array, $removeEmptyString = false): int
	{
		return ArrayHelper::check($array, $removeEmptyString);
	}

	/**
	 * Merge an array of array's
	 *
	 * @input    mixed  $arrays The arrays you would like to merge
	 *
	 * @returns mixed array on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use ArrayHelper::merge($arrays);
	 */
	public static function mergeArrays($arrays)
	{
		return ArrayHelper::merge($arrays);
	}

	/**
	 * Check if you have an object with a length
	 *
	 * @input    object $object  The object to check
	 *
	 * @returns bool true on success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use ObjectHelper::check($object);
	 */
	public static function checkObject($object): bool
	{
		return ObjectHelper::check($object);
	}

	/**
	 * Get a Variable 
	 *
	 * @param   string   $table        The table from which to get the variable
	 * @param   string   $where        The value where
	 * @param   string   $whereString  The target/field string where/name
	 * @param   string   $what         The return field
	 * @param   string   $operator     The operator between $whereString/field and $where/value
	 * @param   string   $main         The component in which the table is found
	 *
	 * @return  mix string/int/float
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GetHelper::var($table, $where, $whereString, $what, $operator, $main);
	 */
	public static function getVar($table, $where = null, $whereString = 'user', $what = 'id', $operator = '=', $main = null)
	{
		// set the local component option
		self::setComponentOption();

		return GetHelper::var($table, $where, $whereString, $what, $operator, $main);
	}

	/**
	 * Get array of variables
	 *
	 * @param   string   $table        The table from which to get the variables
	 * @param   string   $where        The value where
	 * @param   string   $whereString  The target/field string where/name
	 * @param   string   $what         The return field
	 * @param   string   $operator     The operator between $whereString/field and $where/value
	 * @param   string   $main         The component in which the table is found
	 * @param   bool     $unique       The switch to return a unique array
	 *
	 * @return  array
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GetHelper::vars($table, $where, $whereString, $what, $operator, $main, $unique);
	 */
	public static function getVars($table, $where = null, $whereString = 'user', $what = 'id', $operator = 'IN', $main = null, $unique = true)
	{
		// set the local component option
		self::setComponentOption();

		return GetHelper::vars($table, $where, $whereString, $what, $operator, $main, $unique);
	}

	/**
	 * get all strings between two other strings
	 *
	 * @param  string          $content    The content to search
	 * @param  string          $start        The starting value
	 * @param  string          $end         The ending value
	 *
	 * @return  array          On success
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GetHelper::allBetween($content, $start, $end);
	 */
	public static function getAllBetween($content, $start, $end)
	{
		return GetHelper::allBetween($content, $start, $end);
	}

	/**
	 * get a string between two other strings
	 * 
	 * @param  string          $content    The content to search
	 * @param  string          $start        The starting value
	 * @param  string          $end         The ending value
	 * @param  string          $default     The default value if none found
	 *
	 * @return  string          On success / empty string on failure
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GetHelper::between($content, $start, $end, $default);
	 */
	public static function getBetween($content, $start, $end, $default = '')
	{
		return GetHelper::between($content, $start, $end, $default);
	}

	/**
	 * bc math wrapper (very basic not for accounting)
	 *
	 * @param   string   $type    The type bc math
	 * @param   int      $val1    The first value
	 * @param   int      $val2    The second value
	 * @param   int      $scale   The scale value
	 *
	 * @return float|int
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use MathHelper::bc($type, $val1, $val2, $scale);
	 */
	public static function bcmath($type, $val1, $val2, $scale = 0)
	{
		return MathHelper::bc($type, $val1, $val2, $scale);
	}

	/**
	 * Basic sum of an array with more precision
	 *
	 * @param   array   $array    The values to sum
	 * @param   int      $scale   The scale value
	 *
	 * @return float|int
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use MathHelper::sum($array, $scale);
	 */
	public static function bcsum($array, $scale = 4)
	{
		return MathHelper::sum($array, $scale);
	}

        /**
         * create plugin class name
	 *
	 * @input	string       The group name
	 * @input	string       The name
	 *
	 * @return string
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use PluginHelper::safe($name, $group);
         */
        public static function createPluginClassName($group, $name)
	{
		return PluginHelper::safeClassName($name, $group);
	}

	/**
	 * Returns a GUIDv4 string
	 * 
	 * Thanks to Dave Pearson (and other)
	 * https://www.php.net/manual/en/function.com-create-guid.php#119168 
	 *
	 * Uses the best cryptographically secure method
	 * for all supported platforms with fallback to an older,
	 * less secure version.
	 *
	 * @param bool $trim
	 *
	 * @return string
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GuidHelper::get($trim);
	 */
	public static function GUID($trim = true)
	{
		return GuidHelper::get($trim);
	}

	/**
	 * Validate the Globally Unique Identifier ( and check if table already has this identifier)
	 *
	 * @param string       $guid
	 * @param string       $table
	 * @param int            $id
	 * @param string|null $component
	 *
	 * @return bool
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GuidHelper::valid($guid, $table, $id, $component);
	 */
	public static function validGUID($guid, $table = null, $id = 0, $component = null)
	{
		// set the local component option
		self::setComponentOption();

		return GuidHelper::valid($guid, $table, $id, $component);
	}

	/**
	 * get the ITEM of a GUID by table
	 *
	 * @param string           $guid
	 * @param string           $table
	 * @param string/array  $what
	 * @param string|null    $component
	 *
	 * @return mix
	 * 
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use GuidHelper::valid($guid, $table, $id, $component);
	 */
	public static function getGUID($guid, $table, $what = 'a.id', $component = null)
	{
		// set the local component option
		self::setComponentOption();

		return GuidHelper::item($guid, $table, $what, $component);
	}

	/**
	 * Validate the Globally Unique Identifier
	 *
	 * Thanks to Lewie
	 * https://stackoverflow.com/a/1515456/1429677
	 *
	 * @param string $guid
	 *
	 * @return bool
	 *
	 * @deprecated  4.0 - Use GuidHelper::validate($guid);
	 */
	protected static function validateGUID($guid)
	{
		return GuidHelper::validate($guid);
	}

	/**
	 * The zipper method
	 * 
	 * @param  string   $workingDIR    The directory where the items must be zipped
	 * @param  string   $filepath          The path to where the zip file must be placed
	 *
	 * @return  bool true   On success
	 *
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use FileHelper::zip($workingDIR, $filepath);
	 */
	public static function zip($workingDIR, &$filepath)
	{
		return FileHelper::zip($workingDIR, $filepath);
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
	 *
	 * @deprecated  4.0 - Use FileHelper::getContent($path, $none);
	 */
	public static function getFileContents($path, $none = '')
	{
		return FileHelper::getContent($path, $none);
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
	 *
	 * @deprecated  4.0 - Use FileHelper::write($path, $data);
	 */
	public static function writeFile($path, $data)
	{
		return FileHelper::write($path, $data);
	}

	/**
	 * get all the file paths in folder and sub folders
	 * 
	 * @param   string  $folder     The local path to parse
	 * @param   array   $fileTypes  The type of files to get
	 *
	 * @return  void
	 *
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use FileHelper::getPaths($folder, $fileTypes , $recurse, $full);
	 */
	public static function getAllFilePaths($folder, $fileTypes = array('\.php', '\.js', '\.css', '\.less'), $recurse = true, $full = true)
	{
		return FileHelper::getPaths($folder, $fileTypes , $recurse, $full);
	}

	/**
	 * Get the file path or url
	 *
	 * @param  string   $type              The (url/path) type to return
	 * @param  string   $target            The Params Target name (if set)
	 * @param  string   $fileType          The kind of filename to generate (if not set no file name is generated)
	 * @param  string   $key               The key to adjust the filename (if not set ignored)
	 * @param  string   $default           The default path if not set in Params (fallback path)
	 * @param  bool     $createIfNotSet    The switch to create the folder if not found
	 *
	 * @return  string    On success the path or url is returned based on the type requested
	 *
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use FileHelper::getPath($type, $target, $fileType, $key, $default, $createIfNotSet);
	 */
	public static function getFilePath($type = 'path', $target = 'filepath', $fileType = null, $key = '', $default = '', $createIfNotSet = true)
	{
		// set the local component option
		self::setComponentOption();

		return FileHelper::getPath($type, $target, $fileType, $key, $default, $createIfNotSet);
	}

	/**
	 * Check if file exist
	 *
	 * @param  string   $path   The url/path to check
	 *
	 * @return  bool      If exist true
	 *
	 * @since  3.0.9
	 *
	 * @deprecated  4.0 - Use FileHelper::exists($path);
	 */
	public static function urlExists($path)
	{
		return FileHelper::exists($path);
	}

	/**
	 * Set the component option
	 *
	 * @param   String|null       $option    The option for the component.
	 *
	 * @since  3.0.11
	 */
	public static function setComponentOption($option = null)
	{
		// set the local component option
		if (empty($option))
		{
			if (empty(Helper::$option) && property_exists(__CLASS__, 'ComponentCodeName'))
			{
				Helper::$option = 'com_' . self::$ComponentCodeName;
			}
		}
		else
		{
			Helper::$option = $option;
		}
	}

}

