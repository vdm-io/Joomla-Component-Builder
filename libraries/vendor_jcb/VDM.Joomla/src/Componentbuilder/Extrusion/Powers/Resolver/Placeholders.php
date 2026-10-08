<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    22nd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Interfaces\Database\LoadInterface;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Resolves the namespace placeholder values one run works against.
 * 
 * A power's stored namespace defers its vendor prefix and component segment to
 * placeholders, so recognising a harvested class as an existing power means
 * knowing what those placeholders resolve to right now. The values come from
 * exactly the places the compiler takes them: the component row when one was
 * named (its own prefix only when add_namespace_prefix allows it), the global
 * configuration otherwise, and the component placeholder overrides last, so
 * they outrank both -- mirroring Compiler\Component\Placeholder.
 * 
 * @since 6.1.7
 */
final class Placeholders
{
	/**
	 * The placeholder that defers the vendor prefix.
	 * Concatenation preserves the token when this resolver is itself compiled.
	 *
	 * @var    string
	 * @since  6.1.7
	 */
	public const PREFIX = '[[[' . 'NamespacePrefix' . ']]]';

	/**
	 * The placeholder that defers the component segment.
	 * Concatenation preserves the token when this resolver is itself compiled.
	 *
	 * @var    string
	 * @since  6.1.7
	 */
	public const COMPONENT = '[[[' . 'ComponentNamespace' . ']]]';

	/**
	 * The placeholder targets the compiler sets from the component itself.
	 *
	 * These are exactly what Compiler\Component\Placeholder::addCorePlaceholders
	 * sets; every other target in the placeholder tables is a person's own.
	 *
	 * @var    array<string>
	 * @since  6.1.9
	 */
	public const CORE = [
		'component',
		'Component',
		'COMPONENT',
		'LANG_PREFIX',
		'ComponentNamespace',
		'NamespacePrefix',
		'NAMESPACEPREFIX',
		'POWERLOADERPATH'
	];

	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.7
	 */
	protected Config $config;

	/**
	 * The Database Loader.
	 *
	 * @var    LoadInterface
	 * @since  6.1.7
	 */
	protected LoadInterface $load;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.7
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
	 * The prefix to fall back on when nothing else names one.
	 *
	 * @var    string|null
	 * @since  6.1.7
	 */
	protected ?string $fallback;

	/**
	 * The resolved values, cached per component the run speaks for.
	 *
	 * @var    array<string, array{prefix: string, component: string, recognise: array<string>, overrides: array<string, string>}>
	 * @since  6.1.7
	 */
	protected array $resolved = [];

	/**
	 * The vendor prefix and component segment the harvested classes witnessed.
	 *
	 * @var    array<string, array{prefix: string, component: string, count: int}>
	 * @since  6.1.9
	 */
	protected array $witnessed = [];

	/**
	 * The system-wide placeholder rows, decoded, in the order the table holds them.
	 *
	 * @var    array<string, string>|null
	 * @since  6.1.9
	 */
	protected ?array $globals = null;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config    The extrusion configuration.
	 * @param   LoadInterface  $load      The database loader.
	 * @param   Report         $report    The run report registry.
	 * @param   Source         $source    The source identity registry.
	 * @param   string|null    $fallback  The prefix to use when none is configured.
	 *
	 * @since   6.1.7
	 */
	public function __construct(
		Config $config,
		LoadInterface $load,
		Report $report,
		Source $source,
		?string $fallback = null
	)
	{
		$this->config = $config;
		$this->load = $load;
		$this->report = $report;
		$this->source = $source;
		$this->fallback = $fallback;
	}

	/**
	 * The vendor prefix the run's placeholders resolve to.
	 *
	 * @return  string  The namespace prefix value.
	 * @since   6.1.7
	 */
	public function prefix(): string
	{
		return $this->values()['prefix'];
	}

	/**
	 * The component segment the run's placeholders resolve to.
	 *
	 * @return  string  The component namespace value, or an empty string.
	 * @since   6.1.7
	 */
	public function component(): string
	{
		return $this->values()['component'];
	}

