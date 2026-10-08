<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Serializer;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View\Relationships;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Api Serializer Relations Class.
 * 
 * Builds the relationship methods of a resource serializer, one per
 * relationship the view has, named the way Joomla's JSON API serializer
 * resolves them from the relationship name.
 * 
 * @since 6.1.7
 */
final class Relations
{
	/**
	 * The Api View Relationships Class.
	 *
	 * @var   Relationships
	 * @since 6.1.7
	 */
	protected Relationships $relationships;

	/**
	 * Constructor.
	 *
	 * @param Relationships   $relationships   The Api View Relationships Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Relationships $relationships)
	{
		$this->relationships = $relationships;
	}

	/**
	 * Get the relationship methods of a resource serializer.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  string  The methods, or nothing when the resource relates to nothing.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode): string
	{
		$code = '';

		foreach ($this->relationships->map($nameSingleCode, $nameListCode) as $relation)
		{
			// the tags come from Joomla's own serializer trait
			if ($relation['name'] === 'tags')
			{
				$code = PHP_EOL . Indent::_(1) . 'use TagApiSerializerTrait;' . $code;
				continue;
			}

			$code .= PHP_EOL . PHP_EOL . Indent::_(1) . '/**';
			$code .= PHP_EOL . Indent::_(1) . ' * Build the ' . $relation['name'] . ' relationship.';
			$code .= PHP_EOL . Indent::_(1) . ' *';
			$code .= PHP_EOL . Indent::_(1) . ' * @param   \\stdClass  $item  The item.';
			$code .= PHP_EOL . Indent::_(1) . ' *';
			$code .= PHP_EOL . Indent::_(1) . ' * @return  Relationship';
			$code .= PHP_EOL . Indent::_(1) . ' *';
			$code .= PHP_EOL . Indent::_(1) . ' * @since   4.0.0';
			$code .= PHP_EOL . Indent::_(1) . ' */';
			$code .= PHP_EOL . Indent::_(1) . 'public function ' . $this->method($relation['name']) . '($item)';
			$code .= PHP_EOL . Indent::_(1) . '{';
			$code .= PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " Relate the " . $relation['name'] . " to the " . $relation['type'] . " resource.";
			$code .= PHP_EOL . Indent::_(2) . "return \$this->related(\$item->" . $relation['column']
				. " ?? null, '" . $relation['type'] . "');";
			$code .= PHP_EOL . Indent::_(1) . '}';
		}

		return $code;
	}

	/**
	 * The method name Joomla's serializer resolves for a relationship name.
	 *
	 * A name with an underscore after its first character is turned into
	 * lower camel case, the way the JSON API serializer does before it looks
	 * the method up.
	 *
	 * @param   string  $name  The relationship name.
	 *
	 * @return  string  The method name.
	 * @since   6.1.7
	 */
	private function method(string $name): string
	{
		if (stripos($name, '_'))
		{
			$name = lcfirst(implode('', array_map('ucfirst', explode('_', $name))));
		}

		return $name;
	}
}

