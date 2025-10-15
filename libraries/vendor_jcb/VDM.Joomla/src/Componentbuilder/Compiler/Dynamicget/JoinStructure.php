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

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Utilities\StringHelper;


/**
 * Dynamic Get Join Structure
 * 
 * @since 5.1.2
 */
final class JoinStructure
{
	/**
	 * Get the default method structure for a custom view join.
	 *
	 * @param  array   $get   The method definition array.
	 * @param  string  $code  The code snippet related to the method.
	 *
	 * @return array|null  The normalized method array or null on failure.
	 * @since  5.1.2
	 */
	public function get(array $get, string $code): ?array
	{
		if (!isset($get['key']) || !isset($get['as']) || empty($code))
		{
			return null;
		}

		$key = substr(
			(string) StringHelper::safe(
				preg_replace('/[0-9]+/', '', md5((string) $get['key'])), 'F'
			),
			0,
			4
		);

		$method = [];

		$method['on_field'] = isset($get['on_field'])
			? $this->getFieldName($get['on_field'])
			: null;

		$method['join_field'] = isset($get['join_field'])
			? StringHelper::safe($this->getFieldName($get['join_field']))
			: null;

		$method['Join_field'] = isset($method['join_field'])
			? StringHelper::safe($method['join_field'], 'F')
			: null;

		$method['name'] = StringHelper::safe($get['selection']['name'], 'F');

		$method['code'] = StringHelper::safe($code);

		$method['AS'] = StringHelper::safe($get['as'], 'U');

		$method['as'] = StringHelper::safe($get['as']);

		$method['valueName'] = $method['on_field']
			. $method['Join_field']
			. $method['name']
			. $method['AS'];

		$method['methodName'] = StringHelper::safe($method['on_field'], 'F')
			. $method['Join_field']
			. $method['name']
			. $key
			. '_'
			. $method['AS'];

		return $method;
	}

	/**
	 * Remove the alias (AS) portion from a dot-notation string.
	 *
	 * @param  string  $string  The input string possibly containing a dot (e.g. `a.name`).
	 *
	 * @return string  The portion after the dot or the original string if no dot found.
	 * @since  5.1.2
	 */
	public function getFieldName(string $string): string
	{
		if (strpos($string, '.') !== false)
		{
			list(, $field) = array_map('trim', explode('.', $string, 2));

			return $field;
		}

		return $string;
	}
}

