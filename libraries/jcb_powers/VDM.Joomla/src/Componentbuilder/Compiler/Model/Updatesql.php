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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Model Update sql Class
 * 
 * @since 3.2.0
 */
class Updatesql
{
	/**
	 * The admin view names
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $name = [];

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Constructor
	 *
	 * @param Registry|null    $registry     The compiler registry object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Registry $registry = null)
	{
		$this->registry = $registry ?: Compiler::_('Registry');
	}

	/**
	 * check if an update SQL is needed
	 *
	 * @param   mixed        $old     The old values
	 * @param   mixed        $new     The new values
	 * @param   string       $type    The type of values
	 * @param   int|null     $key     The id/key where values changed
	 * @param   array|null   $ignore  The ids to ignore
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set($old, $new, string $type, ?int $key = null, ?array $ignore = null)
	{
		// check if there were new items added
		if (ArrayHelper::check($new) && ArrayHelper::check($old))
		{
			// check if this is old repeatable field
			if (isset($new[$type]))
			{
				foreach ($new[$type] as $item)
				{
					$newItem = true;

					// check if this is an id to ignore
					if (ArrayHelper::check($ignore)
						&& in_array(
							$item, $ignore
						))
					{
						// don't add ignored ids
						$newItem = false;
					}
					// check if this is old repeatable field
					elseif (isset($old[$type])
						&& ArrayHelper::check($old[$type]))
					{
						if (!in_array($item, $old[$type]))
						{
							// we have a new item, lets add to SQL
							$this->add($type, $item, $key);
						}

						// add only once
						$newItem = false;
					}
					elseif (!isset($old[$type]))
					{
						// we have new values
						foreach ($old as $oldItem)
						{
							if (isset($oldItem[$type]))
							{
								if ($oldItem[$type] == $item[$type])
								{
									$newItem = false;
									break;
								}
							}
							else
							{
								$newItem = false;
								break;
							}
						}
					}
					else
					{
						$newItem = false;
					}

					// add if new
					if ($newItem)
					{
						// we have a new item, lets add to SQL
						$this->add($type, $item[$type], $key);
					}
				}
			}
			else
			{
				foreach ($new as $item)
				{
					if (isset($item[$type]))
					{
						// search to see if this is a new value
						$newItem = true;

						// check if this is an id to ignore
						if (ArrayHelper::check($ignore)
							&& in_array($item[$type], $ignore))
						{
							// don't add ignored ids
							$newItem = false;
						}
						// check if this is old repeatable field
						elseif (isset($old[$type])
							&& ArrayHelper::check($old[$type]))
						{
							if (in_array($item[$type], $old[$type]))
							{
								$newItem = false;
							}
						}
						elseif (!isset($old[$type]))
						{
							// we have new values
							foreach ($old as $oldItem)
							{
								if (isset($oldItem[$type]))
								{
									if ($oldItem[$type] == $item[$type])
									{
										$newItem = false;
										break;
									}
								}
								else
								{
									$newItem = false;
									break;
								}
							}
						}
						else
						{
							$newItem = false;
						}

						// add if new
						if ($newItem)
						{
							// we have a new item, lets add to SQL
							$this->add($type, $item[$type], $key);
						}
					}
				}
			}
		}
		elseif ($key && ((StringHelper::check($new) && StringHelper::check($old))
			|| (is_numeric($new) && is_numeric($old))) && $new !== $old)
		{
			// set at key
			$this->registry->set('builder.update_sql.' . $type . '.' . $key, ['old' => $old, 'new' => $new]);
		}
	}

	/**
	 * Set the add sql
	 *
	 * @param   string     $type  The type of values
	 * @param   int        $item  The item id to add
	 * @param   int|null   $key   The id/key where values changed
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function add(string $type, int $item, ?int $key = null)
	{
		// add key if found
		if ($key)
		{
			$this->registry->set('builder.add_sql.' . $type . '.' . $key . '.' . $item, $item);
		}
		else
		{
			// convert admin view id to name
			if ('adminview' === $type)
			{
				$this->registry->set('builder.add_sql.' . $type,
					$this->name($item)
				);
			}
			else
			{
				$this->registry->set('builder.add_sql.' . $type, $item);
			}
		}
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

