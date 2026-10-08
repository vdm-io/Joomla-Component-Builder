<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    28th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Resolver;


use VDM\Joomla\Interfaces\TableInterface;


/**
 * Composes the field record one resolved column would write, identity aside.
 * 
 * A field's properties ARE its record: the field type, the database shape and
 * the stored form element together carry everything the source stated. This
 * resolver builds those columns once, in one place, so the writer persists
 * exactly what the identity rules compared -- and it distils them into one
 * hash, because two columns whose records would be byte-identical are one
 * field, and a standing record whose stored columns carry that same hash is
 * that field already written.
 * 
 * The mappings here are the compiler's own: store codes as
 * Compiler\Creator\Builders::store() reads them, index numbers as the field
 * form offers them, EMPTY as JCB's word for a column carrying no DEFAULT
 * clause, and the index names JCB claims for the columns it manages itself.
 * Every fact the mapping has to give up is returned as a note under the very
 * report key the writer records it under, so composing for a hash never
 * reports and composing for a write never loses a finding.
 * 
 * @since 6.1.9
 */
final class Record
{
	/**
	 * Default lengths JCB offers directly rather than as an other value.
	 *
	 * @var    array<string>
	 * @since  6.1.9
	 */
	private const SIZES = ['1', '7', '10', '11', '50', '64', '100', '255', '1024', '2048'];

	/**
	 * Default values JCB offers directly rather than as an other value.
	 *
	 * @var    array<string>
	 * @since  6.1.9
	 */
	private const DEFAULTS = ['', '0', '1', 'CURRENT_TIMESTAMP', 'DATETIME'];

	/**
	 * How a column's stored form is numbered, as JCB's own compiler reads it.
	 *
	 * Compiler\Creator\Builders::store() is the authority and it switches on
	 * these numbers: 1 is json, 2 is base64, and 5 is the medium encryption --
	 * which is the reverse of the order the words suggest. Reading them the
	 * other way round does not fail, it succeeds quietly: a base64 column is
	 * marked json, and the component built from it then tries to json decode
	 * every value the old one wrote. admin/forms/field.xml offers the same
	 * numbers, bar 4, which the compiler still handles.
	 *
	 * @var    array<string, int>
	 * @since  6.1.9
	 */
	private const STORES = [
		'json' => 1,
		'base64' => 2,
		'basic_encryption' => 3,
		'whmcs_encryption' => 4,
		'medium_encryption' => 5,
		'expert_mode' => 6
	];

	/**
	 * The index names JCB claims for the columns it manages itself.
	 *
	 * Compiler\Architecture\Component\InstallSql writes each of these after a
	 * view's own field indexes, guarding each on the name of the column it
	 * indexes rather than on the name of the index. A field named for one of
	 * these indexes therefore slips past the guard and the table is written
	 * with the same key name twice, which MySQL refuses outright (1061) -- so
	 * the component builds and then installs nothing at all.
	 *
	 * @var    array<string, string>
	 * @since  6.1.9
	 */
	private const CLAIMED = [
		'idx_access' => 'access',
		'idx_checkout' => 'checked_out',
		'idx_createdby' => 'created_by',
		'idx_modifiedby' => 'modified_by',
		'idx_state' => 'published'
	];

	/**
	 * The record columns one hash speaks for, in canonical order.
	 *
	 * @var    array<string>
	 * @since  6.1.9
	 */
	private const CANON = [
		'fieldtype', 'datatype', 'datalenght', 'datalenght_other',
		'datadefault', 'datadefault_other', 'indexes', 'null_switch',
		'store', 'xml'
	];

	/**
	 * The Fieldtype Resolver.
	 *
	 * @var    Fieldtype
	 * @since  6.1.9
	 */
	protected Fieldtype $fieldtype;

	/**
	 * The FieldXml Resolver.
	 *
	 * @var    FieldXml
	 * @since  6.1.9
	 */
	protected FieldXml $fieldxml;

	/**
	 * The JCB table definitions, the source of truth for every column.
	 *
	 * @var    TableInterface
	 * @since  6.1.9
	 */
	protected TableInterface $tables;

