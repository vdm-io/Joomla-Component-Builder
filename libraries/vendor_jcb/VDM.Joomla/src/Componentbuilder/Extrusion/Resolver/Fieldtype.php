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


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Interfaces\Database\LoadInterface;


/**
 * Maps a Joomla form field type onto a JCB field type.
 * 
 * The mapping is data, not a hardcoded table. Each JCB field type row carries a
 * properties JSON whose first entry is the type property, and the example on that
 * entry is the Joomla XML type string. Reading the catalogue therefore yields the
 * authoritative mapping and keeps working as JCB gains field types.
 * 
 * Three policies the catalogue forces: a collision is settled by an exact name
 * match then an explicit override then the lowest id; a version-scoped type is
 * filtered by the target major; and an unknown type is the component's own custom
 * field type rather than a failure.
 * 
 * @since 6.1.6
 */
final class Fieldtype
{
	/**
	 * Deliberate winners where two field types claim one XML type.
	 *
	 * @var    array<string, string>
	 * @since  6.1.6
	 */
	private const OVERRIDE = ['text' => 'Text'];

	/**
	 * The attributes that can tell two claimants of one XML type apart.
	 *
	 * Joomla expresses a narrower kind of an existing field type by validating or
	 * filtering it differently rather than by naming it differently -- a telephone
	 * number is a text input with tel validation. Those two attributes are therefore
	 * the only evidence in a form that distinguishes such a pair.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const DISCRIMINATORS = ['validate', 'filter'];

	/**
	 * Field types that exist only for one generation of Joomla.
	 *
	 * @var    array<string, array<string>>
	 * @since  6.1.6
	 */
	private const SCOPED = ['repeatable' => ['J3'], 'subform' => ['J4', 'J5', 'J6']];

	/**
	 * Every field type that claims one XML type, keyed by that type.
	 *
	 * @var    array<string, array<int, array<string, mixed>>>
	 * @since  6.1.6
	 */
	protected array $claimants = [];

	/**
	 * The JCB field type used for an unrecognised type.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const FALLBACK = 'Custom';

	/**
	 * The JCB field type used for an unrecognised user-flavoured type.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const FALLBACK_USER = 'CustomUser';

	/**
	 * The Database Load Class.
	 *
	 * @var    LoadInterface
	 * @since  6.1.6
	 */
	protected LoadInterface $load;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The loaded catalogue, keyed by lower-case XML type.
	 *
	 * @var    array<string, array{id: int, name: string, properties: array<string>}>|null
	 * @since  6.1.6
	 */
	protected ?array $catalogue = null;

	/**
	 * The loaded catalogue, keyed by lower-case JCB field type name.
	 *
	 * @var    array<string, array{id: int, name: string, properties: array<string>}>
	 * @since  6.1.6
	 */
	protected array $named = [];

	/**
	 * Constructor.
	 *
	 * @param   LoadInterface  $load    The database loader.
	 * @param   Source         $source  The source identity registry.
	 * @param   Report         $report  The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(LoadInterface $load, Source $source, Report $report)
	{
		$this->load = $load;
		$this->source = $source;
		$this->report = $report;
	}

	/**
	 * The whole XML type to JCB field type catalogue.
	 *
	 * @return  array<string, array{id: int, name: string}>  Lower-case XML type keyed to its field type.
	 * @since   6.1.6
	 */
	public function catalogue(): array
	{
		if ($this->catalogue !== null)
		{
			return $this->catalogue;
		}

		$this->catalogue = [];
		$rows = $this->load->items(
			[
				'a.id' => 'id',
				'a.guid' => 'guid',
				'a.name' => 'name',
				'a.properties' => 'properties'
			],
			['a' => 'fieldtype'],
			['a.published' => 1]
		);

		foreach ((array) $rows as $row)
		{
			$row = (array) $row;
			$name = trim((string) ($row['name'] ?? ''));
			$id = (int) ($row['id'] ?? 0);

			if ($name === '' || $id === 0)
			{
				continue;
			}

			$entry = [
				'id' => $id,
				'guid' => trim((string) ($row['guid'] ?? '')),
				'name' => $name,
				'properties' => $this->propertyList($row['properties'] ?? null),
				'declared' => $this->declaredList($row['properties'] ?? null),
				'hints' => $this->hints($row['properties'] ?? null)
			];
			$this->named[strtolower($name)] = $entry;
			$xmlType = $this->xmlType($row['properties'] ?? null);

			if ($xmlType === null)
			{
				continue;
			}

			// A field type that declares extends is one JCB generates rather than one
			// Joomla ships, and its stated type is a sample name the author chooses --
			// Custom examples subjects, CustomUser examples staffusers. Indexing those
			// as literal type strings would have a component's own field claimed by the
			// wrong record, so they answer only by name and through the fallback.
			if ($this->generated($row['properties'] ?? null))
			{
				$this->report->set('fieldtype.generated.' . $name, $xmlType);

				continue;
			}

			$this->place($xmlType, $entry);
		}

		return $this->catalogue;
	}

