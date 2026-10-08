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

namespace VDM\Joomla\Componentbuilder\Extrusion\Writer;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Pairing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Record;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Placeholder;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Writes one JCB field definition per resolved column.
 * 
 * The record itself -- the field type, the database shape and the stored form
 * element -- is composed by the record resolver, so what is written here is
 * byte for byte what the identity rules hashed and compared. The stored values
 * are raw: the storage encoding each column declares is applied by the Data
 * pipeline, so applying it here would encode twice. The identity is the GUID
 * the source supplied where it had one, which is what lets a component that
 * came out of JCB line back up with its own definitions.
 * 
 * @since 6.1.6
 */
final class Field extends Writer
{
	/**
	 * Whether the caller chose the identity of the field being written.
	 *
	 * @var    bool
	 * @since  6.1.8
	 */
	protected bool $chosen = false;

	/**
	 * The Record Resolver.
	 *
	 * @var    Record
	 * @since  6.1.9
	 */
	protected Record $record;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.6
	 */
	protected Guid $guid;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Pairing Resolver.
	 *
	 * @var    Pairing
	 * @since  6.1.7
	 */
	protected Pairing $pairing;

	/**
	 * The Placeholder Resolver.
	 *
	 * @var    Placeholder
	 * @since  6.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config       The extrusion configuration.
	 * @param   Resolved       $resolved     The resolved definition registry.
	 * @param   ItemInterface  $item         The JCB data item writer.
	 * @param   Report         $report       The run report registry.
	 * @param   Delta          $delta        The change weigher.
	 * @param   Record         $record       The record resolver.
	 * @param   Guid           $guid         The identity resolver.
	 * @param   Source         $source       The source identity registry.
	 * @param   Pairing        $pairing      The pairing resolver.
	 * @param   Placeholder    $placeholder  The placeholder expresser.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta,
		Record $record,
		Guid $guid,
		Source $source,
		Pairing $pairing,
		Placeholder $placeholder
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->record = $record;
		$this->guid = $guid;
		$this->source = $source;
		$this->pairing = $pairing;
		$this->placeholder = $placeholder;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.6
	 */
	protected function table(): string
	{
		return 'field';
	}

	/**
	 * Write every resolved field.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.6
	 */
	public function write(): int
	{
		$written = 0;

		foreach ($this->views() as $view)
		{
			$fields = $this->resolved->get($this->path($view) . '.field');

			foreach ((array) $fields as $key => $properties)
			{
				$properties = (array) $properties;
				$column = (string) $this->value($properties, 'name', (string) $key);

				if ($column === '')
				{
					continue;
				}

				if ($this->one($view, $column, $properties))
				{
					$written++;
				}
			}
		}

		$this->report->set('counts.field', $written);

		return $written;
	}

	/**
	 * Write one resolved field.
	 *
	 * @param   string                $view        The view name.
	 * @param   string                $column      The source column name.
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 *
	 * @return  bool  True when the definition was written.
	 * @since   6.1.6
	 */
	protected function one(string $view, string $column, array $properties): bool
	{
		$guid = $this->guid->prefer(
			$this->value($properties, 'guid'),
			[$this->option(), 'field', $view, $column]
		);

		// the caller's pairing verdict outranks the derived identity
		$derived = $guid;
		$guid = $this->pairing->guid(
			'field',
			$this->key($view) . '.' . $this->key($column),
			$guid
		);

		if ($guid === null)
		{
			return false;
		}

		// a person who named the field this column belongs to has spoken, and
		// nothing here may quietly relate the column to another field instead
		$this->chosen = $guid !== $derived;

		// a field that already stands is updated with what the source states
		// laid over the XML the person keeps, and nothing more; only a fresh
		// field is filled out in full
		$standing = $this->standing($guid);
		$record = $this->record->compose($column, $properties, $standing === null, $standing ?? []);
		$fieldtype = $record['fieldtype'];
		$link = $record['link'];

		if ($fieldtype === null)
		{
			$this->notes($record['notes']);

			return false;
		}

		if ($link !== [])
		{
			$this->report->set(
				'relations.written.' . $this->key($view) . '.' . $this->key($column),
				$link['type'] . ' selecting ' . $link['value_field'] . ' from ' . $link['table']
			);
		}

		if ($record['columns'] === null)
		{
			$this->notes($record['notes']);

			return false;
		}

		$this->notes($record['notes']);

		// two views stating the same field are stating one field: the sharing
		// resolver settled that before anything was written, and a column
		// carrying its note links the field another view owns. A person's
		// verdict on this very column outranks the note, which is how one
		// view is pointed elsewhere without touching the rest
		$share = $this->resolved->get(
			$this->path($view) . '.field.' . $this->key($column) . '.share'
		);

		if (!$this->chosen && is_array($share)
			&& trim((string) ($share['guid'] ?? '')) !== '')
		{
			$this->relate(
				$view,
				$column,
				trim((string) $share['guid']),
				$fieldtype['name']
			);
			$this->report->set(
				'linked.field.' . $this->key($view) . '.' . $this->key($column),
				trim((string) $share['guid'])
			);

			return true;
		}

		$definition = new \stdClass();
		$definition->guid = $guid;

		if ($standing === null)
		{
			$definition->name = $this->readable(
				(string) $this->value($properties, 'label', $column),
				$column
			);

			foreach ($record['columns'] as $property => $value)
			{
				$definition->{$property} = $property === 'xml'
					? $this->placeholder->reverse((string) $value)
					: $value;
			}

			$definition->published = 1;
		}
		else
		{
			// a field that stands is a person's: its type, its name, its
			// storage and its database shape stay exactly as they curated
			// them, and only its XML takes what the source adds to it
			$definition->xml = $this->placeholder->reverse(
				(string) $record['columns']['xml']
			);
		}

		if (!$this->store($definition, ['published'], null, $this->row('field', $view, $column)))
		{
			return false;
		}

		$this->relate($view, $column, $guid, $fieldtype['name']);

		return true;
	}