	/**
	 * Whether a word is a configured value, not permission to replace it.
	 *
	 * @param   string  $segment  The namespace segment.
	 *
	 * @return  bool  True for a value in this component context only.
	 * @since   6.1.9
	 */
	public function answers(string $segment): bool
	{
		return in_array(strtolower(trim($segment)), $this->values()['recognise'], true);
	}

	/**
	 * Read an isolated component context without mutating this run's target.
	 *
	 * The clone shares only the read boundary; its configuration, source and
	 * diagnostic registries are independent. Two components with identical
	 * namespace values still have distinct identities and override snapshots.
	 *
	 * @param   int|null  $component  The component id, or null for the active context.
	 *
	 * @return  array  The identity, values and ordered compiler placeholder map.
	 * @since   6.2.0
	 */
	public function context(?int $component = null): array
	{
		$view = $this;

		if ($component !== null)
		{
			$view = clone $this;
			$view->config = clone $this->config;
			$view->source = clone $this->source;
			$view->report = clone $this->report;
			$view->source->clear();
			$view->report->clear();
			$view->config->set('component', $component)->set('componentCode', '');
			$view->resolved = [];
			$view->witnessed = [];
		}

		$values = $view->values();

		return [
			'id' => $values['id'],
			'guid' => $values['guid'],
			'code' => $values['code'],
			'prefix' => $values['prefix'],
			'component' => $values['component'],
			'map' => $view->map() + $view->core()
		];
	}

	/**
	 * Witness the concrete values one component-owned class actually carries.
	 *
	 * The stored namespace defers these to placeholders; compiling the
	 * component again must resolve them back to the very values the library
	 * was built with, or every class lands in a different folder. What the
	 * classes witnessed is what a run can record onto the component.
	 *
	 * @param   string  $prefix     The vendor prefix the class carried.
	 * @param   string  $component  The component segment the class carried.
	 *
	 * @return  void
	 * @since   6.1.9
	 */
	public function witness(string $prefix, string $component): void
	{
		$prefix = trim($prefix);
		$component = trim($component);
		$key = $prefix . '|' . $component;

		$this->witnessed[$key] ??= [
			'prefix' => $prefix,
			'component' => $component,
			'count' => 0
		];
		$this->witnessed[$key]['count']++;
	}

	/**
	 * Approved namespace bindings, in deterministic order rather than vote order.
	 *
	 * @return  array<int, array{prefix: string, component: string, count: int}>  The witnessed pairs.
	 * @since   6.1.9
	 */
	public function witnessed(): array
	{
		$witnessed = array_values($this->witnessed);

		usort(
			$witnessed,
			static fn (array $one, array $two): int => strcmp($one['prefix'] . '|' . $one['component'], $two['prefix'] . '|' . $two['component'])
		);

		return $witnessed;
	}

	/**
	 * Drop everything witnessed and resolved, so a fresh run reads fresh.
	 *
	 * The resolved cache goes with the witnesses, because a run that has just
	 * recorded an override onto the component has changed what these very
	 * placeholders resolve to.
	 *
	 * @return  void
	 * @since   6.1.9
	 */
	public function forget(): void
	{
		$this->witnessed = [];
		$this->resolved = [];
		$this->globals = null;
	}

	/**
	 * Every placeholder and the value it resolves to, in the compiler's order.
	 *
	 * The compiler loads the system-wide placeholder table first, sets the
	 * core values over it, and applies the component's own overrides last --
	 * and it substitutes them in that one order, so a person's value may lean
	 * on a core placeholder that is only substituted after it. The same map in
	 * the same order is what lets a namespace stored through a person's own
	 * placeholder resolve to the very class the compiler would write.
	 *
	 * @return  array<string, string>  Placeholder keyed to its value.
	 * @since   6.1.7
	 */
	public function map(): array
	{
		$values = $this->values();
		$map = [];

		foreach ($this->globals() as $target => $value)
		{
			$map[$this->wrap($target)] = $value;
		}

		// a core value the run holds outranks a remembered global one, in
		// place -- exactly as reassigning the key leaves the compiler's order
		$map[self::PREFIX] = $values['prefix'];

		if ($values['component'] !== '')
		{
			$map[self::COMPONENT] = $values['component'];
		}

		foreach ($values['overrides'] as $target => $value)
		{
			$map[$this->wrap($target)] = $value;
		}

		return $map;
	}

