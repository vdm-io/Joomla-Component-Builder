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


use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;


/**
 * Converts between a class's real namespace and the form a power row stores.
 * 
 * A stored power namespace describes a compiled name and placement, not GUID
 * identity. Its backslash segments name the vendor library folder, the dots in its last
 * segment name the folders below src, and its final dot part is the class
 * itself -- the exact inverse of what Compiler\Power::setNamespace unfolds.
 * Reversing a built class is therefore two independent conversions: fold the
 * file's location back into the dot form, and defer the resolved prefix and
 * component segments back to their placeholders. Matching an existing power
 * runs the same conversions the other way.
 * 
 * @since 6.1.7
 */
final class Namespacer
{
	/**
	 * The Placeholders Resolver.
	 *
	 * @var    Placeholders
	 * @since  6.1.7
	 */
	protected Placeholders $placeholders;

	/**
	 * Creates isolated compiler placement helpers through the service provider.
	 *
	 * @var    \Closure|null
	 * @since  6.2.0
	 */
	protected ?\Closure $outputFactory;

	/**
	 * Constructor.
	 *
	 * @param   Placeholders   $placeholders   The placeholder value resolver.
	 * @param   \Closure|null  $outputFactory  Isolated placement factory; optional for legacy namespace-only callers.
	 *
	 * @since   6.1.7
	 */
	public function __construct(Placeholders $placeholders, ?\Closure $outputFactory = null)
	{
		$this->placeholders = $placeholders;
		$this->outputFactory = $outputFactory;
	}

	/**
	 * Isolate mutable placeholder caches when revalidating a reviewed snapshot.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function __clone()
	{
		$this->placeholders = clone $this->placeholders;
	}

	/**
	 * Fold a class's declared namespace and location into the stored dot form.
	 *
	 * The library's own folder name is the first authority: a dotted name such
	 * as VDM.Joomla states, in the only place the convention states it, how
	 * many leading namespace segments were folded into that one folder. Those
	 * segments stay backslashed as the head; everything below them mirrors the
	 * folders under src and becomes dots. Where the folder name says nothing,
	 * the path decides -- the segments the folders mirror become dot parts, and
	 * the rest stays the head. A file whose path contradicts its namespace has
	 * no seam to read, so null says the convention must decide instead.
	 *
	 * The folders below the source root are only the part of the path the
	 * run was aimed at. A person may aim it at a folder deeper than the real
	 * source root -- a component's own Engine folder, say -- and the folders
	 * above that root then mirror more of the namespace than the folders
	 * below it. The seam is where the mirroring stops, wherever the run was
	 * aimed, because that is where the compiler put the class.
	 *
	 * @param   string         $namespace  The declared namespace, without the class.
	 * @param   string         $class      The class name.
	 * @param   array<string>  $folders    The folder names below the source root.
	 * @param   string         $library    The library's own folder name, when it has one.
	 * @param   array<string>  $above      The folder names of the source root itself, outermost first.
	 *
	 * @return  string|null  The stored form, or null when path and namespace disagree.
	 * @since   6.1.7
	 */
	public function stored(string $namespace, string $class, array $folders, string $library = '', array $above = []): ?string
	{
		$segments = $this->segments($namespace);
		$folders = array_values(array_filter(array_map('strval', $folders), 'strlen'));
		$above = array_values(array_filter(array_map('strval', $above), 'strlen'));
		$count = count($folders);

		if ($segments === [] || $count > count($segments))
		{
			return null;
		}

		if ($folders !== array_slice($segments, count($segments) - $count))
		{
			return null;
		}

		$mirrored = $count + $this->mirrored(
			array_slice($segments, 0, count($segments) - $count),
			$above
		);

		$keep = $this->head($library, $segments, count($segments) - $mirrored);
		$head = array_slice($segments, 0, $keep);
		$tail = implode('.', array_merge(array_slice($segments, $keep), [$class]));

		return implode('\\', $head) . '\\' . $tail;
	}

