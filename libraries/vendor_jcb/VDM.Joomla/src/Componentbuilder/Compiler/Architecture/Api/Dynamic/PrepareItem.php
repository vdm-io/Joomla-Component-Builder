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


use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\JoinStructure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The item preparation of a dynamic get JSON view
 * 
 * A JSON:API resource needs an id, the multi-row joins of the main get are
 * fetched for every row through the model methods the templates use, and
 * on an item resource the custom gets of the view ride along as attributes.
 * 
 * @since 6.1.7
 */
class PrepareItem
{
	/**
	 * The Dynamicget JoinStructure Class.
	 *
	 * @var   JoinStructure
	 * @since 6.1.7
	 */
	protected JoinStructure $joinstructure;

	/**
	 * Constructor.
	 *
	 * @param JoinStructure  $joinstructure  The Dynamicget JoinStructure Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(JoinStructure $joinstructure)
	{
		$this->joinstructure = $joinstructure;
	}

	/**
	 * Get the body of prepareItem() before the parent call.
	 *
	 * @param   array  $resource  The resource, as the resources map names it.
	 * @param   bool   $list      Whether the resource is a list.
	 *
	 * @return  string  The method body.
	 * @since   6.1.7
	 */
	public function get(array $resource, bool $list): string
	{
		$settings = $resource['settings'];
		$code = (string) $resource['code'];

		$body = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " A JSON:API resource needs an id.";
		$body .= PHP_EOL . Indent::_(2) . "if (!isset(\$item->id))";
		$body .= PHP_EOL . Indent::_(2) . "{";

		if ($list)
		{
			$body .= PHP_EOL . Indent::_(3) . "\$item->id = ++\$this->position;";
		}
		else
		{
			$body .= PHP_EOL . Indent::_(3) . "\$item->id = (int) \$this->getModel()->getState('{$code}.id');";
		}

		$body .= PHP_EOL . Indent::_(2) . "}";

		$used = [];

		foreach ($this->joins($settings, $code) as $join)
		{
			$key = $this->key($join, $used);

			$body .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " The {$key} rows joined to this {$code} on its {$join['on_field']}.";
			$body .= PHP_EOL . Indent::_(2) . "\$item->{$key} = isset(\$item->{$join['on_field']})";
			$body .= PHP_EOL . Indent::_(3) . "? \$this->getModel()->get{$join['methodName']}(\$item->{$join['on_field']})";
			$body .= PHP_EOL . Indent::_(3) . ": [];";
		}

		if (!$list)
		{
			foreach ($this->customs($settings) as $name => $method)
			{
				$body .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
					. " The {$name} custom get of the {$code} view.";
				$body .= PHP_EOL . Indent::_(2) . "\$item->{$name} = \$this->getModel()->{$method}();";
			}
		}

		return $body;
	}

	/**
	 * The multi-row joins of the main get, as the join structure names them.
	 *
	 * @param   object  $settings  The view settings.
	 * @param   string  $code      The view code.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function joins(object $settings, string $code): array
	{
		$joins = [];
		$gets = $settings->main_get->custom_get ?? null;

		if (!is_array($gets))
		{
			return $joins;
		}

		foreach ($gets as $get)
		{
			if (!is_array($get))
			{
				continue;
			}

			$join = $this->joinstructure->get($get, $code);

			if ($join !== null && !empty($join['on_field']) && !empty($join['methodName']))
			{
				$joins[] = $join;
			}
		}

		return $joins;
	}

	/**
	 * The custom gets of the view, as the HTML view names them.
	 *
	 * @param   object  $settings  The view settings.
	 *
	 * @return  array  The method names, by the attribute name.
	 * @since   6.1.7
	 */
	public static function customs(object $settings): array
	{
		$customs = [];
		$gets = $settings->custom_get ?? null;

		if (!is_array($gets))
		{
			return $customs;
		}

		foreach ($gets as $get)
		{
			$method = is_object($get) ? trim((string) ($get->getcustom ?? '')) : '';
			$type = is_object($get) ? (int) ($get->gettype ?? 0) : 0;

			if ($method === '' || !in_array($type, [3, 4], true))
			{
				continue;
			}

			$name = StringHelper::safe(str_replace('get', '', $method));

			if ($name !== '')
			{
				$customs[$name] = $method;
			}
		}

		return $customs;
	}

	/**
	 * The attribute a join is attached under: the joined name, with the
	 * alias when the name is taken.
	 *
	 * @param   array  $join  The join structure.
	 * @param   array  $used  The attributes already taken.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	private function key(array $join, array &$used): string
	{
		$key = strtolower((string) $join['name']);

		if ($key === '' || isset($used[$key]))
		{
			$key = trim($key . '_' . $join['as'], '_');
		}

		$used[$key] = true;

		return $key;
	}
}

