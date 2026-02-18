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

namespace VDM\Joomla\Componentbuilder\Compiler\Joomla;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Core Namespace Resolver.
 * 
 * Detects whether a fully qualified namespace belongs to a Joomla "core style"
 * namespace pattern used by extensions (components, modules, plugins) and returns
 * the matching key/path identifier.
 * 
 * Performance goals (hot path):
 * - Resolve placeholder tokens exactly once.
 * - Pre-compute prefix lengths exactly once.
 * - Avoid repeated explode/array_filter/array_values on the same namespace.
 * - Split namespaces using a cached, allocation-minimizing strategy.
 * 
 * Correctness goals:
 * - Strict prefix matching for all core paths.
 * - For modules/plugins, derive the final filesystem-safe extension folder name
 *   from fixed namespace segments (zero-based).
 * - Return null on any invalid/unexpected input.
 * 
 * @since 5.1.4
 */
final class Path
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.4
	 */
	private Placeholder $placeholder;

	/**
	 * Canonical core namespace path definitions.
	 *
	 * These are stored in a "compiler-safe" placeholder-fragmented form and are
	 * resolved once (via Placeholder::update_()) at runtime.
	 *
	 * @var   array<string, string>
	 * @since 5.1.4
	 */
	private array $coreNamespace = [
		'admin'  => '[' . '[' . '[Namespace' . 'Prefix]' . ']' . ']\Component\[' . '[' . '[Component' . 'Namespace]' . ']' . ']\Administrator',
		'site'   => '[' . '[' . '[Namespace' . 'Prefix]' . ']' . ']\Component\[' . '[' . '[Component' . 'Namespace]' . ']' . ']\Site',
		'mod'    => '[' . '[' . '[Namespace' . 'Prefix]' . ']' . ']\Module\\',
		'plugin' => '[' . '[' . '[Namespace' . 'Prefix]' . ']' . ']\Plugin\\',
	];

	/**
	 * Cached lengths of resolved core namespace prefixes.
	 *
	 * Avoids repeated strlen() calls in the hot path.
	 *
	 * @var   array<string, int>
	 * @since 5.1.4
	 */
	private array $coreNamespaceLengths = [];

	/**
	 * Switch to ensure we resolve these just once.
	 *
	 * @var   bool
	 * @since 5.1.4
	 */
	private bool $resolved = false;

	/**
	 * Cached namespace segment arrays.
	 *
	 * This is a significant performance improvement when processing many
	 * namespaces, because it avoids repeated explode() work and repeated
	 * array allocations for identical namespace strings.
	 *
	 * NOTE: This cache grows with the number of distinct namespaces processed
	 * in a single run. That's typically acceptable for compilation workloads.
	 *
	 * @var   array<string, array<int, string>>
	 * @since 5.1.4
	 */
	private array $namespaceCache = [];

	/**
	 * Constructor.
	 *
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Detect whether a fully qualified namespace belongs to a core namespace.
	 *
	 * Matching rules:
	 * - Components (admin/site): strict prefix match only; returns the core key
	 *   ("admin" or "site") on success.
	 * - Modules ("mod"): strict prefix match, then derive extension folder
	 *   name from segment index 2 -> "mod_{lowercaseSegment}".
	 * - Plugins ("plugin"): strict prefix match, then derive extension folder
	 *   name from segments index 2 and 3 -> "plg_{lowercaseSegment2}_{lowercaseSegment3}".
	 *
	 * This method is designed as a hot path and avoids unnecessary allocations
	 * by using precomputed prefix lengths and cached namespace segments.
	 *
	 * @param   string  $namespace  Fully qualified namespace.
	 *
	 * @return  string|null  Core namespace key/path on match, null otherwise.
	 * @since   5.1.4
	 */
	public function core(string $namespace): ?string
	{
		if ($namespace === '')
		{
			return null;
		}

		$this->clearCache();

		// Ensure placeholders are resolved once and prefix lengths cached once.
		$coreMap = $this->get();

		foreach ($coreMap as $key => $corePath)
		{
			$length = $this->coreNamespaceLengths[$key] ?? 0;

			// Defensive: if something went wrong with caching, compute once here.
			if ($length === 0)
			{
				$length = strlen($corePath);
				$this->coreNamespaceLengths[$key] = $length;
			}

			// Fast reject: must start with the resolved core prefix.
			if (strncmp($namespace, $corePath, $length) !== 0)
			{
				continue;
			}

			// For module/plugin, derive the final extension path name.
			if ($key === 'mod' || $key === 'plugin')
			{
				return $this->getPathFromNamespace($namespace, $key);
			}

			// Component (pure prefix match).
			return $key;
		}

		return null;
	}

	/**
	 * Retrieve core namespace paths with placeholders resolved for the current context.
	 *
	 * This method resolves Placeholder tokens exactly once, mutating the internal
	 * $coreNamespace map into its resolved form and caching prefix lengths for
	 * hot-path comparisons.
	 *
	 * - When no key is provided, returns the full resolved map.
	 * - When a key is provided, returns the resolved path string for that key or null.
	 *
	 * @param   string|null  $key  Optional path key (e.g. "admin", "mod", "plugin").
	 *
	 * @return  array<string, string>|string|null
	 *          Resolved path map when no key is provided.
	 *          Resolved namespace path string when a key is provided and exists.
	 *          Null when a key is provided but no matching path exists.
	 *
	 * @since   5.1.4
	 */
	public function get(?string $key = null)
	{
		if (!$this->resolved)
		{
			foreach ($this->coreNamespace as $name => $path)
			{
				$resolved = $this->placeholder->update_($path);

				// Validate: resolution must produce a non-empty string.
				// If it becomes empty, matching would be unsafe (everything would match).
				if (!is_string($resolved) || $resolved === '')
				{
					// Fail closed: keep the original unresolved pattern (still non-empty).
					$resolved = $path;
				}

				$this->coreNamespace[$name] = $resolved;
				$this->coreNamespaceLengths[$name] = strlen($resolved);
			}

			$this->resolved = true;
		}

		if ($key === null)
		{
			return $this->coreNamespace;
		}

		if (!array_key_exists($key, $this->coreNamespace))
		{
			return null;
		}

		return $this->coreNamespace[$key];
	}

	/**
	 * Resolve a filesystem-safe extension path from a namespace.
	 *
	 * This method assumes the namespace has already matched the correct
	 * core base prefix for the given key (mod/plugin). It then extracts
	 * specific namespace segments (zero-based) to build the expected Joomla
	 * extension folder name:
	 *
	 * - mod:
	 *   Uses segment 2, returns: "mod_{lowercaseSegment2}"
	 *
	 * - plugin:
	 *   Uses segments 2 and 3, returns: "plg_{lowercaseSegment2}_{lowercaseSegment3}"
	 *
	 * If any required segment is missing or empty, null is returned.
	 *
	 * @param  string  $namespace  The fully-qualified namespace string.
	 * @param  string  $key        The extension key (mod|plugin).
	 *
	 * @return string|null  The resolved path or null if it cannot be determined.
	 * @since  5.1.4
	 */
	private function getPathFromNamespace(string $namespace, string $key): ?string
	{
		// Only support the two documented keys.
		if ($key !== 'mod' && $key !== 'plugin')
		{
			return null;
		}

		$segments = $this->getNamespaceSegments($namespace);

		// We expect at least 3 segments for mod: 0,1,2
		// e.g. Vendor\Module\Blog\...
		if ($key === 'mod')
		{
			if (!isset($segments[2]) || $segments[2] === '')
			{
				return null;
			}

			return 'mod_' . strtolower($segments[2]);
		}

		// We expect at least 4 segments for plugin: 0,1,2,3
		// e.g. Vendor\Plugin\Group\Name\...
		if (!isset($segments[2], $segments[3]) || $segments[2] === '' || $segments[3] === '')
		{
			return null;
		}

		return 'plg_' . strtolower($segments[2]) . '_' . strtolower($segments[3]);
	}

	/**
	 * Get namespace segments (cached) using a fast, allocation-minimizing strategy.
	 *
	 * Rules:
	 * - Leading and trailing "\" are ignored.
	 * - Empty namespaces yield an empty array.
	 *
	 * This method intentionally does NOT attempt to "fix" malformed namespaces
	 * containing consecutive backslashes (e.g. "Foo\\\Bar"). Such strings are
	 * considered invalid input in the compiler context and will likely fail
	 * downstream validation (missing expected indexes).
	 *
	 * The cache key is the original $namespace string as provided to maintain
	 * predictable results.
	 *
	 * @param  string  $namespace  The namespace to split.
	 *
	 * @return array<int, string>  Namespace segments in order.
	 * @since  5.1.4
	 */
	private function getNamespaceSegments(string $namespace): array
	{
		if (isset($this->namespaceCache[$namespace]))
		{
			return $this->namespaceCache[$namespace];
		}

		$trimmed = trim($namespace, '\\');

		if ($trimmed === '')
		{
			return $this->namespaceCache[$namespace] = [];
		}

		// explode() is the fastest practical approach here.
		return $this->namespaceCache[$namespace] = explode('\\', $trimmed);
	}

	/**
	 * Clear the internal namespace cache.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	private function clearCache(): void
	{
		$this->namespaceCache = [];
	}
}

