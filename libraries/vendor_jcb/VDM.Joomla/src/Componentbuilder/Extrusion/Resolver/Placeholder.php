<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Placeholders;


/**
 * Says a component's own name through the placeholder that stands for it.
 * 
 * The compiler holds the values it derives from the component -- its code
 * name in three shapes and its namespace segment -- and substitutes them into
 * everything it writes with a bare string replacement. So a class, a screen or
 * a seed that a component ships carries the component's name where the record
 * it was built from carried a placeholder, and reading that name back binds
 * the record to the one component it was lifted out of: a power lifted out of
 * com_demo would say Demo forever, wherever it is used next.
 * 
 * Nothing is guessed. The name is only written back where the compiler itself
 * puts it -- the extension element, the table prefix, the language prefix, the
 * component helper, a namespace segment -- so a component named demo keeps its
 * demonstrations, its demoted rows and its demo@example.com. A value a person
 * defined for themselves is never touched: the compiler substitutes it too,
 * but only the person knows where they meant it, and a run that acted on that
 * would be guessing.
 * 
 * @since 6.2.0
 */
final class Placeholder
{
	/**
	 * The Placeholders Resolver.
	 *
	 * @var    Placeholders
	 * @since  6.2.0
	 */
	protected Placeholders $placeholders;

	/**
	 * The idioms this run may say, held against the values they were read from.
	 *
	 * @var    array<string, array{pattern: string, writes: array<int, string>}>
	 * @since  6.2.0
	 */
	protected array $idioms = [];

	/**
	 * Constructor.
	 *
	 * @param   Placeholders  $placeholders  The placeholder value resolver.
	 *
	 * @since   6.2.0
	 */
	public function __construct(Placeholders $placeholders)
	{
		$this->placeholders = $placeholders;
	}

	/**
	 * One piece of harvested text, saying the component through its placeholder.
	 *
	 * @param   string  $text  The text as the source stated it.
	 *
	 * @return  string  The text, deferring to placeholders where the compiler filled them in.
	 * @since   6.2.0
	 */
	public function reverse(string $text): string
	{
		if ($text === '')
		{
			return $text;
		}

		$idioms = $this->idioms();

		if ($idioms === [])
		{
			return $text;
		}

		$replaced = preg_replace_callback(
			$idioms['pattern'],
			static function (array $found) use ($idioms): string
			{
				foreach ($idioms['writes'] as $index => $writes)
				{
					if (($found[$index] ?? '') !== '')
					{
						return $writes;
					}
				}

				return $found[0];
			},
			$text
		);

		return is_string($replaced) ? $replaced : $text;
	}

	/**
	 * Every place the compiler writes the component's own name.
	 *
	 * Each of these is somewhere the compiler puts the name itself, so each is
	 * somewhere the name can be given back to the placeholder it came from.
	 * Three of them are the very pairs JCB's own custom code extractor keeps
	 * (Customcode\Extractor), and the other two are how the compiler names a
	 * component's tables and composes its namespace.
	 *
	 * The language prefix is deliberately said as COM_ and the upper case name
	 * rather than as a placeholder of its own: the compiler reassigns
	 * lang_prefix while it builds a module or a plugin, so a power carrying
	 * that placeholder would say MOD_ or PLG_ there, while this pair says the
	 * same thing in every one of those places.
	 *
	 * @return  array{pattern: string, writes: array<int, string>}  The idioms, or an empty array when the run has no component to name.
	 * @since   6.2.0
	 */
	protected function idioms(): array
	{
		$core = $this->placeholders->core();
		$code = (string) ($core[$this->placeholders->placeholder('component')] ?? '');
		$namespace = $this->placeholders->component();
		$signature = md5($code . '|' . $namespace);

		if (isset($this->idioms[$signature]))
		{
			return $this->idioms[$signature];
		}

		if ($code === '')
		{
			return $this->idioms[$signature] = [];
		}

		$said = [
			// the extension element, which every option and every folder of a
			// component is named by
			'com_' . preg_quote($code, '/') . '(?![A-Za-z0-9])'
				=> 'com_' . $this->placeholders->placeholder('component'),
			// the prefix of every table the component keeps its records in
			'#__' . preg_quote($code, '/') . '_'
				=> '#__' . $this->placeholders->placeholder('component') . '_',
			// the language prefix, which Compiler\Config builds as COM_ and
			// the upper case code name
			'COM_' . preg_quote(strtoupper($code), '/') . '(?![A-Za-z0-9])'
				=> 'COM_' . $this->placeholders->placeholder('COMPONENT'),
			// the component's own helper class
			preg_quote(ucfirst($code), '/') . 'Helper'
				=> $this->placeholders->placeholder('Component') . 'Helper'
		];

		if ($namespace !== '')
		{
			// a segment of the namespace the compiler composes for the
			// component, between the separators that make it a segment
			$said['\\\\' . preg_quote($namespace, '/') . '\\\\']
				= '\\' . $this->placeholders->placeholder('ComponentNamespace') . '\\';
		}

		$parts = [];
		$writes = [];
		$index = 1;

		foreach ($said as $pattern => $write)
		{
			$parts[] = '(' . $pattern . ')';
			$writes[$index++] = $write;
		}

		// one expression, matched in one pass, so an idiom just written is
		// never read again as if it were the source
		return $this->idioms[$signature] = [
			'pattern' => '/' . implode('|', $parts) . '/',
			'writes' => $writes
		];
	}
}

