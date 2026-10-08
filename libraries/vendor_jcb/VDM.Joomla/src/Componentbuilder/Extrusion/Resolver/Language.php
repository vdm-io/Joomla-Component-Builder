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


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Language as Catalogue;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Turns a language constant into the actual English string.
 * 
 * JCB stores real text, not placeholders, so a label of
 * COM_EXAMPLE_ITEM_NAME_LABEL must become "Name" before it is written. A
 * constant that cannot be resolved is kept verbatim and recorded, because
 * silently inventing a label would be worse than reporting the gap.
 * 
 * @since 6.1.6
 */
final class Language
{
	/**
	 * The Language catalogue registry.
	 *
	 * @var    Catalogue
	 * @since  6.1.6
	 */
	protected Catalogue $catalogue;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.8
	 */
	protected Source $source;

	/**
	 * The installed catalogues already loaded, keyed by component option.
	 *
	 * @var    array<string, bool>
	 * @since  6.1.8
	 */
	protected array $installed = [];

	/**
	 * Constructor.
	 *
	 * @param   Catalogue  $catalogue  The language constant catalogue.
	 * @param   Report     $report     The run report registry.
	 * @param   Source     $source     The source identity registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Catalogue $catalogue, Report $report, Source $source)
	{
		$this->catalogue = $catalogue;
		$this->report = $report;
		$this->source = $source;
	}

	/**
	 * Whether a value looks like a language constant rather than text.
	 *
	 * @param   mixed  $value  The candidate value.
	 *
	 * @return  bool  True when the value is a constant.
	 * @since   6.1.6
	 */
	public function isConstant($value): bool
	{
		if (!is_string($value) || $value === '')
		{
			return false;
		}

		// \z rather than $ on purpose: $ also matches before a trailing newline,
		// which would make "CONSTANT\n" a constant and put that newline in a
		// catalogue lookup and in the report path recorded for a miss.
		return preg_match('/^[A-Z][A-Z0-9_]*\z/', $value) === 1
			&& str_contains($value, '_');
	}

	/**
	 * The English one constant states, or null when nothing states it.
	 *
	 * Unlike resolve, an unanswered constant is not a shortfall to report:
	 * the caller is asking whether the component states something, and
	 * silence is an ordinary answer.
	 *
	 * @param   string  $constant  The language constant.
	 *
	 * @return  string|null  The stated English, or null.
	 * @since   6.1.9
	 */
	public function stated(string $constant): ?string
	{
		if (!$this->isConstant($constant))
		{
			return null;
		}

		$resolved = $this->catalogue->get('constant.' . $constant);

		if (is_string($resolved) && $resolved !== '')
		{
			return $resolved;
		}

		return $this->fetch($constant);
	}

	/**
	 * Resolve one value through the catalogue.
	 *
	 * @param   mixed   $value     The candidate value.
	 * @param   string  $fallback  A value to use when the constant is unknown.
	 *
	 * @return  string  The English string, the fallback, or the constant verbatim.
	 * @since   6.1.6
	 */
	public function resolve($value, string $fallback = ''): string
	{
		if (!is_string($value))
		{
			return $fallback;
		}

		if (!$this->isConstant($value))
		{
			return $value;
		}

		$resolved = $this->catalogue->get('constant.' . $value);

		if (is_string($resolved) && $resolved !== '')
		{
			return $resolved;
		}

		// a constant names the component it belongs to, and an installed
		// component keeps its translations in this site's own language
		// folders -- so a constant the run read no file for can still be
		// answered, which is what a library harvested on its own needs
		$resolved = $this->fetch($value);

		if ($resolved !== null)
		{
			return $resolved;
		}

		$this->report->set('unresolved.language.' . $value, true);

		return $fallback !== '' ? $fallback : $value;
	}

