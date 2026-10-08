<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    2nd September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * The documented expectations of a dynamic get API resource
 * 
 * What the compiler can see of the dynamic get it writes into the docblock
 * of the display method: every filter and clause in words, the request
 * variables the get reads, whether the resource paginates, and where the
 * custom PHP of the get may add what the compiler cannot describe.
 * 
 * @since 6.1.7
 */
class Expectations
{
	/**
	 * The filter types of a dynamic get, by their stored number.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	private const FILTERS = [
		1 => 'the id of the request',
		2 => 'the id of the calling user',
		3 => 'the access levels of the calling user',
		4 => 'the user groups of the calling user',
	];

	/**
	 * The filter types the compiler does not build yet.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	private const PENDING = [
		5 => 'category',
		6 => 'tags',
		7 => 'date',
	];

	/**
	 * Get the docblock lines describing the request the resource expects.
	 *
	 * Each line opens on a new line with the docblock star, so the
	 * placeholder sits at the end of a docblock line.
	 *
	 * @param   array  $resource  The resource, as the resources map names it.
	 *
	 * @return  string  The docblock lines.
	 * @since   6.1.7
	 */
	public function get(array $resource): string
	{
		$get = $resource['settings']->main_get ?? null;
		$list = !empty($resource['list']);
		$lines = [];

		if (is_object($get))
		{
			$lines = array_merge(
				$this->filters($get, $list),
				$this->where($get),
				$this->order($get),
				$this->group($get)
			);
		}

		$text = PHP_EOL . Indent::_(1) . ' *';

		if ($lines === [])
		{
			$text .= $this->line('The dynamic get sets no filter of its own.');
		}
		else
		{
			$text .= $this->line('The dynamic get expects, as far as it shows:');

			foreach ($lines as $line)
			{
				$text .= $this->line(' - ' . $line);
			}
		}

		if ($list)
		{
			$text .= $this->line(
				((int) ($get->pagination ?? 0) === 1)
					? 'Paginated with page[offset] and page[limit].'
					: 'Every record is returned, the get does not paginate.'
			);
		}

		foreach ($this->hooks($get, $list) as $hook)
		{
			$text .= $this->line($hook);
		}

		return $text;
	}

	/**
	 * The filter lines of the get.
	 *
	 * @param   object  $get   The main get.
	 * @param   bool    $list  Whether the resource is a list.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function filters(object $get, bool $list): array
	{
		$lines = [];

		foreach ($this->rows($get->filter ?? null) as $filter)
		{
			$key = (string) ($filter['table_key'] ?? '');
			$type = (int) ($filter['filter_type'] ?? 0);
			$operator = (string) ($filter['operator'] ?? '=');
			$state = trim((string) ($filter['state_key'] ?? ''));

			if ($key === '')
			{
				continue;
			}

			if (isset(self::FILTERS[$type]))
			{
				$what = self::FILTERS[$type];

				if ($type === 1)
				{
					$what .= $list ? '' : ' (the :id route segment)';
				}

				$lines[] = "{$key} {$operator} {$what}";
			}
			elseif (isset(self::PENDING[$type]))
			{
				$lines[] = "{$key}: the " . self::PENDING[$type] . " filter, which the compiler does not build yet";
			}
			elseif ($type === 8)
			{
				$lines[] = "{$key} {$operator} {$state}, a value the model reads at runtime"
					. ((strpos($state, 'input') !== false) ? ', so the request must carry it' : '');
			}
			elseif ($type === 9 || $type === 10)
			{
				$lines[] = "{$key}: matched inside its decoded "
					. ($type === 9 ? 'array' : 'repeatable') . " value";
			}
			elseif ($type === 11)
			{
				$lines[] = "{$key} {$operator} {$state}";
			}
		}

		return $lines;
	}

	/**
	 * The where lines of the get.
	 *
	 * @param   object  $get  The main get.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function where(object $get): array
	{
		$lines = [];

		foreach ($this->rows($get->where ?? null) as $where)
		{
			$key = (string) ($where['table_key'] ?? '');
			$value = trim((string) ($where['value_key'] ?? ''));

			if ($key === '' || $value === '')
			{
				continue;
			}

			$lines[] = "where {$key} " . (string) ($where['operator'] ?? '=') . " {$value}";
		}

		return $lines;
	}

	/**
	 * The order lines of the get.
	 *
	 * @param   object  $get  The main get.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function order(object $get): array
	{
		$lines = [];

		foreach ($this->rows($get->order ?? null) as $order)
		{
			$key = (string) ($order['table_key'] ?? '');
			$direction = (string) ($order['direction'] ?? '');

			if ($key === '' || $direction === '')
			{
				continue;
			}

			$lines[] = ($direction === 'RAND') ? 'ordered at random' : "ordered by {$key} {$direction}";
		}

		return $lines;
	}

	/**
	 * The group lines of the get.
	 *
	 * @param   object  $get  The main get.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function group(object $get): array
	{
		$lines = [];

		foreach ($this->rows($get->group ?? null) as $group)
		{
			$key = (string) ($group['table_key'] ?? '');

			if ($key !== '')
			{
				$lines[] = "grouped by {$key}";
			}
		}

		return $lines;
	}

	/**
	 * The custom PHP hooks of the get the compiler cannot describe.
	 *
	 * @param   object|null  $get   The main get.
	 * @param   bool         $list  Whether the resource is a list.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function hooks(?object $get, bool $list): array
	{
		if (!is_object($get))
		{
			return [];
		}

		$hooks = $list
			? ['add_php_getlistquery' => 'in the list query', 'add_php_before_getitems' => 'before the items', 'add_php_after_getitems' => 'after the items']
			: ['add_php_before_getitem' => 'before the item', 'add_php_after_getitem' => 'after the item'];

		$active = [];

		foreach ($hooks as $flag => $where)
		{
			if ((int) ($get->{$flag} ?? 0) === 1)
			{
				$active[] = $where;
			}
		}

		if ($active === [])
		{
			return [];
		}

		return ['Custom PHP runs ' . implode(', ', $active) . ' and may add conditions or change the result the compiler cannot describe.'];
	}

	/**
	 * The rows of a get option.
	 *
	 * @param   mixed  $option  The option, an array of rows when set.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function rows($option): array
	{
		if (!is_array($option))
		{
			return [];
		}

		return array_filter($option, 'is_array');
	}

	/**
	 * One docblock line.
	 *
	 * @param   string  $text  The text.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	private function line(string $text): string
	{
		return PHP_EOL . Indent::_(1) . ' * ' . $text;
	}
}

