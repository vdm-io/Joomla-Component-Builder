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

namespace VDM\Joomla\Componentbuilder\Extrusion\Abstraction;


use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\LayoutInterface;


/**
 * Shared mechanics for every target-version layout.
 * 
 * The subclasses supply only the build-relative placement map, which is the
 * inverse of the compiler's own settings.json move map. Everything else --
 * token expansion and the build root to source root translation -- lives here,
 * so the version folders stay thin.
 * 
 * @since 6.1.6
 */
abstract class Layout implements LayoutInterface
{
	/**
	 * The build root to source root prefix candidates.
	 *
	 * The empty prefix matches a root already pointed at the component folder
	 * itself; the bare build name matches an unzipped package that still has
	 * its top level admin and site folders; the installed prefix matches a
	 * component in place inside a Joomla tree.
	 *
	 * @var    array<string, array<string>>
	 * @since  6.1.6
	 */
	protected const ROOTS = [
		'admin' => ['administrator/components/{option}', 'admin', 'administrator', ''],
		'site' => ['components/{option}', 'site', ''],
		'media' => ['media/{option}', 'media', ''],
		'api' => ['api/components/{option}', 'api', '']
	];

	/**
	 * The build-relative placement map for this target version.
	 *
	 * Each entry is a list of build-relative patterns, most likely first. A
	 * pattern begins with its build root, such as admin/ or site/.
	 *
	 * @return  array<string, array<string>>  Artifact kind keyed to its patterns.
	 * @since   6.1.6
	 */
	abstract protected function map(): array;

	/**
	 * The target Joomla major version identity this layout describes.
	 *
	 * @return  string  A version identity such as J3, J4, J5, or J6.
	 * @since   6.1.6
	 */
	abstract public function version(): string;

	/**
	 * Every artifact kind this layout can locate.
	 *
	 * @return  array<string>  The supported artifact kind keys.
	 * @since   6.1.6
	 */
	public function kinds(): array
	{
		return array_keys($this->map());
	}

	/**
	 * The build root to source root prefix candidates.
	 *
	 * @return  array<string, array<string>>  Build root keyed to its relative prefixes.
	 * @since   6.1.6
	 */
	public function roots(): array
	{
		return self::ROOTS;
	}

	/**
	 * Relative candidate paths for one artifact kind.
	 *
	 * @param   string                $kind    The artifact kind key.
	 * @param   array<string,string>  $tokens  Replacement tokens such as option or view.
	 *
	 * @return  array<string>  Ordered relative candidate paths, most likely first.
	 * @since   6.1.6
	 */
	public function candidates(string $kind, array $tokens = []): array
	{
		$map = $this->map();

		if (!isset($map[$kind]))
		{
			return [];
		}

		$candidates = [];

		foreach ($map[$kind] as $pattern)
		{
			foreach ($this->expand($pattern, $tokens) as $candidate)
			{
				$candidates[$candidate] = true;
			}
		}

		return array_keys($candidates);
	}

	/**
	 * Expand one build-relative pattern into every source-relative candidate.
	 *
	 * @param   string                $pattern  The build-relative pattern.
	 * @param   array<string,string>  $tokens   Replacement tokens.
	 *
	 * @return  array<string>  Source-relative candidates.
	 * @since   6.1.6
	 */
	protected function expand(string $pattern, array $tokens): array
	{
		$position = strpos($pattern, '/');
		$build = $position === false ? $pattern : substr($pattern, 0, $position);
		$remainder = $position === false ? '' : substr($pattern, $position + 1);

		if (!isset(self::ROOTS[$build]))
		{
			return [$this->tokens($pattern, $tokens)];
		}

		$candidates = [];

		foreach (self::ROOTS[$build] as $prefix)
		{
			$prefix = $this->tokens($prefix, $tokens);
			$candidate = $prefix === ''
				? $remainder
				: rtrim($prefix, '/') . '/' . $remainder;
			$candidate = trim($this->tokens($candidate, $tokens), '/');

			if ($candidate !== '')
			{
				$candidates[$candidate] = true;
			}
		}

		return array_keys($candidates);
	}

	/**
	 * Replace every token in one pattern.
	 *
	 * @param   string                $pattern  The pattern.
	 * @param   array<string,string>  $tokens   Replacement tokens.
	 *
	 * @return  string  The expanded pattern.
	 * @since   6.1.6
	 */
	protected function tokens(string $pattern, array $tokens): string
	{
		if ($tokens === [])
		{
			return $pattern;
		}

		$search = [];
		$replace = [];

		foreach ($tokens as $key => $value)
		{
			$search[] = '{' . $key . '}';
			$replace[] = $value;
		}

		return str_replace($search, $replace, $pattern);
	}
}