	/**
	 * Resolve one Joomla XML field type to a JCB field type.
	 *
	 * @param   string  $type    The XML type attribute value.
	 * @param   bool    $custom  Whether an unknown type may fall back to a custom type.
	 *
	 * @return  array{id: int, name: string}|null  The JCB field type, or null.
	 * @since   6.1.6
	 */
	public function resolve(string $type, bool $custom = true): ?array
	{
		$catalogue = $this->catalogue();
		$key = strtolower(trim($type));

		if ($key === '')
		{
			return $custom ? $this->fallback($type) : null;
		}

		if (!$this->scoped($key))
		{
			$this->report->set('scoped.fieldtype.' . $this->segment($key), $type);

			return $custom ? $this->fallback($type) : null;
		}

		if (isset($catalogue[$key]))
		{
			return $catalogue[$key];
		}

		if (isset($this->named[$key]))
		{
			return $this->named[$key];
		}

		$this->report->set('unmapped.fieldtype.' . $this->segment($key), $type);

		return $custom ? $this->fallback($type) : null;
	}

	/**
	 * Resolve the JCB field type id for one XML field type.
	 *
	 * @param   string  $type  The XML type attribute value.
	 *
	 * @return  int|null  The field type id, or null when unresolved.
	 * @since   6.1.6
	 */
	public function id(string $type): ?int
	{
		$entry = $this->resolve($type);

		return $entry === null ? null : $entry['id'];
	}

	/**
	 * Resolve the JCB field type name for one XML field type.
	 *
	 * @param   string  $type  The XML type attribute value.
	 *
	 * @return  string|null  The field type name, or null when unresolved.
	 * @since   6.1.6
	 */
	public function name(string $type): ?string
	{
		$entry = $this->resolve($type);

		return $entry === null ? null : $entry['name'];
	}

	/**
	 * The custom field type an unrecognised XML type falls back to.
	 *
	 * @param   string  $type  The XML type attribute value.
	 *
	 * @return  array{id: int, name: string}|null  The fallback field type, or null.
	 * @since   6.1.6
	 */
	public function fallback(string $type): ?array
	{
		$this->catalogue();
		$wanted = stripos($type, 'user') !== false ? self::FALLBACK_USER : self::FALLBACK;
		$entry = $this->named[strtolower($wanted)] ?? null;

		if ($entry !== null)
		{
			return $entry;
		}

		return $this->named[strtolower(self::FALLBACK)] ?? null;
	}

	/**
	 * The declared property names of one JCB field type.
	 *
	 * These are the attribute names the field type is allowed to carry, which is
	 * what lets the XML composer drop an attribute JCB would not understand.
	 *
	 * @param   string  $type  The XML type attribute value.
	 *
	 * @return  array<string>  The declared property names.
	 * @since   6.1.6
	 */
	public function properties(string $type): array
	{
		$entry = $this->resolve($type);

		return $entry === null ? [] : ($entry['properties'] ?? []);
	}

	/**
	 * The full property declarations of one field type, in declared order.
	 *
	 * Every entry carries the property's name, its example value and its
	 * description -- the same declarations JCB's own field composition walks
	 * when it aligns a field's xml to its type.
	 *
	 * @param   string  $type  The Joomla XML type string.
	 *
	 * @return  array<int, array{name: string, example: string, description: string}>  The declarations.
	 * @since   6.1.7
	 */
	public function declared(string $type): array
	{
		$entry = $this->resolve($type);

		return $entry === null ? [] : ($entry['declared'] ?? []);
	}

