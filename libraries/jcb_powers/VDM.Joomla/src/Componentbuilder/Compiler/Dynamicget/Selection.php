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


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Dynamic Get Selection Class
 * 
 * @since 3.2.0
 */
class Selection
{
	/**
	 * Admin view table names
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $name;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null             $registry         The compiler registry object.
	 * @param \JDatabaseDriver|null     $db               The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get Data Selection of the dynamic get
	 *
	 * @param   string    $methodKey   The method unique key
	 * @param   string    $viewCode    The code name of the view
	 * @param   string    $string      The data string
	 * @param   string    $asset       The asset in question
	 * @param   string    $as          The as string
	 * @param   string    $type        The target type (db||view)
	 * @param   int|null  $rowType     The row type
	 *
	 * @return  array|null the select query
	 * @since 3.2.0
	 */
	public function get(string $methodKey, string $viewCode,
		string $string, string $asset, string $as, string $type, ?int $rowType = null): ?array
	{
		if (StringHelper::check($string))
		{
			if ('db' === $type)
			{
				$table     = '#__' . $asset;
				$queryName = $asset;
				$view      = '';
			}
			elseif ('view' === $type)
			{
				$view      = $this->name($asset);
				$table     = '#__' . $this->config->component_code_name . '_' . $view;
				$queryName = $view;
			}
			else
			{
				return null;
			}

			// just get all values from table if * is found
			if ($string === '*' || strpos($string, '*') !== false)
			{
				if ($type == 'view')
				{
					// TODO move getViewTableColumns to its own class
					$_string = Helper::_('getViewTableColumns',
						[$asset, $as, $rowType]
					);
				}
				else
				{
					// TODO move getDbTableColumns to its own class
					$_string = Helper::_('getDbTableColumns',
						[$asset, $as, $rowType]
					);
				}

				// get only selected values
				$lines = explode(PHP_EOL, (string) $_string);

				// make sure to set the string to *
				$string = '*';
			}
			else
			{
				// get only selected values
				$lines = explode(PHP_EOL, $string);
			}

			// only continue if lines are available
			if (ArrayHelper::check($lines))
			{
				$gets = [];
				$keys = [];

				// first load all options
				foreach ($lines as $line)
				{
					if (strpos($line, 'AS') !== false)
					{
						$lineArray = explode("AS", $line);
					}
					elseif (strpos($line, 'as') !== false)
					{
						$lineArray = explode("as", $line);
					}
					else
					{
						$lineArray = array($line, null);
					}

					// set the get and key
					$get = trim($lineArray[0]);
					$key = trim($lineArray[1]);

					// only add the view (we must adapt this)
					if ($this->registry->exists('builder.get_as_lookup.' . $methodKey . '.' . $get)
						&& 'a' != $as
						&& is_numeric($rowType) && 1 == $rowType
						&& 'view' === $type
						&& strpos('#' . $key, '#' . $view . '_') === false)
					{
						// this is a problem (TODO) since we may want to not add the view name.
						$key = $view . '_' . trim($key);
					}

					// continue only if we have get
					if (StringHelper::check($get))
					{
						$gets[] = $this->db->quote($get);
						if (StringHelper::check($key))
						{
							$this->registry->
								set('builder.get_as_lookup.' . $methodKey . '.' . $get, $key);
						}
						else
						{
							$key = str_replace(
								$as . '.', '', $get
							);

							$this->registry->
								set('builder.get_as_lookup.' . $methodKey . '.' . $get, $key);
						}

						// set the keys
						$keys[] = $this->db->quote(
							$key
						);

						// make sure we have the view name
						if (StringHelper::check($view))
						{
							// prep the field name
							$field = str_replace($as . '.', '', $get);
							// load to the site fields memory bucket
							$this->registry->
								set('builder.site_fields.' . $view . '.' . $field . '.' . $methodKey . '___' . $as,
									['site' => $viewCode, 'get' => $get, 'as'   => $as, 'key' => $key]);
						}
					}
				}

				if (ArrayHelper::check($gets)
					&& ArrayHelper::check($keys))
				{
					// single joined selection needs the prefix to the values to avoid conflict in the names
					// so we must still add then AS
					if ($string == '*' && (is_null($rowType) || 1 != $rowType))
					{
						$querySelect = "\$query->select('" . $as . ".*');";
					}
					else
					{
						$querySelect = '$query->select($db->quoteName('
							. PHP_EOL . Indent::_(3) . 'array(' . implode(
								',', $gets
							) . '),' . PHP_EOL . Indent::_(3) . 'array('
							. implode(',', $keys) . ')));';
					}
					$queryFrom = '$db->quoteName(' . $this->db->quote($table)
						. ', ' . $this->db->quote($as) . ')';

					// return the select query
					return [
						'select'      => $querySelect,
						'from'        => $queryFrom,
						'name'        => $queryName,
						'table'       => $table,
						'type'        => $type,
						'select_gets' => $gets,
						'select_keys' => $keys
						];
				}
			}
		}

		return null;
	}

	/**
	 * Get the Admin view table name
	 *
	 * @param   int        $id  The item id to add
	 *
	 * @return string   the admin view code name
	 * @since 3.2.0
	 */
	protected function name(int $id): string
	{
		// get name if not set
		if (!isset($this->name[$id]))
		{
			$this->name[$id] = StringHelper::safe(
				GetHelper::var('admin_view', $id, 'id', 'name_single')
			);
		}

		return $this->name[$id] ?? 'error';
	}

}