	/**
	 * How many trailing namespace segments the trailing folders mirror.
	 *
	 * Counted from the innermost folder outward, segment for segment and
	 * name for name, until the first folder that is not the segment above it
	 * -- the source root itself, in every layout the compiler writes.
	 *
	 * @param   array<string>  $segments  The namespace segments still unaccounted for.
	 * @param   array<string>  $folders   The folder names, outermost first.
	 *
	 * @return  int  The number of mirrored segments.
	 * @since   6.1.9
	 */
	protected function mirrored(array $segments, array $folders): int
	{
		$found = 0;
		$stop = min(count($segments), count($folders));

		while ($found < $stop
			&& $segments[count($segments) - 1 - $found]
				=== $folders[count($folders) - 1 - $found])
		{
			$found++;
		}

		return $found;
	}

	/**
	 * How many leading namespace segments the head keeps.
	 *
	 * A dotted library folder names its own head, segment for segment, so when
	 * the namespace opens with exactly those segments the folder has answered.
	 * Otherwise the path's own seam stands, and a head the path leaves empty
	 * falls back to the convention every power JCB ships follows.
	 *
	 * @param   string         $library   The library's own folder name.
	 * @param   array<string>  $segments  The namespace segments.
	 * @param   int            $seam      The head length the path implies.
	 *
	 * @return  int  The number of segments the head keeps.
	 * @since   6.1.8
	 */
	protected function head(string $library, array $segments, int $seam): int
	{
		$stated = $this->vendor($library);
		$length = count($stated);

		if ($length > 0 && $length <= count($segments)
			&& $stated === array_slice($segments, 0, $length))
		{
			return $length;
		}

		// a stored namespace needs a backslash head to be a namespace at all,
		// and the convention keeps two segments as the vendor folder name
		return max($seam, min(2, count($segments)));
	}

	/**
	 * The namespace segments one library folder name states.
	 *
	 * The dots in a library's folder name are the convention's own record of
	 * the segments that were folded into it, so a name carrying none states
	 * nothing and is left to the path to answer for.
	 *
	 * @param   string  $library  The library's own folder name.
	 *
	 * @return  array<string>  The stated segments, or none.
	 * @since   6.1.8
	 */
	public function vendor(string $library): array
	{
		$library = trim($library);

		if ($library === '' || !str_contains($library, '.'))
		{
			return [];
		}

		return array_values(array_filter(explode('.', $library), 'strlen'));
	}

	/**
	 * Fold a namespace into the stored form by convention alone.
	 *
	 * Every power JCB ships keeps its first two segments as the vendor folder
	 * and dots the rest, so when a file's path cannot say where the seam sits,
	 * that convention is the best available answer.
	 *
	 * @param   string  $namespace  The declared namespace, without the class.
	 * @param   string  $class     The class name.
	 *
	 * @return  string  The stored form.
	 * @since   6.1.7
	 */
	public function conventional(string $namespace, string $class): string
	{
		$segments = $this->segments($namespace);

		if (count($segments) <= 2)
		{
			return implode('\\', array_merge($segments, [$class]));
		}

		$head = array_slice($segments, 0, 2);
		$tail = array_merge(array_slice($segments, 2), [$class]);

		return implode('\\', $head) . '\\' . implode('.', $tail);
	}