	/**
	 * Read the full property declarations out of a properties payload.
	 *
	 * @param   mixed  $properties  The properties JSON.
	 *
	 * @return  array<int, array{name: string, example: string, description: string}>  The declarations.
	 * @since   6.1.7
	 */
	protected function declaredList($properties): array
	{
		if (!is_string($properties) || $properties === '')
		{
			return [];
		}

		$decoded = json_decode($properties, true);

		if (!is_array($decoded))
		{
			return [];
		}

		$declared = [];

		foreach ($decoded as $property)
		{
			if (!is_array($property))
			{
				continue;
			}

			$name = trim((string) ($property['name'] ?? ''));

			if ($name === '')
			{
				continue;
			}

			$declared[] = [
				'name' => $name,
				'example' => (string) ($property['example'] ?? ''),
				'description' => (string) ($property['description'] ?? ''),
				// the catalogue marks the properties a field cannot do
				// without; everything else is a choice the source makes
				'mandatory' => (string) ($property['mandatory'] ?? '') === '1'
			];
		}

		return $declared;
	}

	/**
	 * Read the declared property names out of a properties payload.
	 *
	 * @param   mixed  $properties  The properties JSON.
	 *
	 * @return  array<string>  The declared property names.
	 * @since   6.1.6
	 */
	protected function propertyList($properties): array
	{
		if (!is_string($properties) || $properties === '')
		{
			return [];
		}

		$decoded = json_decode($properties, true);

		if (!is_array($decoded))
		{
			return [];
		}

		$names = [];

		foreach ($decoded as $property)
		{
			if (!is_array($property))
			{
				continue;
			}

			$name = trim((string) ($property['name'] ?? ''));

			if ($name !== '')
			{
				$names[] = $name;
			}
		}

		return $names;
	}