	/**
	 * Constructor.
	 *
	 * @param   Fieldtype       $fieldtype  The field type resolver.
	 * @param   FieldXml        $fieldxml   The field XML composer.
	 * @param   TableInterface  $tables     The JCB table definitions.
	 *
	 * @since   6.1.9
	 */
	public function __construct(
		Fieldtype $fieldtype,
		FieldXml $fieldxml,
		TableInterface $tables
	)
	{
		$this->fieldtype = $fieldtype;
		$this->fieldxml = $fieldxml;
		$this->tables = $tables;
	}

	/**
	 * Compose the record one resolved column would write, identity aside.
	 *
	 * @param   string                $column      The source column name.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  array{fieldtype: array|null, link: array, columns: array|null, notes: array<string, mixed>}  The composition.
	 * @since   6.1.9
	 */
	public function compose(string $column, array $properties, bool $fresh = true, array $standing = []): array
	{
		$notes = [];
		$type = (string) $this->value($properties, 'xml_type', 'text');
		$link = $this->fieldxml->link($properties, $type);

		// A field that stores a key from another table has to be a custom field type,
		// because that is the only JCB field type whose generated code queries the
		// linked view. Leaving it as the plain type the column looked like would keep
		// the attributes and throw away the relationship they describe.
		$fieldtype = $link === []
			? $this->fieldtype->resolve($type)
			: $this->fieldtype->fallback($type);

		if ($link === [])
		{
			// Two field types can answer to one XML type because one is a narrower kind
			// of the other, and the field's own validation says which was meant.
			$narrower = $this->fieldtype->discriminate($type, $this->attributes($properties));
			$fieldtype = $narrower ?? $fieldtype;
		}

		if ($fieldtype === null)
		{
			$notes['failed.field.unresolved_type.' . $this->key($column)] = $type;

			return ['fieldtype' => null, 'link' => $link, 'columns' => null, 'notes' => $notes];
		}

		$identity = trim((string) ($fieldtype['guid'] ?? ''));

		if ($identity === '')
		{
			// field.fieldtype is a VARCHAR(36) holding the field type's own guid, which is
			// the only identity that survives being moved between installs. A numeric id
			// written there compiles to nothing, so a catalogue row with no guid is a
			// failure to resolve rather than something to write around.
			$notes['failed.field.unidentified_type.' . $this->key($column)] =
				$fieldtype['name'] ?? $type;

			return ['fieldtype' => $fieldtype, 'link' => $link, 'columns' => null, 'notes' => $notes];
		}

		$size = (string) $this->value($properties, 'size', '');

		$columns = [
			'fieldtype' => $identity,
			'datatype' => (string) $this->value($properties, 'datatype', 'TEXT'),
			'indexes' => $this->indexes(
				(int) $this->value($properties, 'key', 0),
				$column,
				$notes
			),
			'null_switch' => (string) $this->value($properties, 'null', 'NULL'),
			'store' => $this->storeCode(
				$column,
				(string) $this->value($properties, 'store', ''),
				$notes
			),
			'xml' => $this->fieldxml->build($column, $properties, $fresh, $standing),
			'datalenght' => in_array($size, self::SIZES, true) || $size === ''
				? $size
				: 'Other'
		];
		$columns['datalenght_other'] = $columns['datalenght'] === 'Other' ? $size : '';

		[$columns['datadefault'], $columns['datadefault_other']] =
			$this->defaults($column, $properties, $notes);

		return [
			'fieldtype' => $fieldtype,
			'link' => $link,
			'columns' => $columns,
			'notes' => $notes
		];
	}

	/**
	 * The properties hash of one resolved column.
	 *
	 * Two columns whose hashes align would write byte-identical records, so
	 * they are one field -- and this is the same hash standing() takes of a
	 * record already written, which is what lets a run recognise the field
	 * it wrote before.
	 *
	 * @param   string                $column      The source column name.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  string|null  The hash, or null when no record could be composed.
	 * @since   6.1.9
	 */
	public function hash(string $column, array $properties): ?string
	{
		$columns = $this->compose($column, $properties)['columns'];

		return $columns === null ? null : $this->digest($columns);
	}