	/**
	 * The compiler's own component placeholders, valued as it values them.
	 *
	 * Compiler\Component\Placeholder::addCorePlaceholders names the
	 * component's code three ways, its language prefix once, the vendor
	 * prefix, and the path a component loads its powers through. A record a
	 * person wrote through them -- a seed statement naming
	 * `#__componentbuilder_item` -- reads as the compiled source only once
	 * these are resolved the compiler's way.
	 *
	 * @return  array<string, string>  Placeholder keyed to its value.
	 * @since   6.1.9
	 */
	public function core(): array
	{
		$values = $this->values();
		$code = $values['code'];
		$core = [
			// the loader path follows the Joomla family the source was built
			// for, exactly as Compiler\Config::getComponentautoloaderpath
			// answers it from the version being compiled for
			$this->wrap('POWERLOADERPATH') =>
				strtolower((string) $this->source->get('layout', 'j4')) === 'j3'
					? 'helpers/powerloader.php'
					: 'src/Helper/PowerloaderHelper.php',
			$this->wrap('NAMESPACEPREFIX') => $values['prefix']
		];

		if ($code === '')
		{
			return $core;
		}

		// the code is already safe -- lower case letters and underscores --
		// so the compiler's safe('F') and safe('U') reduce to these exactly
		$upper = strtoupper($code);

		return $core + [
			$this->wrap('component') => $code,
			$this->wrap('Component') => ucfirst($code),
			$this->wrap('COMPONENT') => $upper,
			$this->wrap('LANG_PREFIX') => 'COM_' . $upper
		];
	}

	/**
	 * One placeholder target as the compiler writes it.
	 *
	 * @param   string  $target  The placeholder target.
	 *
	 * @return  string  The wrapped placeholder.
	 * @since   6.1.9
	 */
	public function placeholder(string $target): string
	{
		return $this->wrap($target);
	}

	/**
	 * The placeholders a person defined, and what each one stands for.
	 *
	 * Everything in the map that is not a core target: the system-wide rows
	 * and the paired component's own overrides, in the compiler's order.
	 *
	 * @return  array<string, string>  Placeholder keyed to its value.
	 * @since   6.1.9
	 */
	public function custom(): array
	{
		$custom = [];

		foreach ($this->map() as $placeholder => $value)
		{
			if (!in_array(substr($placeholder, 3, -3), self::CORE, true))
			{
				$custom[$placeholder] = $value;
			}
		}

		return $custom;
	}

	/**
	 * Substitute every placeholder a person defined, leaving the core ones standing.
	 *
	 * One ordered pass, as the compiler substitutes: a value that names a
	 * placeholder defined after it is reached by the same pass, exactly as
	 * far as the compiler would reach it.
	 *
	 * @param   string  $text  The text carrying placeholders.
	 *
	 * @return  string  The text with the person's placeholders substituted.
	 * @since   6.1.9
	 */
	public function expand(string $text): string
	{
		return $this->substitute($text, $this->custom());
	}

	/**
	 * Substitute placeholders until nothing is left to substitute.
	 *
	 * A value may itself name a placeholder; the compiler reaches it in one
	 * ordered pass only when the definition order allows, so here the pass
	 * runs again while it still changes something, bounded so two values
	 * naming each other can never spin.
	 *
	 * @param   string                 $text  The text carrying placeholders.
	 * @param   array<string, string>  $map   Placeholder keyed to its value.
	 *
	 * @return  string  The substituted text.
	 * @since   6.1.9
	 */
	public function substitute(string $text, array $map): string
	{
		$search = [];
		$replace = [];

		foreach ($map as $placeholder => $value)
		{
			$search[] = $placeholder;
			$search[] = '###' . substr($placeholder, 3, -3) . '###';
			$replace[] = $value;
			$replace[] = $value;
		}

		if ($search === [])
		{
			return $text;
		}

		for ($pass = 0; $pass < 5; $pass++)
		{
			$next = str_replace($search, $replace, $text);

			if ($next === $text)
			{
				break;
			}

			$text = $next;
		}

		return $text;
	}