	/**
	 * The XML attributes a field record already standing under this identity holds.
	 *
	 * @param   string  $guid  The field identity.
	 *
	 * @return  array<string, string>|null  The standing attributes, empty when unreadable, or null when no record stands.
	 * @since   6.1.9
	 */
	protected function standing(string $guid): ?array
	{
		$id = $this->item->table($this->table())->value($guid, 'guid', 'id');

		if ($id === null || (int) $id <= 0)
		{
			return null;
		}

		$row = $this->item->table($this->table())->get($guid);
		$xml = $row->xml ?? '';
		$decoded = is_string($xml) ? json_decode($xml, true) : null;
		$xml = is_string($decoded) ? $decoded : (string) $xml;
		$attributes = [];

		if (preg_match_all('/\s([A-Za-z_][\w\-.:]*)="([^"]*)"/', $xml, $matches, PREG_SET_ORDER) > 0)
		{
			foreach ($matches as $match)
			{
				$attributes[$match[1]] = html_entity_decode($match[2], ENT_QUOTES | ENT_XML1, 'UTF-8');
			}
		}

		return $attributes;
	}

	/**
	 * Record what the record composition had to give up.
	 *
	 * @param   array<string, mixed>  $notes  Report entries by key.
	 *
	 * @return  void
	 * @since   6.1.9
	 */
	protected function notes(array $notes): void
	{
		foreach ($notes as $key => $value)
		{
			$this->report->set($key, $value);
		}
	}

	/**
	 * Record which field one view's column relates to.
	 *
	 * @param   string  $view       The view name.
	 * @param   string  $column     The column name.
	 * @param   string  $guid       The field's identity.
	 * @param   string  $fieldtype  The field type's name.
	 *
	 * @return  void
	 * @since   6.1.8
	 */
	protected function relate(string $view, string $column, string $guid, string $fieldtype): void
	{
		$this->resolved->set(
			$this->path($view) . '.written.' . $this->key($column) . '.guid',
			$guid
		);
		$this->resolved->set(
			$this->path($view) . '.written.' . $this->key($column) . '.fieldtype',
			$fieldtype
		);
	}

	/**
	 * The name a field is listed under.
	 *
	 * A label may carry markup -- a note under the label, a link to a
	 * reference -- because a label is rendered as HTML. A field's name is
	 * read in lists, pickers and the field's own record, so it takes the
	 * words of the label without the markup, while the label itself is
	 * carried through to the field's xml exactly as the source states it.
	 *
	 * @param   string  $label   The field's stated label.
	 * @param   string  $column  The column the field stands for.
	 *
	 * @return  string  The readable name.
	 * @since   6.1.8
	 */
	protected function readable(string $label, string $column): string
	{
		if (!str_contains($label, '<'))
		{
			return trim($label);
		}

		$text = strip_tags(str_replace(['<br>', '<br/>', '<br />'], ' ', $label));
		$text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);

		return $text === '' ? $column : $text;
	}

	/**
	 * The component option, when it is known.
	 *
	 * @return  string  The com_ prefixed option, or an empty string.
	 * @since   6.1.6
	 */
	protected function option(): string
	{
		return (string) $this->source->get('code_name', '');
	}
}

