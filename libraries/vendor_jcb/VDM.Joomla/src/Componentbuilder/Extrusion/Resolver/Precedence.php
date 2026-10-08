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


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Form;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Schema;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Table;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\PrecedenceInterface;


/**
 * Decides which source wins for each property of one field.
 * 
 * This is the only place in the pipeline that arbitrates precedence. Each tier
 * contributes whatever it happens to know, and the configured tier order picks
 * the winner. Every resolved property keeps the tier that produced it, which is
 * what lets a run distinguish a fact from a guess.
 * 
 * Some properties exist at exactly one tier and are therefore uncontested: a
 * relationship, a storage encoding and a per-field GUID come from the table
 * definition class or not at all, while a showon condition comes from the form
 * XML or not at all.
 * 
 * @since 6.1.6
 */
final class Precedence implements PrecedenceInterface
{
	/**
	 * The attribute names that carry human readable display text.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const TEXT = ['label', 'description', 'hint', 'message'];

	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Table Registry.
	 *
	 * @var    Table
	 * @since  6.1.6
	 */
	protected Table $table;

	/**
	 * The Schema Registry.
	 *
	 * @var    Schema
	 * @since  6.1.6
	 */
	protected Schema $schema;

	/**
	 * The Form Registry.
	 *
	 * @var    Form
	 * @since  6.1.6
	 */
	protected Form $form;

	/**
	 * The Language Resolver.
	 *
	 * @var    Language
	 * @since  6.1.6
	 */
	protected Language $language;