	/**
	 * The system-wide placeholder rows, decoded exactly as the compiler decodes them.
	 *
	 * @return  array<string, string>  Bare target keyed to its value, in table order.
	 * @since   6.1.9
	 */
	protected function globals(): array
	{
		if ($this->globals !== null)
		{
			return $this->globals;
		}

		$this->globals = [];
		$rows = $this->load->items(
			['a.target' => 'target', 'a.value' => 'value'],
			['a' => 'placeholder']
		);

		foreach ((array) $rows as $row)
		{
			$row = (array) $row;
			$target = $this->target((string) ($row['target'] ?? ''));

			if ($target === '')
			{
				continue;
			}

			$value = base64_decode((string) ($row['value'] ?? ''));

			if (!$this->text($value))
			{
				// a row that does not decode to text cannot stand for anything,
				// and must never reach a report a page has to read
				$this->report->set(
					'powers.undecodable.placeholder.' . $this->key($target),
					$target
				);

				continue;
			}

			$this->globals[$target] = $value;
		}

		return $this->globals;
	}

	/**
	 * Whether a value is text a report can carry and a namespace can be built from.
	 *
	 * @param   string  $value  The value to test.
	 *
	 * @return  bool  True when the value is valid UTF-8.
	 * @since   6.1.9
	 */
	protected function text(string $value): bool
	{
		return preg_match('//u', $value) === 1;
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.9
	 */
	protected function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}

	/**
	 * One bare target in the bracketed form a namespace carries it.
	 *
	 * @param   string  $target  The bare target.
	 *
	 * @return  string  The bracketed placeholder.
	 * @since   6.1.9
	 */
	protected function wrap(string $target): string
	{
		return '[[[' . $target . ']]]';
	}

