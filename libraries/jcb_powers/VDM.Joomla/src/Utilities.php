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

namespace VDM\Joomla;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\MathHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Utilities\String\TypeHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Utilities\String\PluginHelper;


/**
 * Basic shared utilities, a legacy implementation
 */
trait Utilities
{
	/**
	 * The Main Active Language
	 * 
	 * @var      string
	 */
	public static $langTag;

	/**
	 * Check if have a string with a length
	 *
	 * @input    string  $string The string to check
	 *
	 * @returns bool true on success
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
	 * @deprecated  4.0 - Use StringHelper::safe($string, $type, $spacer, $replaceNumbers, $keepOnlyCharacters);
	 */
	public static function safeString($string, $type = 'L', $spacer = '_', $replaceNumbers = true, $keepOnlyCharacters = true)
	{
		return StringHelper::safe($string, $type, $spacer, $replaceNumbers, $keepOnlyCharacters);
	}

	/**
	 * Making class or function name safe
	 *
	 * @input	string       The name you would like to make safe
	 *
	 * @returns string on success
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
	 * @deprecated  4.0 - Use FieldHelper::safe($string, $allcap, $spacer);
	 */
	public static function safeFieldName($string, $allcap = false, $spacer = '_')
	{
		return FieldHelper::safe($string, $allcap, $spacer);
	}

	/**
	 * Making field type name safe
	 *
	 * @input	string       The you would like to make safe
	 *
	 * @returns string on success
	 *
	 * @deprecated  4.0 - Use TypeHelper::safe($string);
	 */
	public static function safeTypeName($string)
	{
		return TypeHelper::safe($string);
	}

	/**
	 * Making namespace safe
	 *
	 * @input	string       The you would like to make safe
	 *
	 * @returns string on success
	 *
	 * @deprecated  4.0 - Use NamespaceHelper::safe($string);
	 */
	public static function safeNamespace($string)
	{
		return NamespaceHelper::safe($string);
	}

	/**
	 * @deprecated  4.0 - Use StringHelper::transliterate($string);
	 */
	public static function transliterate($string)
	{
		return StringHelper::transliterate($string);
	}

	/**
	 * @deprecated  4.0 - Use StringHelper::html($var, $charset, $shorten, $length);
	 */
	public static function htmlEscape($var, $charset = 'UTF-8', $shorten = false, $length = 40)
	{
		return StringHelper::html($var, $charset, $shorten, $length);
	}

	/**
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
	 * @deprecated  4.0 - Use JsonHelper::check($string);
	 */
	public static function checkJson($string): bool
	{
		return JsonHelper::check($string);
	}

	/**
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
	 * @deprecated  4.0 - Use GetHelper::var($table, $where, $whereString, $what, $operator, $main);
	 */
	public static function getVar($table, $where = null, $whereString = 'user', $what = 'id', $operator = '=', $main = 'componentbuilder')
	{
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
	 * @deprecated  4.0 - Use GetHelper::vars($table, $where, $whereString, $what, $operator, $main, $unique);
	 */
	public static function getVars($table, $where = null, $whereString = 'user', $what = 'id', $operator = 'IN', $main = 'componentbuilder', $unique = true)
	{
		return GetHelper::vars($table, $where, $whereString, $what, $operator, $main, $unique);
	}

	/**
	 * bc math wrapper (very basic not for accounting)
	 *
	 * @param   string   $type    The type bc math
	 * @param   int      $val1    The first value
	 * @param   int      $val2    The second value
	 * @param   int      $scale   The scale value
	 *
	 * @return int
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
	 * @return float
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
	 * @return float
	 *
	 * @deprecated  4.0 - Use PluginHelper::safe($name, $group);
         */
        public static function createPluginClassName($group, $name)
	{
		return PluginHelper::safeClassName($name, $group);
	}

}