	/**
	 * The properties hash of one standing field record.
	 *
	 * The row carries the very columns compose() builds, so the hash is taken
	 * of the same facts in the same order. The stored form element travels
	 * json encoded, exactly as the field table declares its xml column, and
	 * is unfolded before hashing so both sides hash the element itself.
	 *
	 * @param   array<string, mixed>  $row  The standing field row.
	 *
	 * @return  string|null  The hash, or null when the row cannot speak.
	 * @since   6.1.9
	 */
	public function standing(array $row): ?string
	{
		$identity = trim((string) ($row['fieldtype'] ?? ''));
		$stored = (string) ($row['xml'] ?? '');

		if ($identity === '' || trim($stored) === '')
		{
			return null;
		}

		$xml = json_decode($stored, true);

		return $this->digest([
			'fieldtype' => $identity,
			'datatype' => (string) ($row['datatype'] ?? ''),
			'datalenght' => (string) ($row['datalenght'] ?? ''),
			'datalenght_other' => (string) ($row['datalenght_other'] ?? ''),
			'datadefault' => (string) ($row['datadefault'] ?? ''),
			'datadefault_other' => (string) ($row['datadefault_other'] ?? ''),
			'indexes' => (int) ($row['indexes'] ?? 0),
			'null_switch' => (string) ($row['null_switch'] ?? ''),
			'store' => (int) ($row['store'] ?? 0),
			'xml' => is_string($xml) ? $xml : $stored
		]);
	}

	/**
	 * The index a field carries, on the scale JCB's own form offers.
	 *
	 * The schema and the field record rank keys differently, and the two used
	 * to be passed straight between each other: a source column's ranks run
	 * none, index, unique, primary, while the field form offers unique as 1 and
	 * a plain index as 2. Read one as the other and a unique key survives only
	 * by coincidence, a primary key becomes a plain index, and every plain
	 * index the component asked for is lost entirely.
	 *
	 * The primary key is not among them, because it is not a field: JCB writes
	 * the id column and its primary key itself.
	 *
	 * @param   int                   $rank    The source column's key rank.
	 * @param   string                $column  The source column name.
	 * @param   array<string, mixed>  $notes   Collected report notes.
	 *
	 * @return  int  The value the field record stores.
	 * @since   6.1.9
	 */
	public function indexes(int $rank, string $column, array &$notes): int
	{
		$index = match ($rank)
		{
			2 => 1,
			1 => 2,
			default => 0
		};

		if ($index === 0)
		{
			return 0;
		}

		// JCB names a field's index after its column and its own five after
		// the columns it manages, and MySQL refuses a table carrying one name
		// twice. A source column named "state" therefore asks for the very
		// name JCB gives the published column, and the whole install fails
		// with nothing built -- so the column and its field stand, and only
		// the index it asked for is given up, which a person can restore.
		if (isset(self::CLAIMED['idx_' . strtolower(trim($column))]))
		{
			$notes['skipped.index.claimed.' . $this->key($column)] =
				'JCB names its own index for the ' . self::CLAIMED['idx_' . strtolower(trim($column))]
				. ' column idx_' . strtolower(trim($column))
				. ', and one table cannot carry that name twice';

			return 0;
		}

		return $index;
	}

	/**
	 * The JCB store code for a declared storage encoding.
	 *
	 * @param   string                $column  The source column name.
	 * @param   string                $store   The declared encoding.
	 * @param   array<string, mixed>  $notes   Collected report notes.
	 *
	 * @return  int  The JCB store code.
	 * @since   6.1.9
	 */
	public function storeCode(string $column, string $store, array &$notes): int
	{
		$store = strtolower(trim($store));

		if ($store === '')
		{
			return 0;
		}

		if (!isset(self::STORES[$store]))
		{
			// a codec nobody recognises must not quietly become "no codec",
			// which would strip the encryption the source asked for
			$notes['failed.field.unknown_store.' . $this->key($column)] = $store;

			return 0;
		}

		return self::STORES[$store];
	}