	/**
	 * Resolve the values for the configured component, once.
	 *
	 * @return  array{prefix: string, component: string, code: string, recognise: array<string>, overrides: array<string, string>}  The resolved values.
	 * @since   6.1.7
	 */
	protected function values(): array
	{
		$id = (int) $this->config->get('component', 0);
		$named = trim((string) $this->config->get('componentCode', ''));

		if ($named === '')
		{
			// a run harvesting a component and its library together has already
			// discovered what that component is called, and the library's
			// component-owned classes are that component's -- so the two halves
			// of one run resolve the same segment without being told twice.
			// The source names it as Joomla does, com_ and all; the segment is
			// derived from the code name alone, exactly as the compiler does
			$named = (string) preg_replace(
				'/^com_/i',
				'',
				trim((string) $this->source->get('code_name', ''))
			);
		}

		$key = $id . '|' . $named;

		if (isset($this->resolved[$key]))
		{
			// a fresh run reads a fresh report, which must still carry the
			// values that drive every namespace conversion
			$this->report->set('powers.placeholders', [
				'prefix' => $this->resolved[$key]['prefix'],
				'component' => $this->resolved[$key]['component'],
				'recognise' => $this->resolved[$key]['recognise'],
				'overrides' => array_keys($this->resolved[$key]['overrides'])
			]);

			return $this->resolved[$key];
		}

		$prefix = '';
		$component = '';
		$guid = '';
		$code = '';

		if ($id > 0)
		{
			$row = $this->load->item(
				[
					'a.guid' => 'guid',
					'a.name_code' => 'name_code',
					'a.add_namespace_prefix' => 'add_namespace_prefix',
					'a.namespace_prefix' => 'namespace_prefix'
				],
				['a' => 'joomla_component'],
				['a.id' => $id]
			);

			if ($row !== null)
			{
				$guid = trim((string) ($row->guid ?? ''));
				$code = $this->code((string) ($row->name_code ?? ''));
				$component = $this->segment($code);

				if ((int) ($row->add_namespace_prefix ?? 0) === 1)
				{
					$prefix = trim((string) ($row->namespace_prefix ?? ''));
				}
			}
			else
			{
				$this->report->set('powers.failed.component', $id);
			}
		}

		if ($code === '' && $named !== '')
		{
			// a run harvesting a library for a component it is about to create
			// has no row to ask, but it does know what the component is called,
			// and that is the same thing the compiler derives the segment from
			$code = $this->code($named);
			$component = $this->segment($code);
		}

		if ($prefix === '')
		{
			$prefix = $this->fallbackPrefix();
		}

		$derived = $component;
		[$prefix, $component, $overrides] = $this->override($guid, $prefix, $component, $code);

		// a built class only ever carries the namespace-safe form of these
		// values, so that form is the one every comparison runs against
		$prefix = NamespaceHelper::safe($prefix);
		$component = $component === ''
			? ''
			: NamespaceHelper::safeSegment($component);

		// Only this run's component contributes names. Namespace reconstruction
		// uses its effective value; unrelated catalogue rows cannot change it.
		$recognise = array_values(array_unique(array_filter(array_map(
			static fn (string $value): string => strtolower(trim($value)),
			[$component, $derived, $this->segment($this->code($named))]
		), 'strlen')));

		// the report names which overrides stood, never their values: a
		// value is a person's free text, and the report is read by a page
		$this->report->set('powers.placeholders', [
			'prefix' => $prefix,
			'component' => $component,
			'recognise' => $recognise,
			'overrides' => array_keys($overrides)
		]);

		return $this->resolved[$key] = [
			'id' => $id,
			'guid' => $guid,
			'prefix' => $prefix,
			'component' => $component,
			'code' => $code,
			'recognise' => $recognise,
			'overrides' => $overrides
		];
	}

	/**
	 * Apply the component's own placeholder overrides, which outrank the rest.
	 *
	 * An override value may itself lean on the core placeholders -- the
	 * compiler substitutes what it already knows into every override before
	 * using it, so the same substitution happens here.
	 *
	 * @param   string  $guid       The component identity, or an empty string.
	 * @param   string  $prefix     The resolved prefix so far.
	 * @param   string  $component  The resolved component segment so far.
	 * @param   string  $code       The component's safe code name.
	 *
	 * @return  array{0: string, 1: string, 2: array<string, string>}  The prefix and component after overrides, and every override by bare target.
	 * @since   6.1.7
	 */
	protected function override(string $guid, string $prefix, string $component, string $code): array
	{
		if ($guid === '')
		{
			return [$prefix, $component, []];
		}

		$stored = $this->load->value(
			['a.addplaceholders' => 'addplaceholders'],
			['a' => 'component_placeholders'],
			['a.joomla_component' => $guid]
		);

		if (!is_string($stored) || trim($stored) === '')
		{
			return [$prefix, $component, []];
		}

		$rows = json_decode($stored, true);

		if (!is_array($rows))
		{
			return [$prefix, $component, []];
		}

		// the compiler substitutes what it has already loaded -- the
		// system-wide rows, then the core values -- into every override
		$known = [];

		foreach ($this->globals() as $target => $value)
		{
			$known[$this->wrap($target)] = $value;
		}

		$known = array_merge($known, $this->known($code, $prefix, $component));
		$overrides = [];

		foreach ($rows as $row)
		{
			$row = (array) $row;
			$target = $this->target((string) ($row['target'] ?? ''));
			// an override value is stored as the plain text the person typed,
			// exactly as the compiler's applyComponentOverrides reads it
			$raw = trim((string) ($row['value'] ?? ''));
			$value = trim($this->substitute($raw, $known));

			if ($target === '' || $value === '' || !$this->text($raw))
			{
				continue;
			}

			// a person's own target keeps the core placeholders it leans on,
			// so the form it stands for stays comparable with every other
			$overrides[$target] = in_array($target, self::CORE, true) ? $value : $raw;

			if ($target === 'NamespacePrefix')
			{
				$prefix = $value;
			}
			elseif ($target === 'ComponentNamespace')
			{
				$component = $value;
			}
		}

		return [$prefix, $component, $overrides];
	}

