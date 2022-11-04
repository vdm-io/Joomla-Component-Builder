<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Agent;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchTypeInterface as SearchEngine;
use VDM\Joomla\Componentbuilder\Search\Interfaces\SearchInterface;


/**
 * Search Agent Search
 * 
 * @since 3.2.0
 */
class Search implements SearchInterface
{
	/**
	 * Search results found
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $found = [];

	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Search Engine
	 *
	 * @var    SearchEngine
	 * @since 3.2.0
	 */
	protected SearchEngine $search;

	/**
	 * Constructor
	 *
	 * @param Config|null                 $config       The search config object.
	 * @param SearchEngine|null      $search    The search engine object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?SearchEngine $search = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->search = $search ?: Factory::_('Search');
	}

	/**
	 * Get found values
	 *
	 * @param string     $table   The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function get(string $table): ?array
	{
		if (isset($this->found[$table]))
		{
			return $this->found[$table];
		}

		return null;
	}

	/**
	 * Search inside a value
	 *
	 * @param   mixed         $value     The field value
	 * @param   int           $id        The item ID
	 * @param   string        $field     The field key
	 * @param   string        $table     The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function value($value, int $id, string $field, string $table): bool
	{
		// search the mixed value
		$found = $this->searchValue($value);

		// check if we found any match
		if (ArrayHelper::check($found))
		{
			foreach ($found as $line => $line_value)
			{
				// may not be needed... but being old school
				$this->prep($id, $field, $table);

				// load the detail into our multidimensional array... lol
				// Table->Item_id->Field_name->Line_number = marked_full_line
				// Search Example: soon...
				// Marked Line Example: Soon....
				$this->found[$table][$id][$field][$line] = $line_value;
			}
			return true;
		}

		return false;
	}

	/**
	 * Empty the found values
	 *
	 * @param string   $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function reset(string $table)
	{
		unset($this->found[$table]);
	}

	/**
	 * Search inside a string
	 *
	 * @param   mixed    $value    The field value
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	protected function searchValue($value): ?array
	{
		// check if this is an array
		$found = null;

		// I know this is a little crazy... TODO refactor into recursion functions
		// the possibility of searching sub-forms in sub-forms
		if (ArrayHelper::check($value))
		{
			// first layer
			foreach ($value as $keys => $rows)
			{
				if (ArrayHelper::check($rows))
				{
					// second layer
					foreach ($rows as $key => $row)
					{
						if (ArrayHelper::check($row))
						{
							// third layer
							foreach ($row as $ke => $ro)
							{
								if (ArrayHelper::check($ro))
								{
									// forth layer
									foreach ($ro as $k => $r)
									{
										if (StringHelper::check($r))
										{
											if (($_found = $this->string($r)) !== null)
											{
												foreach ($_found as $_n => $_f)
												{
													$found[$keys . '.' . $key . '.' . $ke . '.' . $k . '.' . $_n] = $_f;
												}
											}
										}
									}
								}
								elseif (StringHelper::check($ro))
								{
									if (($_found = $this->string($ro)) !== null)
									{
										foreach ($_found as $_n => $_f)
										{
											$found[$keys. '.' . $key . '.' . $ke . '.' . $_n] = $_f;
										}
									}
								}

							}
						}
						elseif (StringHelper::check($row))
						{
							if (($_found = $this->string($row)) !== null)
							{
								foreach ($_found as $_n => $_f)
								{
									$found[$keys. '.' . $key . '.' . $_n] = $_f;
								}
							}
						}
					}
				}
				elseif (StringHelper::check($rows))
				{
					if (($_found = $this->string($rows)) !== null)
					{
						foreach ($_found as $_n => $_f)
						{
							$found[$keys. '.' . $_n] = $_f;
						}
					}
				}
			}
		}
		elseif (StringHelper::check($value))
		{
			$found = $this->string($value);
		}

		return $found;
	}

	/**
	 * Search inside a string
	 *
	 * @param   string   $value     The field value
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	protected function string(string $value): ?array
	{
		// line counter
		$line = 1;

		// we count every field we search
		$this->fieldCounter();

		// check if string has a new line
		if (\preg_match('/\R/', $value))
		{
			$search_array = \preg_split('/\R/', $value);

			// start search bucket
			$found = [];

			// loop over the lines
			foreach ($search_array as $line_value)
			{
				if (($_found = $this->search->string($line_value)) !== null)
				{
					$found[$line] = $_found;
				}

				// next line
				$line++;
			}

			if (ArrayHelper::check($found))
			{
				return $found;
			}
		}
		elseif (($found = $this->search->string($value)) !== null)
		{
			return [$line => $found];
		}

		return null;
	}

	/**
	 * Prep the bucket
	 *
	 * @param   int        $id       The item ID
	 * @param   string     $field    The field key
	 * @param   string     $table    The table
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function prep(int $id, string $field, string $table)
	{
		if (empty($this->found[$table]))
		{
			$this->found[$table] = [];
		}
		if (empty($this->found[$table][$id]))
		{
			$this->found[$table][$id] = [];
		}
		if (empty($this->found[$table][$id][$field]))
		{
			$this->found[$table][$id][$field] = [];
		}
		// we should add a call to get the item name if the table has a name field TODO
	}

	/**
	 * we count every field being searched
	 *
	 * @since 3.2.0
	 */
	protected function fieldCounter()
	{
		// we count every field we search
		$this->config->field_counter = $this->config->field_counter + 1;
	}
}