	/**
	 * Fetch the catalogue of the component one constant names.
	 *
	 * @param   string  $constant  The constant.
	 *
	 * @return  string|null  The English string, or null when none answers.
	 * @since   6.1.8
	 */
	protected function fetch(string $constant): ?string
	{
		foreach ($this->options($constant) as $option)
		{
			if (isset($this->installed[$option]))
			{
				continue;
			}

			$this->installed[$option] = true;

			if ($this->load($option) === 0)
			{
				continue;
			}

			$resolved = $this->catalogue->get('constant.' . $constant);

			if (is_string($resolved) && $resolved !== '')
			{
				return $resolved;
			}
		}

		return null;
	}

	/**
	 * The component options one constant may belong to, longest prefix last.
	 *
	 * A component's language prefix is its option in upper case, and an
	 * option may itself hold underscores, so every prefix the constant could
	 * carry is offered rather than the first one guessed.
	 *
	 * @param   string  $constant  The constant.
	 *
	 * @return  array<int, string>  The candidate options.
	 * @since   6.1.8
	 */
	protected function options(string $constant): array
	{
		$parts = explode('_', strtolower($constant));

		if (count($parts) < 3 || $parts[0] !== 'com')
		{
			return [];
		}

		$options = [];
		$option = 'com';

		// the last part is never the option: a constant always says something
		// about the component after naming it
		for ($index = 1, $last = count($parts) - 1; $index < $last; $index++)
		{
			$option .= '_' . $parts[$index];
			$options[] = $option;
		}

		return $options;
	}

	/**
	 * Load one installed component's translations into the catalogue.
	 *
	 * @param   string  $option  The component option.
	 *
	 * @return  int  The number of constants added.
	 * @since   6.1.8
	 */
	protected function load(string $option): int
	{
		if (!defined('JPATH_ROOT'))
		{
			return 0;
		}

		$tag = (string) $this->source->get('tag', 'en-GB');
		$added = 0;

		foreach ([
			JPATH_ROOT . '/administrator/language/' . $tag,
			JPATH_ROOT . '/language/' . $tag
		] as $folder)
		{
			foreach ([
				$option . '.ini',
				$tag . '.' . $option . '.ini',
				$option . '.sys.ini',
				$tag . '.' . $option . '.sys.ini'
			] as $name)
			{
				$added += $this->parse($folder . '/' . $name);
			}
		}

		if ($added > 0)
		{
			$this->report->set('language.installed.' . $option, $added);
		}

		return $added;
	}

	/**
	 * Read one translation file into the catalogue.
	 *
	 * @param   string  $path  Absolute path to the file.
	 *
	 * @return  int  The number of constants added.
	 * @since   6.1.8
	 */
	protected function parse(string $path): int
	{
		if (!is_file($path))
		{
			return 0;
		}

		$strings = @parse_ini_file($path, false, INI_SCANNER_RAW);

		if (!is_array($strings))
		{
			return 0;
		}

		$added = 0;

		foreach ($strings as $constant => $text)
		{
			$constant = trim((string) $constant);
			$text = trim((string) $text, "\"'");

			if ($constant === '' || $text === ''
				|| $this->catalogue->exists('constant.' . $constant))
			{
				continue;
			}

			$this->catalogue->set('constant.' . $constant, $text);
			$added++;
		}

		return $added;
	}

	/**
	 * Resolve every value of an attribute bag that carries display text.
	 *
	 * @param   array<string, mixed>  $attributes  The raw attribute bag.
	 * @param   array<string>         $keys        The attribute names to resolve.
	 *
	 * @return  array<string, mixed>  The bag with those attributes resolved.
	 * @since   6.1.6
	 */
	public function bag(array $attributes, array $keys): array
	{
		foreach ($keys as $key)
		{
			if (!isset($attributes[$key]) || !$this->isConstant($attributes[$key]))
			{
				continue;
			}

			$resolved = $this->resolve($attributes[$key]);

			if ($this->isConstant($resolved))
			{
				// JCB stores the language itself; the constant only names it,
				// and the compiler builds constants back from the English. A
				// constant nothing answered for therefore cannot be carried:
				// stored, it becomes a key built from a key -- and since every
				// view's constants name that view, it also makes two identical
				// fields look different in the only place they never were.
				// resolve() already named the loss in the report
				unset($attributes[$key]);

				continue;
			}

			$attributes[$key] = $resolved;
		}

		return $attributes;
	}
}

