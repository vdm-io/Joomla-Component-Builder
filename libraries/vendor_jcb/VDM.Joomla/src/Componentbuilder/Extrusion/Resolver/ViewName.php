<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Recovers a JCB view name from a source table name.
 * 
 * A component prefixes its tables with its own code name, so the view name is
 * what remains once that prefix is removed. The list name is the naive plural,
 * which is the same convention JCB itself uses when generating a component.
 * 
 * @since 6.1.6
 */
final class ViewName
{
	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Text Resolver.
	 *
	 * @var    Text
	 * @since  6.1.6
	 */
	protected Text $text;

	/**
	 * Constructor.
	 *
	 * @param   Source  $source  The source identity registry.
	 * @param   Text    $text    The readable text resolver.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Source $source, Text $text)
	{
		$this->source = $source;
		$this->text = $text;
	}

	/**
	 * The single view name for one source table.
	 *
	 * @param   string  $table  The source table name.
	 *
	 * @return  string  The lower-case view name.
	 * @since   6.1.6
	 */
	public function single(string $table): string
	{
		$name = strtolower(trim($table));
		$name = preg_replace('/^#__/', '', $name) ?? $name;

		foreach ($this->prefixes() as $prefix)
		{
			if ($prefix !== '' && str_starts_with($name, $prefix))
			{
				$name = substr($name, strlen($prefix));

				break;
			}
		}

		$name = trim($name, '_');

		return $name === '' ? strtolower(trim($table)) : $name;
	}

	/**
	 * The list view name for one source table.
	 *
	 * @param   string  $table  The source table name.
	 *
	 * @return  string  The lower-case plural view name.
	 * @since   6.1.6
	 */
	public function list(string $table): string
	{
		return $this->plural($this->single($table));
	}

	/**
	 * The naive English plural of a view name.
	 *
	 * @param   string  $name  The single view name.
	 *
	 * @return  string  The plural view name.
	 * @since   6.1.6
	 */
	public function plural(string $name): string
	{
		if ($name === '')
		{
			return $name;
		}

		$last = substr($name, -1);

		if ($last === 'y' && !in_array(substr($name, -2, 1), ['a', 'e', 'i', 'o', 'u'], true))
		{
			return substr($name, 0, -1) . 'ies';
		}

		if (preg_match('/(s|x|z|ch|sh)$/', $name) === 1)
		{
			return $name . 'es';
		}

		return $name . 's';
	}

	/**
	 * The human readable system name for a view.
	 *
	 * @param   string  $name  The single view name.
	 *
	 * @return  string  The title-cased name.
	 * @since   6.1.6
	 */
	public function title(string $name): string
	{
		return $this->text->humanise($name);
	}

	/**
	 * The table-name prefixes that may precede a view name.
	 *
	 * @return  array<string>  Ordered prefixes, longest first.
	 * @since   6.1.6
	 */
	protected function prefixes(): array
	{
		$option = strtolower((string) $this->source->get('code_name', ''));
		$prefixes = [];

		if ($option !== '')
		{
			$bare = preg_replace('/^com_/', '', $option) ?? $option;
			$prefixes[] = $option . '_';
			$prefixes[] = $bare . '_';
		}

		usort(
			$prefixes,
			static fn (string $left, string $right): int => strlen($right) <=> strlen($left)
		);

		return $prefixes;
	}
}