	/**
	 * The stored default of one column, as the pair JCB's field record splits it into.
	 *
	 * @param   string                $column      The source column name.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 * @param   array<string, mixed>  $notes       Collected report notes.
	 *
	 * @return  array{0: string, 1: string}  The datadefault and datadefault_other pair.
	 * @since   6.1.9
	 */
	protected function defaults(string $column, array $properties, array &$notes): array
	{
		// the column's default is what the schema states for the column; the
		// form's default attribute is a different thing entirely, and reading
		// one as the other writes the form's placeholder into the table
		$columnDefault = (string) $this->value($properties, 'db_default', '');
		$stated = $this->value($properties, 'db_default_stated', null);

		if ($stated === false)
		{
			// a column carrying no DEFAULT clause is not a column defaulting to
			// nothing, and JCB spells that difference EMPTY: without it the
			// compiler gives every such column a default the source never had
			return ['Other', 'EMPTY'];
		}

		if ($columnDefault === 'EMPTY')
		{
			// EMPTY is the word JCB reserves for "this column carries no
			// DEFAULT clause", so a column whose default is literally that
			// word cannot be stored as itself. Dropping the clause would leave
			// a NOT NULL column with no default at all, so the nearest thing
			// is kept and the loss is named rather than passed over
			$notes['skipped.default.reserved_word.' . $this->key($column)] =
				'the column defaults to the word EMPTY, which JCB reserves for '
				. 'a column carrying no default at all';

			return ['', ''];
		}

		$default = in_array($columnDefault, self::DEFAULTS, true) || $columnDefault === ''
			? $columnDefault
			: 'Other';
		$other = $default === 'Other' ? $columnDefault : '';

		// a column default can only be as long as the Table class says the
		// datadefault_other column holds; a longer harvested default is a
		// form default, it lives on in the field's xml, and carrying it
		// here would be refused by any live database
		if (strlen($other) > $this->capacity('datadefault_other'))
		{
			$notes['skipped.default.too_long.' . $this->key($column)] = strlen($columnDefault);

			return ['', ''];
		}

		return [$default, $other];
	}

	/**
	 * The attributes a resolved field states, flattened for comparison.
	 *
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  array<string, mixed>  Attribute name keyed to its value.
	 * @since   6.1.9
	 */
	protected function attributes(array $properties): array
	{
		$attributes = (array) ($this->value($properties, 'attributes', []) ?? []);

		foreach (['validate', 'filter'] as $name)
		{
			$value = $this->value($properties, $name);

			if ($value !== null)
			{
				$attributes[$name] = $value;
			}
		}

		return $attributes;
	}

	/**
	 * One canonical hash over the record columns.
	 *
	 * @param   array<string, mixed>  $columns  The record columns.
	 *
	 * @return  string  The hash.
	 * @since   6.1.9
	 */
	protected function digest(array $columns): string
	{
		$parts = [];

		foreach (self::CANON as $name)
		{
			$value = $columns[$name] ?? '';
			$value = $name === 'fieldtype'
				? strtolower(trim((string) $value))
				: trim((string) $value);
			$parts[] = $name . '=' . $value;
		}

		return md5(implode("\n", $parts));
	}

	/**
	 * How many characters one column of the field table can hold.
	 *
	 * The Table class states the column's db type; a CHAR or VARCHAR names
	 * its capacity, and the text types hold more than any value this
	 * composition carries.
	 *
	 * @param   string  $column  The column name.
	 *
	 * @return  int  The capacity in characters.
	 * @since   6.1.9
	 */
	protected function capacity(string $column): int
	{
		$type = (string) ($this->tables->get('field', $column, 'db')['type'] ?? '');

		if (preg_match('/^(?:VAR)?CHAR\((\d+)\)/i', $type, $size))
		{
			return (int) $size[1];
		}

		return PHP_INT_MAX;
	}

	/**
	 * The value of one resolved field property.
	 *
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 * @param   string                $property    The property name.
	 * @param   mixed                 $default     A value to use when unresolved.
	 *
	 * @return  mixed  The resolved value, or the default.
	 * @since   6.1.9
	 */
	protected function value(array $properties, string $property, $default = null)
	{
		$entry = $properties[$property] ?? null;

		if (!is_array($entry) && !is_object($entry))
		{
			return $default;
		}

		$entry = (array) $entry;
		$value = $entry['value'] ?? null;

		return $value === null || $value === '' ? $default : $value;
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
}

