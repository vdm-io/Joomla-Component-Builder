<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    21st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * One operation's private effective writes and the evidence approved for them.
 * 
 * Definitions are staged in raw Data-pipeline form, not encoded SQL values.
 * The public report exposes summaries and a fingerprint, never this registry.
 * 
 * @since  6.2.0
 */
final class Plan extends Registry implements Registryinterface
{
	/**
	 * Enter a complete operation; nested engines participate in the same plan.
	 *
	 * @return  bool  True only for the engine responsible for final commit.
	 * @since   6.2.0
	 */
	public function begin(): bool
	{
		if ($this->active())
		{
			return false;
		}

		$this->clear();
		$this->set('active', true);

		return true;
	}

	/**
	 * Whether all current writer calls must be staged instead of persisted.
	 *
	 * @return  bool  True within an operation.
	 * @since   6.2.0
	 */
	public function active(): bool
	{
		return (bool) $this->get('active', false);
	}

	/**
	 * End the operation while retaining its audit summary for the caller.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function finish(): void
	{
		$this->set('active', false);
	}

	/**
	 * Record a bounded blocker under a stable diagnostic identity.
	 *
	 * @param   string  $key     The blocker identity, never a registry path.
	 * @param   string  $reason  The user-relevant reason.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function block(string $key, string $reason): void
	{
		$this->set('blockers.' . hash('sha256', $key), ['key' => $key, 'reason' => $reason]);
	}

	/**
	 * All unresolved blockers, deterministically ordered.
	 *
	 * @return  array  Public blocker records.
	 * @since   6.2.0
	 */
	public function blockers(): array
	{
		$blockers = (array) $this->get('blockers', []);
		ksort($blockers);

		return array_values($blockers);
	}

	/**
	 * Record a file already read by the bounded source scanner.
	 *
	 * @param   string  $file      The canonical observed file path.
	 * @param   string  $snapshot  Its observed SHA-256 content fingerprint.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function file(string $file, string $snapshot): void
	{
		$key = hash('sha256', $file);
		$standing = $this->get('files.' . $key);

		if ($standing !== null && $standing['snapshot'] !== $snapshot)
		{
			$this->block('source.' . $key, 'A source file changed while the operation was being prepared.');
		}

		$this->set('files.' . $key, ['file' => $file, 'snapshot' => $snapshot]);
	}

	/**
	 * Remember a bounded source enumeration, so additions also invalidate review.
	 *
	 * @param   string  $root        The validated source root.
	 * @param   array   $extensions  The scanner's extension selection.
	 * @param   array   $files       Its complete bounded file list.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function directory(string $root, array $extensions, array $files): void
	{
		$key = hash('sha256', serialize([$root, $extensions]));
		$entry = ['root' => $root, 'extensions' => $extensions, 'files' => $files];
		$previous = $this->get('directories.' . $key);

		if ($previous !== null && $previous !== $entry)
		{
			$this->block('source.directory.' . $key, 'The source file selection changed during this operation.');
		}

		$this->set('directories.' . $key, $entry);
	}

	/**
	 * Stage the exact effective fields and remember the row read before writing.
	 *
	 * @param   string       $table       The JCB entity table.
	 * @param   string       $key         The entity's natural key field.
	 * @param   string       $identity    The natural key value.
	 * @param   object       $definition  The effective raw Data-pipeline payload.
	 * @param   array        $delta       The same preview delta.
	 * @param   object|null  $standing    The raw-value Data row read for that delta.
	 * @param   mixed        $id          The observed database row id, or null.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public function stage(string $table, string $key, string $identity, object $definition, array $delta, ?object $standing, $id): void
	{
		$slot = hash('sha256', serialize((int) $id > 0 ? [$table, 'id', (int) $id] : [$table, $key, $identity]));
		$read = ['table' => $table, 'key' => $key, 'identity' => $identity,
			'id' => $id, 'snapshot' => self::digest($standing)];
		$previous = $this->get('reads.' . $slot);

		if ($previous !== null && ($previous['snapshot'] !== $read['snapshot'] || $previous['id'] !== $read['id']))
		{
			$this->block('record.' . $slot, 'A record changed while the operation was being prepared.');
		}

		$this->set('reads.' . $slot, $previous ?? $read);

		if (!$delta['changed'])
		{
			return;
		}

		$entry = $this->get('writes.' . $slot);
		$payload = get_object_vars($definition);

		if ($entry !== null)
		{
			foreach ($payload as $field => $value)
			{
				if (array_key_exists($field, $entry['payload']) && self::digest($value) !== self::digest($entry['payload'][$field]))
				{
					$this->block('write.' . $slot . '.' . $field, 'Different approved sources propose incompatible values for the same record field.');
				}
			}

			$payload = $entry['payload'] + $payload;
		}

		$origins = (array) ($entry['origins'] ?? []);
		$origins[(string) ($delta['origin'] ?? '')] = true;
		ksort($payload);
		$this->set('writes.' . $slot, ['table' => $table, 'key' => $entry['key'] ?? $key,
			'identity' => $entry['identity'] ?? $identity, 'action' => $delta['action'], 'payload' => $payload, 'origins' => $origins]);
	}

	/**
	 * Read staged writes in dependency-safe writer insertion order.
	 *
	 * @return  array  Private raw Data write entries.
	 * @since   6.2.0
	 */
	public function writes(): array
	{
		return array_values((array) $this->get('writes', []));
	}

	/**
	 * Fingerprint the plan without including changing approval or dry-run options.
	 *
	 * @return  string  SHA-256 fingerprint of targets, effects and evidence.
	 * @since   6.2.0
	 */
	public function fingerprint(): string
	{
		return self::digest([
			'context' => $this->get('context'), 'sources' => $this->get('sources', []),
			'files' => $this->get('files', []), 'directories' => $this->get('directories', []), 'reads' => $this->get('reads', []),
			'writes' => $this->get('writes', []), 'scopes' => $this->get('scopes', [])
		]);
	}

	/**
	 * Canonical private snapshot hashing, preserving scalar value types.
	 *
	 * @param   mixed  $value  A raw row, payload or structured evidence record.
	 *
	 * @return  string  Its deterministic SHA-256 digest.
	 * @since   6.2.0
	 */
	public static function digest($value): string
	{
		$normalise = static function ($input) use (&$normalise)
		{
			if (is_object($input))
			{
				$input = get_object_vars($input);
			}

			if (!is_array($input))
			{
				return $input;
			}

			if (!array_is_list($input))
			{
				ksort($input);
			}

			return array_map($normalise, $input);
		};

		return hash('sha256', serialize($normalise($value)));
	}
}