	/**
	 * Place one catalogue entry, settling a collision deliberately.
	 *
	 * @param   string                                              $xmlType  The lower-case XML type.
	 * @param   array{id: int, name: string, properties: array<string>}  $entry    The candidate field type.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function place(string $xmlType, array $entry): void
	{
		$this->claimants[$xmlType][] = $entry;

		if (!isset($this->catalogue[$xmlType]))
		{
			$this->catalogue[$xmlType] = $entry;

			return;
		}

		$existing = $this->catalogue[$xmlType];

		if (strtolower($entry['name']) === $xmlType)
		{
			$this->catalogue[$xmlType] = $entry;
		}
		elseif (isset(self::OVERRIDE[$xmlType]))
		{
			if (strcasecmp($entry['name'], self::OVERRIDE[$xmlType]) === 0)
			{
				$this->catalogue[$xmlType] = $entry;
			}
		}
		elseif ($entry['id'] < $existing['id'])
		{
			$this->catalogue[$xmlType] = $entry;
		}

		$this->report->set(
			'collision.fieldtype.' . $xmlType,
			$this->catalogue[$xmlType]['name']
		);
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $value  The raw value.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.6
	 */
	protected function segment(string $value): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $value) ?? $value;
	}

	/**
	 * Whether one XML type is in scope for the detected target major.
	 *
	 * A type that is out of scope must not be reachable by its field type name
	 * either, or a Joomla 3 component would still resolve a subform.
	 *
	 * @param   string  $xmlType  The lower-case XML type.
	 *
	 * @return  bool  True when the type is usable for this target.
	 * @since   6.1.6
	 */
	protected function scoped(string $xmlType): bool
	{
		if (!isset(self::SCOPED[$xmlType]))
		{
			return true;
		}

		$version = strtoupper((string) $this->source->get('layout', ''));

		if ($version === '')
		{
			return true;
		}

		return in_array($version, self::SCOPED[$xmlType], true);
	}

	/**
	 * Read the XML type string out of a field type properties payload.
	 *
	 * @param   mixed  $properties  The properties JSON.
	 *
	 * @return  string|null  The lower-case XML type, or null.
	 * @since   6.1.6
	 */
	/**
	 * The discriminating attribute values one field type declares.
	 *
	 * @param   mixed  $properties  The stored properties JSON.
	 *
	 * @return  array<string, string>  Attribute name keyed to its stated value.
	 * @since   6.1.6
	 */
	public function hints($properties): array
	{
		$hints = [];

		if (!is_string($properties) || $properties === '')
		{
			return $hints;
		}

		$decoded = json_decode($properties, true);

		if (!is_array($decoded))
		{
			return $hints;
		}

		foreach ($decoded as $property)
		{
			if (!is_array($property))
			{
				continue;
			}

			$name = strtolower(trim((string) ($property['name'] ?? '')));
			$example = trim((string) ($property['example'] ?? ''));

			if ($example !== '' && in_array($name, self::DISCRIMINATORS, true))
			{
				$hints[$name] = strtolower($example);
			}
		}

		return $hints;
	}

	/**
	 * The field type an XML type's other claimant is better suited to.
	 *
	 * Two field types answering to one XML type is not ambiguity to be broken by a
	 * rule; it is a narrower kind of the same input, and the form says which one it
	 * meant. A field validated or filtered as tel is a telephone number even though
	 * its type reads text, so the attributes decide and nothing has to be guessed.
	 *
	 * @param   string                $xmlType     The Joomla XML type string.
	 * @param   array<string, mixed>  $attributes  The field's own stated attributes.
	 *
	 * @return  array<string, mixed>|null  The better claimant, or null when none is.
	 * @since   6.1.6
	 */
	public function discriminate(string $xmlType, array $attributes): ?array
	{
		$this->catalogue();
		$key = strtolower(trim($xmlType));
		$claimants = $this->claimants[$key] ?? [];

		if (count($claimants) < 2 || $attributes === [])
		{
			return null;
		}

		$stated = [];

		foreach (self::DISCRIMINATORS as $name)
		{
			$value = $attributes[$name] ?? null;

			if (is_scalar($value) && trim((string) $value) !== '')
			{
				$stated[$name] = strtolower(trim((string) $value));
			}
		}

		if ($stated === [])
		{
			return null;
		}

		$standing = (string) (($this->catalogue[$key] ?? [])['name'] ?? '');

		foreach ($claimants as $entry)
		{
			// The type that would have been chosen anyway needs no discriminating, and
			// saying it was discriminated would suggest a decision that never happened.
			if (strcasecmp((string) $entry['name'], $standing) === 0)
			{
				continue;
			}

			foreach ((array) ($entry['hints'] ?? []) as $name => $hint)
			{
				if (($stated[$name] ?? null) === $hint)
				{
					$this->report->set(
						'fieldtype.discriminated.' . $key,
						$entry['name'] . ' by ' . $name . '="' . $hint . '"'
					);

					return $entry;
				}
			}
		}

		return null;
	}

	/**
	 * Whether one field type is generated by JCB rather than shipped by Joomla.
	 *
	 * A generated field type declares what it extends, and its own type name is
	 * whatever the component author decides to call it. That makes its stated type a
	 * placeholder rather than a literal, which is exactly the distinction that
	 * decides whether it may claim a real component's field.
	 *
	 * @param   mixed  $properties  The stored properties JSON.
	 *
	 * @return  bool  True when the field type is generated.
	 * @since   6.1.6
	 */
	public function generated($properties): bool
	{
		if (!is_string($properties) || $properties === '')
		{
			return false;
		}

		$decoded = json_decode($properties, true);

		if (!is_array($decoded))
		{
			return false;
		}

		foreach ($decoded as $property)
		{
			if (is_array($property) && ($property['name'] ?? '') === 'extends')
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * The Joomla XML type string one field type declares.
	 *
	 * The type is stored as one of the field type's own properties rather than as a
	 * column, so it is found by name. Keying on the property named type matters more
	 * than it looks: the property keys are ordinal slots and their numeric order is
	 * not always their order in the record, so the first entry is not reliably the
	 * type.
	 *
	 * @param   mixed  $properties  The stored properties JSON.
	 *
	 * @return  string|null  The lower-case XML type, or null when none is stated.
	 * @since   6.1.6
	 */
	protected function xmlType($properties): ?string
	{
		if (!is_string($properties) || $properties === '')
		{
			return null;
		}

		$decoded = json_decode($properties, true);

		if (!is_array($decoded))
		{
			return null;
		}

		foreach ($decoded as $property)
		{
			if (!is_array($property))
			{
				continue;
			}

			if (($property['name'] ?? '') !== 'type')
			{
				continue;
			}

			$example = trim((string) ($property['example'] ?? ''));

			return $example === '' ? null : strtolower($example);
		}

		return null;
	}
}