	/**
	 * The Text Resolver.
	 *
	 * @var    Text
	 * @since  6.1.6
	 */
	protected Text $text;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Config    $config    The extrusion configuration.
	 * @param   Table     $table     The table definition registry.
	 * @param   Schema    $schema    The parsed schema registry.
	 * @param   Form      $form      The parsed form registry.
	 * @param   Language  $language  The language resolver.
	 * @param   Text      $text      The readable text resolver.
	 * @param   Report    $report    The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Table $table,
		Schema $schema,
		Form $form,
		Language $language,
		Text $text,
		Report $report
	)
	{
		$this->config = $config;
		$this->table = $table;
		$this->schema = $schema;
		$this->form = $form;
		$this->language = $language;
		$this->text = $text;
		$this->report = $report;
	}

	/**
	 * Resolve every property of one column into a value and an origin.
	 *
	 * @param   string                $view    The JCB view name.
	 * @param   array<string,string>  $keys    Registry keys per tier, as schema and table.
	 * @param   string                $column  The source column name.
	 *
	 * @return  array<string, array{value: mixed, origin: string}>|null  Resolved properties.
	 * @since   6.1.6
	 */
	public function resolve(string $view, array $keys, string $column): ?array
	{
		$candidates = [];
		$schemaKey = (string) ($keys['schema'] ?? '');
		$tableKey = (string) ($keys['table'] ?? '');

		if ($schemaKey !== '')
		{
			$this->fromDerived($candidates, $schemaKey, $column);
			$this->fromNotes($candidates, $schemaKey, $column);
		}

		$this->fromXml($candidates, $view, $column);

		if ($tableKey !== '')
		{
			$this->fromTable($candidates, $tableKey, $column);
		}

		if ($candidates === [])
		{
			return null;
		}

		$resolved = [];

		foreach ($candidates as $property => $tiers)
		{
			$winner = $this->winner($tiers);

			if ($winner === null)
			{
				continue;
			}

			$resolved[$property] = $winner;
		}

		if ($resolved === [])
		{
			return null;
		}

		$resolved['name'] = ['value' => $column, 'origin' => 'derived'];

		return $resolved;
	}

	/**
	 * Choose the highest ranked tier that offered a usable value.
	 *
	 * A run may configure fewer tiers than exist, and every tier it left out
	 * shares one rank below the configured ones. Settling that on the default
	 * tier strength keeps a partial option from quietly inverting the tiers it
	 * never mentioned, which would otherwise be decided by nothing more than the
	 * order the tiers happened to be asked in.
	 *
	 * @param   array<string, mixed>  $tiers  Tier name keyed to its offered value.
	 *
	 * @return  array{value: mixed, origin: string}|null  The winning value and its origin.
	 * @since   6.1.6
	 */
	protected function winner(array $tiers): ?array
	{
		$best = null;
		$bestRank = PHP_INT_MAX;
		$bestStrength = PHP_INT_MAX;

		foreach ($tiers as $tier => $value)
		{
			if ($value === null || $value === '')
			{
				continue;
			}

			$tier = (string) $tier;
			$rank = $this->config->rank($tier);
			$strength = $this->strength($tier);

			if ($rank > $bestRank || ($rank === $bestRank && $strength >= $bestStrength))
			{
				continue;
			}

			$bestRank = $rank;
			$bestStrength = $strength;
			$best = ['value' => $value, 'origin' => $tier];
		}

		return $best;
	}

	/**
	 * The default strength of one tier, used only to settle an equal rank.
	 *
	 * @param   string  $tier  The tier name.
	 *
	 * @return  int  The tier's default position, or one past every known tier.
	 * @since   6.1.6
	 */
	protected function strength(string $tier): int
	{
		$position = array_search($tier, Config::TIERS, true);

		return $position === false ? count(Config::TIERS) : (int) $position;
	}

	/**
	 * Offer one tier's value for one property.
	 *
	 * @param   array<string, array<string, mixed>>  $candidates  The candidate map.
	 * @param   string                               $property    The property name.
	 * @param   string                               $tier        The offering tier.
	 * @param   mixed                                $value       The offered value.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function offer(array &$candidates, string $property, string $tier, $value): void
	{
		if ($value === null || $value === '')
		{
			return;
		}

		$candidates[$property][$tier] = $value;
	}

	/**
	 * The lowest tier: what the SQL column and its name alone imply.
	 *
	 * @param   array<string, array<string, mixed>>  $candidates  The candidate map.
	 * @param   string                               $key         The registry key of the table.
	 * @param   string                               $column      The source column name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function fromDerived(array &$candidates, string $key, string $column): void
	{
		$path = 'table.' . $key . '.column.' . $this->key($column);
		$row = $this->schema->get($path);

		if ($row === null)
		{
			return;
		}

		$row = (array) $row;

		$this->offer($candidates, 'label', 'derived', $this->text->humanise($column));
		$this->offer($candidates, 'datatype', 'derived', $row['type'] ?? null);
		$this->offer($candidates, 'size', 'derived', $row['size'] ?? null);
		$this->offer($candidates, 'default', 'derived', $row['default'] ?? null);
		// the column's own default is a separate thing from the form's, and
		// only the schema and the table class ever state it
		$this->offer($candidates, 'db_default', 'derived', $row['default'] ?? null);
		$this->offer($candidates, 'db_default_stated', 'derived', $row['default_stated'] ?? null);
		$this->offer($candidates, 'null', 'derived', $row['null'] ?? null);
		$this->offer($candidates, 'key', 'derived', $row['key'] ?? null);
		$this->offer($candidates, 'ordinal', 'derived', $row['ordinal'] ?? null);
	}

	/**
	 * The notes tier: the JSON configuration in a SQL column comment.
	 *
	 * @param   array<string, array<string, mixed>>  $candidates  The candidate map.
	 * @param   string                               $key         The registry key of the table.
	 * @param   string                               $column      The source column name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function fromNotes(array &$candidates, string $key, string $column): void
	{
		$path = 'table.' . $key . '.column.' . $this->key($column) . '.comment';
		$comment = $this->schema->get($path);

		if (!is_string($comment) || trim($comment) === '')
		{
			return;
		}

		$notes = json_decode($comment, true);

		if (!is_array($notes))
		{
			return;
		}

		foreach ($notes as $property => $value)
		{
			if (!is_string($property) || is_array($value))
			{
				continue;
			}

			$property = $property === 'type' ? 'xml_type' : $property;

			$this->offer($candidates, $property, 'notes', $value);
		}
	}

	/**
	 * The XML tier: the component's own form field definition.
	 *
	 * @param   array<string, array<string, mixed>>  $candidates  The candidate map.
	 * @param   string                               $view        The JCB view name.
	 * @param   string                               $column      The source column name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function fromXml(array &$candidates, string $view, string $column): void
	{
		$field = $this->formField($view, $column);

		if ($field === null)
		{
			return;
		}

		$field = (array) $field;
		$attributes = (array) ($field['attribute'] ?? []);
		// any attribute may carry a language constant, and what is stored
		// must be the language itself -- the constant only names it
		$attributes = $this->language->bag($attributes, array_keys($attributes));

		$this->offer($candidates, 'xml_type', 'xml', $field['type'] ?? null);
		$this->offer($candidates, 'fieldset', 'xml', $field['fieldset'] ?? null);
		$this->offer($candidates, 'subform', 'xml', $field['subform'] ?? null);

		foreach (self::TEXT as $key)
		{
			$this->offer($candidates, $key, 'xml', $attributes[$key] ?? null);
		}

		foreach (['default', 'class', 'required', 'filter', 'validate', 'showon', 'multiple', 'readonly', 'disabled'] as $key)
		{
			$this->offer($candidates, $key, 'xml', $attributes[$key] ?? null);
		}

		if ($attributes !== [])
		{
			$candidates['attributes']['xml'] = $attributes;
		}

		if (isset($field['option']))
		{
			$options = (array) $field['option'];

			foreach ($options as &$option)
			{
				if (is_array($option) && isset($option['text'])
					&& $this->language->isConstant($option['text']))
				{
					$resolved = $this->language->resolve(
						$option['text'],
						(string) $option['text']
					);

					// an option whose text nothing answered for keeps its
					// value as its face rather than carrying the constant
					$option['text'] = $this->language->isConstant($resolved)
						? ''
						: $resolved;
				}
			}

			unset($option);

			$candidates['options']['xml'] = $options;
		}
	}

	/**
	 * Find one column's form field, tolerating a view name that is not exact.
	 *
	 * A form file is named after its view, but a component whose table prefix
	 * differs from its own code name produces a view name that will not match
	 * that file name. Trying the obvious alternates keeps the whole XML tier from
	 * being lost to a naming mismatch, and any field actually found still has to
	 * carry the right column name.
	 *
	 * @param   string  $view    The JCB view name.
	 * @param   string  $column  The source column name.
	 *
	 * @return  mixed  The form field entry, or null when no form declares it.
	 * @since   6.1.6
	 */
	protected function formField(string $view, string $column)
	{
		foreach ($this->viewAliases($view) as $alias)
		{
			$field = $this->form->get(
				'view.' . $alias . '.field.' . $this->key($column)
			);

			if ($field === null)
			{
				continue;
			}

			if (trim((string) (((array) $field)['subform'] ?? '')) === '')
			{
				return $field;
			}

			// a subform's inner field that happens to share the column's name
			// is the subform's own, and read before the view's field it holds
			// the bare key: the column's field is the one no subform holds
			$own = $this->ownField($alias, $column);

			if ($own !== null)
			{
				return $own;
			}
		}

		return null;
	}

	/**
	 * The form field of one view that names a column and belongs to no subform.
	 *
	 * @param   string  $alias   The view alias the form was read under.
	 * @param   string  $column  The column name.
	 *
	 * @return  mixed  The field entry, or null when the form states none.
	 * @since   6.1.9
	 */
	protected function ownField(string $alias, string $column)
	{
		$fields = $this->form->get('view.' . $alias . '.field');

		if (!is_array($fields) && !is_object($fields))
		{
			return null;
		}

		foreach ((array) $fields as $entry)
		{
			$entry = (array) $entry;

			if ((string) ($entry['name'] ?? '') === $column
				&& trim((string) ($entry['subform'] ?? '')) === '')
			{
				return $entry;
			}
		}

		return null;
	}

	/**
	 * The view names a form file for this view could plausibly use.
	 *
	 * @param   string  $view  The JCB view name.
	 *
	 * @return  array<string>  Candidate registry segments, most likely first.
	 * @since   6.1.6
	 */
	protected function viewAliases(string $view): array
	{
		$aliases = [$this->key($view)];
		$trimmed = $view;

		while (($position = strpos($trimmed, '_')) !== false)
		{
			$trimmed = substr($trimmed, $position + 1);

			if ($trimmed !== '')
			{
				$aliases[] = $this->key($trimmed);
			}
		}

		return array_values(array_unique($aliases));
	}

	/**
	 * The top tier: the JCB table definition class, when the source has one.
	 *
	 * @param   array<string, array<string, mixed>>  $candidates  The candidate map.
	 * @param   string                               $key         The registry key of the table.
	 * @param   string                               $column      The source column name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function fromTable(array &$candidates, string $key, string $column): void
	{
		$path = 'table.' . $key . '.field.' . $this->key($column);
		$field = $this->table->get($path);

		if ($field === null)
		{
			return;
		}

		$field = (array) $field;

		$this->offer($candidates, 'label', 'table', $this->language->resolve($field['label'] ?? null));
		$this->offer($candidates, 'xml_type', 'table', $field['type'] ?? null);
		$this->offer($candidates, 'store', 'table', $field['store'] ?? null);
		$this->offer($candidates, 'tab', 'table', $field['tab_name'] ?? null);
		$this->offer($candidates, 'guid', 'table', $field['guid'] ?? null);
		$this->offer($candidates, 'title', 'table', ($field['title'] ?? false) ? 1 : null);
		$this->offer($candidates, 'list', 'table', $field['list'] ?? null);

		$db = (array) ($field['db'] ?? []);

		if ($db !== [])
		{
			$this->offer($candidates, 'raw_type', 'table', $db['type'] ?? null);
			$this->offer($candidates, 'datatype', 'table', $this->datatype($db['type'] ?? ''));
			$this->offer($candidates, 'size', 'table', $this->size($db['type'] ?? ''));
			$this->offer($candidates, 'null', 'table', $db['null_switch'] ?? null);
			$this->offer($candidates, 'default', 'table', $this->defaultValue($db['default'] ?? null));
			$this->offer($candidates, 'db_default', 'table', $this->defaultValue($db['default'] ?? null));
			$this->offer($candidates, 'key', 'table', $this->keyStatus($db));
		}

		$link = $field['link'] ?? null;

		if (is_array($link) && $link !== [])
		{
			$candidates['link']['table'] = $link;
		}

		if (isset($field['subfield']))
		{
			$candidates['subfields']['table'] = (array) $field['subfield'];
		}
	}

	/**
	 * The uppercase SQL type keyword of a raw column type.
	 *
	 * @param   string  $raw  The raw column type, such as VARCHAR(255).
	 *
	 * @return  string|null  The keyword, or null when it cannot be read.
	 * @since   6.1.6
	 */
	protected function datatype(string $raw): ?string
	{
		if (preg_match('/^\s*([A-Za-z]+)/', $raw, $matches) === 1)
		{
			return strtoupper($matches[1]);
		}

		return null;
	}

	/**
	 * The declared size of a raw column type.
	 *
	 * @param   string  $raw  The raw column type, such as VARCHAR(255).
	 *
	 * @return  string|null  The size, or null when the type has none.
	 * @since   6.1.6
	 */
	protected function size(string $raw): ?string
	{
		if (preg_match('/\((\d+)(?:\s*,\s*(\d+))?\)/', $raw, $matches) === 1)
		{
			return isset($matches[2]) ? $matches[1] . ',' . $matches[2] : $matches[1];
		}

		return null;
	}

	/**
	 * Normalise a table-map default value.
	 *
	 * The table definition class writes the sentinel EMPTY where a column has no
	 * default, which is not a value JCB should store.
	 *
	 * @param   mixed  $value  The declared default.
	 *
	 * @return  string|null  The default, or null when there is none.
	 * @since   6.1.6
	 */
	protected function defaultValue($value): ?string
	{
		if ($value === null || $value === '' || $value === 'EMPTY')
		{
			return null;
		}

		return (string) $value;
	}

	/**
	 * The key status a table-map db block implies.
	 *
	 * @param   array<string, mixed>  $db  The db block.
	 *
	 * @return  int|null  2 primary, 1 unique, 0 indexed, or null when not a key.
	 * @since   6.1.6
	 */
	protected function keyStatus(array $db): ?int
	{
		if (!empty($db['primary_key']))
		{
			return 3;
		}

		if (!empty($db['unique_key']))
		{
			return 2;
		}

		return null;
	}

	/**
	 * The canonical identity of a source table, ignoring its prefix.
	 *
	 * A schema declares its tables with the Joomla prefix placeholder while a
	 * table definition class names them bare, so the two only join once both are
	 * reduced to the same identity. Without this the same table produces two
	 * unrelated views and each sees only half the available truth.
	 *
	 * @param   string  $table  The raw table name.
	 *
	 * @return  string  The canonical identity.
	 * @since   6.1.6
	 */
	public function canonical(string $table): string
	{
		$name = strtolower(trim($table));
		$name = preg_replace('/^#__/', '', $name) ?? $name;

		return trim($this->key($name), '_');
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.6
	 */
	public function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}
}