	/**
	 * Defer the vendor prefix and the component named for this source context.
	 *
	 * Only the selected component's code name or the entered creation name
	 * authorises component replacement. Its effective compiler namespace is
	 * compared with whole namespace segments, never the class or other catalogue
	 * names. The stored backslash/dot placement remains exactly as observed.
	 *
	 * @param   string      $stored   The concrete stored namespace.
	 * @param   bool        $witness  Retained for callers; a lookup never witnesses ownership.
	 * @param   array|null  $context  The source component context, or the active one.
	 *
	 * @return  string  The portable form with unrelated namespace segments preserved.
	 * @since   6.1.7
	 * @since   6.2.2  Reconstruct component segments from the run's named component.
	 */
	public function placeholderize(string $stored, bool $witness = true, ?array $context = null): string
	{
		$context ??= $this->context();
		[$segments, $joiners] = $this->split($stored);
		$component = (string) ($context['component'] ?? '');
		$named = (string) ($context['code'] ?? '') !== '' && $component !== '';
		$last = count($segments) - 1;

		if ($last > 0 && $segments[0] !== '')
		{
			$segments[0] = Placeholders::PREFIX;
		}

		if ($named)
		{
			for ($index = 1; $index < $last; $index++)
			{
				if (strcasecmp($segments[$index], $component) === 0)
				{
					$segments[$index] = Placeholders::COMPONENT;
				}
			}
		}

		return $segments[0] . $this->join(array_slice($segments, 1), $joiners);
	}

	/**
	 * The one form a stored namespace has, whatever placeholders it was written through.
	 *
	 * A person may store a namespace through a placeholder of their own --
	 * [[[ComponentEngineNamespace]]].Team, where the placeholder stands for
	 * the whole head -- and the compiler resolves it to the very class the
	 * long form names. Their lookup forms agree without establishing a shared
	 * definition identity, so both fold to
	 * this one: every placeholder the person defined is substituted in the
	 * compiler's own order, the core placeholders stay standing, and the two
	 * wrapper forms become one.
	 *
	 * @param   string      $stored   The stored form, placeholders included.
	 * @param   array|null  $context  The applicable component context.
	 *
	 * @return  string  The canonical stored form.
	 * @since   6.1.9
	 */
	public function canonical(string $stored, ?array $context = null): string
	{
		$custom = $this->custom($context);
		$stored = $this->placeholders->substitute(trim($stored, '\\'), $custom);

		return (string) preg_replace('/###([A-Za-z0-9_]+)###/', '[[[$1]]]', $stored);
	}

	/**
	 * Express a stored namespace through the placeholders the system holds.
	 *
	 * The inverse of canonical: where a person has defined a placeholder
	 * that stands for a namespace head -- the whole of it or a leading run
	 * of it -- a class that sits under that head is stored the way the person
	 * stores everything else under it. The placeholder covering the longest
	 * leading run of segments wins, its value read as the compiler would
	 * resolve it, and the joiner that stood after the covered run is kept:
	 * a dot where a folder follows, a backslash where the head continues.
	 * Only a value that is itself a namespace fragment can stand for one.
	 *
	 * @param   string      $stored   The canonical stored form.
	 * @param   array|null  $context  The applicable namespace context.
	 *
	 * @return  string  The stored form as the person would write it.
	 * @since   6.1.9
	 */
	public function express(string $stored, ?array $context = null): string
	{
		$stored = $this->canonical($stored, $context);
		[$segments, $joiners] = $this->split($stored);
		$total = count($segments);
		$map = $context['map'] ?? $this->placeholders->map();
		$best = null;
		$covered = 0;

		foreach ($this->custom($context) as $placeholder => $value)
		{
			if (!str_contains($value, '\\'))
			{
				continue;
			}

			[$parts, $joins] = $this->split($this->canonical($value, $context));
			$length = count($parts);

			if ($length < 2 || $length >= $total || $length <= $covered
				|| !$this->opens($segments, $joiners, $parts, $joins, $map))
			{
				continue;
			}

			$best = $placeholder;
			$covered = $length;
		}

		if ($best === null)
		{
			return $stored;
		}

		return $best . $this->join(
			array_slice($segments, $covered),
			array_slice($joiners, $covered - 1)
		);
	}