	/**
	 * The core placeholders an override value may lean on.
	 *
	 * @param   string  $code       The component's safe code name.
	 * @param   string  $prefix     The resolved prefix so far.
	 * @param   string  $component  The resolved component segment so far.
	 *
	 * @return  array<string, string>  Placeholder keyed to its value, both wrapper forms.
	 * @since   6.1.7
	 */
	protected function known(string $code, string $prefix, string $component): array
	{
		$values = [
			'component' => $code,
			'Component' => ucfirst($code),
			'COMPONENT' => strtoupper($code),
			'ComponentNamespace' => $component,
			'NamespacePrefix' => $prefix,
			'NAMESPACEPREFIX' => $prefix
		];
		$known = [];

		foreach ($values as $target => $value)
		{
			$known['[[[' . $target . ']]]'] = $value;
			$known['###' . $target . '###'] = $value;
		}

		return $known;
	}

	/**
	 * The prefix the global configuration falls back on.
	 *
	 * The global value is read from the extension parameters through the same
	 * database boundary everything else in this engine uses, because the
	 * static parameter helpers require a running application this engine
	 * never assumes.
	 *
	 * @return  string  The configured prefix, or the platform default.
	 * @since   6.1.7
	 */
	protected function fallbackPrefix(): string
	{
		if ($this->fallback !== null && trim($this->fallback) !== '')
		{
			return trim($this->fallback);
		}

		$params = $this->load->value(
			['a.params' => 'params'],
			['a' => '#__extensions'],
			['a.element' => 'com_componentbuilder', 'a.type' => 'component']
		);

		if (is_string($params) && trim($params) !== '')
		{
			$params = json_decode($params, true);

			if (is_array($params))
			{
				$prefix = trim((string) ($params['namespace_prefix'] ?? ''));

				if ($prefix !== '')
				{
					return $prefix;
				}
			}
		}

		return 'JCB';
	}

	/**
	 * The safe code name a raw component code name derives.
	 *
	 * This replicates the compiler's safe lower name -- number words, the
	 * stripped characters, the underscored spaces -- without the
	 * transliteration step, because that step needs a running application
	 * and a code name is plain ASCII by its own convention.
	 *
	 * @param   string  $codeName  The component's raw code name.
	 *
	 * @return  string  The safe lower code name.
	 * @since   6.1.7
	 */
	protected function code(string $codeName): string
	{
		if (trim($codeName) === '')
		{
			return '';
		}

		$code = trim((string) StringHelper::numbers($codeName));
		$code = (string) preg_replace('/_+/', ' ', $code);
		$code = (string) preg_replace('/\s+/', ' ', $code);
		$code = (string) preg_replace('/[^A-Za-z ]/', '', $code);

		return strtolower((string) preg_replace('/\s+/', '_', trim($code)));
	}

	/**
	 * The component segment a safe code name derives, as the compiler derives it.
	 *
	 * @param   string  $code  The component's safe code name.
	 *
	 * @return  string  The namespace-safe component segment.
	 * @since   6.1.7
	 */
	protected function segment(string $code): string
	{
		if ($code === '')
		{
			return '';
		}

		return NamespaceHelper::safeSegment(ucfirst($code));
	}

	/**
	 * A placeholder target with its wrapper stripped, when it carries one.
	 *
	 * @param   string  $target  The raw target.
	 *
	 * @return  string  The bare target name.
	 * @since   6.1.7
	 */
	public function target(string $target): string
	{
		$target = trim($target);

		if (strlen($target) >= 6
			&& ((str_starts_with($target, '[[[') && str_ends_with($target, ']]]'))
				|| (str_starts_with($target, '###') && str_ends_with($target, '###'))))
		{
			return substr($target, 3, -3);
		}

		return $target;
	}
}

