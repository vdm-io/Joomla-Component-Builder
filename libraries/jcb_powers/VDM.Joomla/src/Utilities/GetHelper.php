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


/**
 * Some easy get...
 */
abstract class GetHelper
{
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
	 */
	public static function var($table, $where = null, $whereString = 'user', $what = 'id', $operator = '=', $main = 'componentbuilder')
	{
		if(!$where)
		{
			$where = Factory::getUser()->id;
		}

		// Get a db connection.
		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array($what)));

		if (empty($table))
		{
			$query->from($db->quoteName('#__' . $main));
		}
		else
		{
			$query->from($db->quoteName('#__' . $main . '_' . $table));
		}

		if (is_numeric($where))
		{
			$query->where($db->quoteName($whereString) . ' ' . $operator . ' ' . (int) $where);
		}
		elseif (is_string($where))
		{
			$query->where($db->quoteName($whereString) . ' ' . $operator . ' ' . $db->quote((string)$where));
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
	 */
	public static function vars($table, $where = null, $whereString = 'user', $what = 'id', $operator = 'IN', $main = 'componentbuilder', $unique = true)
	{
		if(!$where)
		{
			$where = Factory::getUser()->id;
		}

		if (!ArrayHelper::check($where) && $where > 0)
		{
			$where = array($where);
		}

		if (ArrayHelper::check($where))
		{
			// prep main <-- why? well if $main='' is empty then $table can be categories or users
			if (StringHelper::check($main))
			{
				$main = '_' . ltrim($main, '_');
			}

			// Get a db connection.
			$db = Factory::getDbo();

			// Create a new query object.
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array($what)));

			if (empty($table))
			{
				$query->from($db->quoteName('#__' . $main));
			}
			else
			{
				$query->from($db->quoteName('#_' . $main . '_' . $table));
			}

			// add strings to array search
			if ('IN_STRINGS' === $operator || 'NOT IN_STRINGS' === $operator)
			{
				$query->where($db->quoteName($whereString) . ' ' . str_replace('_STRINGS', '', $operator) . ' ("' . implode('","',$where) . '")');
			}
			else
			{
				$query->where($db->quoteName($whereString) . ' ' . $operator . ' (' . implode(',',$where) . ')');
			}

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

}