	/**
	 * Whether one namespace opens with the given segments, joined the same way.
	 *
	 * Two segments are the same when they resolve to the same word under the
	 * run's placeholder values -- a concrete VDM and VDM
	 * agree when that is what the prefix resolves to -- and case aside, as
	 * PHP reads namespaces.
	 *
	 * @param   array<string>          $segments  The namespace segments.
	 * @param   array<string>          $joiners   The joiner after each segment but the last.
	 * @param   array<string>          $parts     The leading segments to test for.
	 * @param   array<string>          $joins     The joiner after each part but the last.
	 * @param   array<string, string>  $map       Placeholder keyed to its value.
	 *
	 * @return  bool  True when the namespace opens with the parts.
	 * @since   6.1.9
	 */
	protected function opens(array $segments, array $joiners, array $parts, array $joins, array $map): bool
	{
		$search = array_keys($map);
		$replace = array_values($map);

		foreach ($parts as $index => $part)
		{
			$part = str_replace($search, $replace, $part);
			$segment = str_replace($search, $replace, (string) ($segments[$index] ?? ''));

			if ($part === '' || strcasecmp($part, $segment) !== 0)
			{
				return false;
			}

			if ($index < count($parts) - 1
				&& ($joins[$index] ?? '') !== ($joiners[$index] ?? ''))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Split a stored namespace into its segments and the joiners between them.
	 *
	 * @param   string  $stored  The stored form.
	 *
	 * @return  array{0: array<string>, 1: array<string>}  The segments, and the joiner after each but the last.
	 * @since   6.1.9
	 */
	protected function split(string $stored): array
	{
		$segments = [''];
		$joiners = [];
		$length = strlen($stored);

		for ($i = 0; $i < $length; $i++)
		{
			$char = $stored[$i];

			if ($char === '\\' || $char === '.')
			{
				$joiners[] = $char;
				$segments[] = '';

				continue;
			}

			$segments[count($segments) - 1] .= $char;
		}

		return [$segments, $joiners];
	}

	/**
	 * Join segments back, each preceded by the joiner that stood before it.
	 *
	 * @param   array<string>  $segments  The segments.
	 * @param   array<string>  $joiners   The joiner before each segment.
	 *
	 * @return  string  The joined text.
	 * @since   6.1.9
	 */
	protected function join(array $segments, array $joiners): string
	{
		$joined = '';

		foreach (array_values($segments) as $index => $segment)
		{
			$joined .= ($joiners[$index] ?? '\\') . $segment;
		}

		return $joined;
	}

	/**
	 * Drop everything the conversions witnessed, so a fresh run reads fresh.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.9
	 */
	public function forget(): self
	{
		$this->placeholders->forget();

		return $this;
	}

	/**
	 * Unfold a stored namespace into the real fully qualified class name.
	 *
	 * @param   string      $stored   The stored form, with or without placeholders.
	 * @param   array|null  $context  The applicable component context.
	 *
	 * @return  string  The fully qualified class name, or an empty string when
	 *                  a placeholder in it has no value to resolve to.
	 * @since   6.1.7
	 */
	public function resolve(string $stored, ?array $context = null): string
	{
		$stored = $this->placeholders->substitute($stored, $context['map'] ?? $this->placeholders->map());

		if (str_contains($stored, '[[[') || str_contains($stored, '###'))
		{
			return '';
		}

		// the compiler cleans namespace segments harder than the class name:
		// a segment keeps only letters and digits, while the class keeps its
		// underscores -- so the same asymmetry applies here, or a class with
		// an underscore would never recognise its own power
		$segments = array_values(array_filter(
			explode('\\', str_replace('.', '\\', trim($stored, '\\'))),
			'strlen'
		));

		if ($segments === [])
		{
			return '';
		}

		$class = ClassfunctionHelper::safe(array_pop($segments));

		return implode('\\', array_merge(
			array_map([NamespaceHelper::class, 'safeSegment'], $segments),
			[$class]
		));
	}

	/**
	 * The index key one fully qualified class name matches under.
	 *
	 * @param   string  $fqn  The fully qualified class name.
	 *
	 * @return  string  The case-folded key.
	 * @since   6.1.7
	 */
	public function key(string $fqn): string
	{
		return strtolower(trim($fqn, '\\'));
	}

	/**
	 * A stable signature of the placeholder values conversions run under.
	 *
	 * Anything derived from a conversion is only reusable while this stays
	 * the same, because a new component or a reset can change what every
	 * placeholder resolves to.
	 *
	 * @return  string  The signature.
	 * @since   6.1.7
	 */
	public function signature(): string
	{
		return hash('sha256', (string) json_encode($this->placeholders->context(), JSON_THROW_ON_ERROR));
	}

	/**
	 * The clean segments of one backslashed namespace.
	 *
	 * @param   string  $namespace  The namespace to split.
	 *
	 * @return  array<string>  The non-empty segments.
	 * @since   6.1.7
	 */
	protected function segments(string $namespace): array
	{
		return array_values(array_filter(
			explode('\\', trim($namespace, '\\')),
			'strlen'
		));
	}
	/**
	 * Read a separate source or target context.
	 *
	 * @param   int|null  $component  The component id, or the active context.
	 *
	 * @return  array  The context snapshot.
	 * @since   6.2.0
	 */
	public function context(?int $component = null): array
	{
		return $this->placeholders->context($component);
	}

	/**
	 * Expand a stored representation without erasing its placement separators.
	 *
	 * @param   string  $stored   The stored representation.
	 * @param   array   $context  The source context.
	 *
	 * @return  string  The concrete placement representation.
	 * @since   6.2.0
	 */
	public function expand(string $stored, array $context): string
	{
		return $this->placeholders->substitute($stored, $context['map']);
	}

	/**
	 * Validate a namespace proposal against raw source namespace and placement.
	 *
	 * Existing definitions retain their established representation. New sources
	 * use the run's named component before falling back to explicit root evidence.
	 * This method validates a namespace proposal; it does not grant write scope.
	 *
	 * @param   array        $source     The raw source observation.
	 * @param   string|null  $standing   An identified existing representation.
	 * @param   array|null   $context    The verified source component context.
	 *
	 * @return  array  The representation, placement and round-trip verdict.
	 * @since   6.2.0
	 * @since   6.2.2  Record explicit component-name reconstruction separately from root evidence.
	 */
	public function proposal(array $source, ?string $standing = null, ?array $context = null): array
	{
		$context ??= $this->context();
		$stored = (string) ($source['stored'] ?? '');
		$fqn = (string) ($source['fqn'] ?? '');
		$context = $this->sourceContext($stored, $context);
		$value = $standing;
		$provenance = 'identified-definition';

		if ($value === null)
		{
			$value = $this->placeholderize($stored, false, $context);
			$provenance = str_contains($value, Placeholders::COMPONENT)
				? 'component-code-name' : 'literal-source';
			$value = $this->express($value, $context);
		}
		$placement = (bool) ($source['placement_valid'] ?? false);
		$relocation = false;
		$matches = $fqn !== '' && $this->key($this->resolve($value, $context)) === $this->key($fqn);

		if ($standing !== null && $matches && $placement
			&& strcasecmp($this->expand($value, $context), $stored) !== 0)
		{
			// Identity was established independently. Only a real declaration/
			// file observation, not an inferred namespace, authorises a seam move.
			if (!empty($source['placement_evidence']))
			{
				$moved = $this->reposition($stored, $this->canonical($standing, $context), $context);

				if ($moved !== null)
				{
					$value = $this->express($moved, $context);
					$relocation = true;
				}
			}
		}

		$roundTrip = $placement && $matches
			&& strcasecmp($this->expand($value, $context), $stored) === 0;

		return [
			'value' => $value,
			'preserved' => $standing !== null && $roundTrip && !$relocation,
			'round_trip' => $roundTrip,
			'relocation' => $relocation,
			'source_fqn' => $this->resolve($value, $context),
			'target_fqn' => $this->resolve($value),
			'provenance' => $provenance
		];
	}

	/**
	 * Repair literal namespace roles without replacing established placeholders.
	 *
	 * The existing representation supplies the placement seam. Only literal
	 * vendor/component segments are deferred; a curated symbolic head stays as
	 * written. Both the source round trip and the selected component's compiled
	 * class/file destination must remain valid, without auxiliary value writes.
	 *
	 * @param   array       $source    The matched source declaration and placement.
	 * @param   string      $standing  The identified Power's stored namespace.
	 * @param   array|null  $context   The verified source component context.
	 *
	 * @return  array  The namespace-only proposal and its validation verdict.
	 * @since   6.2.2
	 */
	public function repair(array $source, string $standing, ?array $context = null): array
	{
		$context ??= $this->context();
		$proposal = $this->proposal($source, $standing, $context);

		if (!$proposal['round_trip'] || $proposal['relocation'])
		{
			$proposal['round_trip'] = false;
			$proposal['repair_error'] = 'Namespace repair requires the existing namespace and file placement to match the source without relocation.';

			return $proposal;
		}

		[$original] = $this->split($standing);
		[$segments, $joiners] = $this->split($this->placeholderize($standing, false, $context));

		// A custom head may stand for several namespace segments. Replacing
		// it with the vendor role would discard the person's representation.
		if (str_contains($original[0], '[[[') || str_contains($original[0], '###'))
		{
			$segments[0] = $original[0];
		}

		$value = $segments[0] . $this->join(array_slice($segments, 1), $joiners);

		if ($value === $standing)
		{
			return $proposal;
		}

		$repaired = $this->proposal($source, $value, $context);
		$before = $this->output($standing);
		$after = $this->output($value);
		$repaired['round_trip'] = $repaired['round_trip'] && !$repaired['relocation']
			&& $before !== null && $after !== null
			&& strcasecmp($before['fqn'], $after['fqn']) === 0
			&& $before['path'] === $after['path'];
		$repaired['preserved'] = false;
		$repaired['provenance'] = 'namespace-repair';

		if (!$repaired['round_trip'])
		{
			$repaired['repair_error'] = 'The repaired namespace would change the compiled class or file path. Check the selected component namespace configuration before repairing.';
		}

		return $repaired;
	}

	/**
	 * Preserve the independent vendor axis in a source reconstruction context.
	 *
	 * @param   string  $stored   The raw source placement.
	 * @param   array   $context  The applicable component context.
	 *
	 * @return  array  A copy with the verified source vendor prefix.
	 * @since   6.2.0
	 */
	public function sourceContext(string $stored, array $context): array
	{
		$known = (string) ($context['map'][Placeholders::PREFIX] ?? '');

		if ($known === '' || strncasecmp($stored, $known . '\\', strlen($known) + 1) !== 0)
		{
			$context['map'][Placeholders::PREFIX] = explode('\\', $stored)[0] ?? '';
		}

		return $context;
	}

	/**
	 * Describe the compiler's logical output destination without running a build.
	 *
	 * Native placement is delegated to the existing compiler Path resolver. The
	 * explicitly configured standalone placeholder helpers never touch the live
	 * Compiler container, application input or an independent build's state.
	 * Library paths use a logical root because jcb_powers_path is common to all
	 * library Powers within a build; native extension roots remain separate.
	 *
	 * @param   string      $stored   The validated namespace representation.
	 * @param   array|null  $context  The output component's namespace context.
	 *
	 * @throws  \LogicException  When the placement service was not supplied.
	 * @return  array|null  Case-preserved FQN/path, or null for unresolved output.
	 * @since   6.2.0
	 */
	public function output(string $stored, ?array $context = null): ?array
	{
		$context ??= $this->context();
		$expanded = $this->expand($stored, $context);
		$head = explode('\\', trim($expanded, '\\'));

		if (count($head) < 2 || str_contains($expanded, '[[[') || str_contains($expanded, '###'))
		{
			return null;
		}

		$tail = explode('.', (string) array_pop($head));
		$class = ClassfunctionHelper::safe((string) array_pop($tail));
		$head = array_map([NamespaceHelper::class, 'safeSegment'], $head);
		$tail = array_map([NamespaceHelper::class, 'safeSegment'], $tail);

		if ($class === '' || in_array('', array_merge($head, $tail), true))
		{
			return null;
		}

		$namespace = implode('\\', array_merge($head, $tail));
		if ($this->outputFactory === null)
		{
			throw new \LogicException('The namespace output resolver requires its provider-supplied placement factory.');
		}

		$native = ($this->outputFactory)($context['map'])->core($namespace);
		$root = $native === null ? 'library:' . implode('.', $head) : 'extension:' . $native;

		return [
			'fqn' => $namespace . '\\' . $class,
			'path' => $root . '/src/' . implode('/', array_merge($tail, [$class . '.php']))
		];
	}

	/**
	 * Whether a representation contains a component-variable role.
	 *
	 * @param   string  $stored   The stored namespace.
	 * @param   array   $context  The namespace's applicable component context.
	 *
	 * @return  bool  True for a component-dependent canonical representation.
	 * @since   6.2.0
	 */
	public function componentVariable(string $stored, array $context): bool
	{
		$canonical = $this->canonical($stored, $context);

		foreach (array_diff(Placeholders::CORE, ['NamespacePrefix', 'NAMESPACEPREFIX']) as $name)
		{
			if (str_contains($canonical, '[[[' . $name . ']]]'))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Recover reusable root roles only from an independently identified Power.
	 *
	 * @param   array   $source   The source descriptor and unit identity.
	 * @param   string  $stored   The validated representation of that Power.
	 * @param   array   $context  Its verified source component context.
	 * @param   string  $guid     The identified definition providing evidence.
	 *
	 * @return  array|null  A source-unit binding, or null for literal/unresolved roots.
	 * @since   6.2.0
	 */
	public function binding(array $source, string $stored, array $context, string $guid): ?array
	{
		$canonical = $this->canonical($stored, $context);
		[$parts, $joins] = $this->split($canonical);
		$last = null;

		foreach (array_slice($parts, 0, -1) as $index => $part)
		{
			if ($this->componentVariable($part, $context))
			{
				$last = $index;
			}
		}

		if ($last === null)
		{
			return null;
		}

		$template = $parts[0];

		for ($i = 1; $i <= $last; $i++)
		{
			$template .= $joins[$i - 1] . $parts[$i];
		}

		$context = $this->sourceContext((string) $source['stored'], $context);
		$root = $this->resolve($template, $context);

		if ($root === '' || !str_starts_with($this->key((string) $source['fqn']), $this->key($root) . '\\'))
		{
			return null;
		}

		return [
			'source_unit' => (string) $source['source_unit'],
			'root' => $root,
			'template' => $template,
			'component' => (int) ($context['id'] ?? 0),
			'guid' => $guid,
			'provenance' => 'identified-definition'
		];
	}

	/**
	 * Recover core values only at independently established symbolic positions.
	 *
	 * @param   array   $source   The raw source declaration and placement.
	 * @param   string  $stored   Its validated, identified namespace representation.
	 * @param   array   $context  The source reconstruction context.
	 *
	 * @return  array|null  A consistent prefix/component pair, or no such evidence.
	 * @since   6.2.0
	 */
	public function variables(array $source, string $stored, array $context): ?array
	{
		$context = $this->sourceContext((string) $source['stored'], $context);
		[$actual] = $this->split((string) $source['stored']);
		[$parts] = $this->split($this->canonical($stored, $context));
		$cursor = 0;
		$values = [];

		foreach ($parts as $part)
		{
			[$expanded] = $this->split($this->expand($part, $context));
			$observed = array_slice($actual, $cursor, count($expanded));

			if (array_map('strtolower', $expanded) !== array_map('strtolower', $observed))
			{
				return null;
			}

			$name = $part === Placeholders::PREFIX ? 'prefix' : ($part === Placeholders::COMPONENT ? 'component' : null);

			if ($name !== null)
			{
				$value = implode('\\', $observed);

				if (isset($values[$name]) && $values[$name] !== $value)
				{
					return null;
				}

				$values[$name] = $value;
			}

			$cursor += count($expanded);
		}

		return isset($values['prefix'], $values['component']) && $cursor === count($actual) ? $values : null;
	}

	/**
	 * Apply root evidence to another declaration in the same source unit.
	 *
	 * @param   array  $source   The new raw source descriptor.
	 * @param   array  $binding  The independently validated root binding.
	 * @param   array  $context  The verified source context.
	 *
	 * @return  string|null  A round-trip-safe representation, or no applicable binding.
	 * @since   6.2.0
	 */
	public function bind(array $source, array $binding, array $context): ?string
	{
		if (($source['source_unit'] ?? '') !== ($binding['source_unit'] ?? '')
			|| !is_string($binding['root'] ?? null) || !is_string($binding['template'] ?? null))
		{
			return null;
		}

		$root = trim($binding['root'], '\\');
		$fqn = trim((string) ($source['fqn'] ?? ''), '\\');
		$context = $this->sourceContext((string) ($source['stored'] ?? ''), $context);

		if ($root === '' || !str_starts_with($this->key($fqn), $this->key($root) . '\\')
			|| $this->key($this->resolve($binding['template'], $context)) !== $this->key($root))
		{
			return null;
		}

		$template = $binding['template'] . '\\' . substr($fqn, strlen($root) + 1);

		return $this->reposition((string) $source['stored'], $template, $context);
	}

	/**
	 * Move existing symbolic spans onto a source-observed placement seam.
	 *
	 * Every symbolic span must expand to the same concrete segments. No word
	 * search, fixed depth or source-file ownership assumption is involved.
	 *
	 * @param   string  $stored    The source's observed concrete placement.
	 * @param   string  $template  The established symbolic namespace.
	 * @param   array   $context   The verified source context.
	 *
	 * @return  string|null  The validated representation with source placement.
	 * @since   6.2.0
	 */
	protected function reposition(string $stored, string $template, array $context): ?string
	{
		[$source, $joins] = $this->split($stored);
		[$parts] = $this->split($this->canonical($template, $context));
		$cursor = 0;
		$result = '';

		foreach ($parts as $part)
		{
			$expanded = $this->expand($part, $context);
			[$values, $inside] = $this->split($expanded);
			$length = count($values);
			$actual = array_slice($source, $cursor, $length);

			if (str_contains($expanded, '[[[') || str_contains($expanded, '###')
				|| array_map('strtolower', $values) !== array_map('strtolower', $actual))
			{
				return null;
			}

			$symbolic = str_contains($part, '[[[') || str_contains($part, '###');

			if ($symbolic && $inside !== array_slice($joins, $cursor, $length - 1))
			{
				return null;
			}

			$result .= $cursor === 0 ? '' : $joins[$cursor - 1];
			$result .= $symbolic ? $part : $actual[0];

			if (!$symbolic)
			{
				for ($i = 1; $i < $length; $i++)
				{
					$result .= $joins[$cursor + $i - 1] . $actual[$i];
				}
			}

			$cursor += $length;
		}

		return $cursor === count($source) && strcasecmp($this->expand($result, $context), $stored) === 0
			? $result : null;
	}
	/**
	 * Get custom namespace roots only in their applicable component context.
	 *
	 * @param   array|null  $context  An independent context or the active one.
	 *
	 * @return  array<string, string>  Ordered custom namespace values.
	 * @since   6.2.0
	 */
	protected function custom(?array $context): array
	{
		return $context === null ? $this->placeholders->custom() : array_filter(
			$context['map'],
			static fn (string $key): bool => !in_array(substr($key, 3, -3), Placeholders::CORE, true),
			ARRAY_FILTER_USE_KEY
		);
	}
}

