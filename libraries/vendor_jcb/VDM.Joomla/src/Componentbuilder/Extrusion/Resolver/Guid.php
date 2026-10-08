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


/**
 * Derives the stable identity an extruded definition is written under.
 * 
 * The Data pipeline resolves insert against update from the GUID, so identity is
 * what makes a second run over the same source update in place instead of
 * producing a duplicate definition set. When the source is a JCB-built component
 * its table definition class already carries a per-field GUID, which is the
 * ideal case; everything else gets a name-based version 5 identifier so the same
 * source always derives the same GUID.
 * 
 * @since 6.1.6
 */
final class Guid
{
	/**
	 * The extrusion namespace the derived identifiers live in.
	 *
	 * This is a fixed, arbitrary version 4 GUID used only as a hashing
	 * namespace, so derived identity is stable across runs and installations.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const NAMESPACE = 'b7d0f1a2-3c64-4f18-9a5e-2f7c8d1b6e30';

	/**
	 * Whether a string is a well formed GUID.
	 *
	 * @param   mixed  $guid  The candidate value.
	 *
	 * @return  bool  True when the value is a canonical GUID.
	 * @since   6.1.6
	 */
	public function valid($guid): bool
	{
		if (!is_string($guid) || $guid === '')
		{
			return false;
		}

		// \z rather than $ on purpose: $ also matches before a trailing newline,
		// which would let "<guid>\n" pass as canonical and be written as identity.
		return preg_match(
			'/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\z/i',
			$guid
		) === 1;
	}

	/**
	 * Derive a stable version 5 GUID from the source coordinates.
	 *
	 * @param   array<string>  $parts  The coordinate parts, such as option, table, column.
	 *
	 * @return  string  A canonical version 5 GUID.
	 * @since   6.1.6
	 */
	public function derive(array $parts): string
	{
		$name = implode('|', array_map(
			static fn ($part): string => strtolower(trim((string) $part)),
			$parts
		));

		return $this->version5(self::NAMESPACE, $name);
	}

	/**
	 * Prefer a supplied GUID, falling back to a derived one.
	 *
	 * @param   mixed          $supplied  The GUID the source supplied, if any.
	 * @param   array<string>  $parts     The coordinate parts for derivation.
	 *
	 * @return  string  The identity to write under.
	 * @since   6.1.6
	 */
	public function prefer($supplied, array $parts): string
	{
		if ($this->valid($supplied))
		{
			return strtolower((string) $supplied);
		}

		return $this->derive($parts);
	}

	/**
	 * Compute a name-based version 5 GUID.
	 *
	 * @param   string  $namespace  The namespace GUID.
	 * @param   string  $name       The name within that namespace.
	 *
	 * @return  string  A canonical version 5 GUID.
	 * @since   6.1.6
	 */
	protected function version5(string $namespace, string $name): string
	{
		$binary = '';

		foreach (str_split(str_replace('-', '', $namespace), 2) as $pair)
		{
			$binary .= chr((int) hexdec($pair));
		}

		$hash = sha1($binary . $name);

		return sprintf(
			'%08s-%04s-%04x-%04x-%12s',
			substr($hash, 0, 8),
			substr($hash, 8, 4),
			(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
			(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
			substr($hash, 20, 12)
		);
	}
}

