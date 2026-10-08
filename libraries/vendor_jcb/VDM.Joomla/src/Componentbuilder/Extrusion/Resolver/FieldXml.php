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


/**
 * Composes the form XML attribute string JCB stores on a field.
 * 
 * JCB keeps a field's form definition as a single self-closing field element, so
 * this builds that element from the resolved attribute bag. The field type's own
 * declared property names decide what is allowed through, which is how an
 * attribute JCB would not understand is dropped rather than written blindly.
 * 
 * @since 6.1.6
 */
final class FieldXml
{
	/**
	 * Attributes that are never carried across.
	 *
	 * The type is implied by the field type itself, and showon becomes a JCB
	 * condition rather than a stored attribute.
	 *
	 * A linked field is the one exception to dropping the type, handled in
	 * link(): a generated custom field type is named by that attribute, so
	 * dropping it there would leave the field with no type to generate.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const DROP = ['type'];

	/**
	 * The attributes a linked field carries, in the order JCB writes them.
	 *
	 * These are read straight back out of the stored element at compile time --
	 * Compiler\Field\Attributes lifts table, value_field and key_field from the
	 * string itself -- so they are the whole mechanism by which a relationship
	 * survives into a generated component.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const LINK = [
		'extends', 'table', 'component', 'entity', 'view', 'views',
		'value_field', 'key_field'
	];

	/**
	 * The attribute order JCB's own generated fields use.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const ORDER = [
		'name', 'label', 'size', 'maxlength', 'default', 'description',
		'class', 'required', 'readonly', 'disabled', 'multiple', 'filter',
		'validate', 'message', 'hint'
	];

	/**
	 * The Fieldtype Resolver.
	 *
	 * @var    Fieldtype
	 * @since  6.1.6
	 */
	protected Fieldtype $fieldtype;

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
	 * @param   Fieldtype  $fieldtype  The field type resolver.
	 * @param   Report     $report     The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Fieldtype $fieldtype, Report $report)
	{
		$this->fieldtype = $fieldtype;
		$this->report = $report;
	}

	/**
	 * Build the stored field element for one resolved field.
	 *
	 * @param   string                                            $column      The source column name.
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  string  The field element source.
	 * @since   6.1.6
	 */
	public function build(string $column, array $properties, bool $fresh = true, array $standing = []): string
	{
		$attributes = $this->attributes($column, $properties, $fresh, $standing);
		$xml = '<field';

		foreach ($attributes as $name => $value)
		{
			$xml .= PHP_EOL . "\t" . $name . '="' . $this->escape((string) $value) . '"';
		}

		return $xml . PHP_EOL . '/>';
	}

	/**
	 * The stated identity of one resolved field, as one canonical string.
	 *
	 * Two columns are the same field exactly when everything their sources
	 * stated matches: the code name, the label, the type, and every stated
	 * property -- required true and required false are two different fields.
	 * This is that statement, canonicalised: the stated attribute bag and the
	 * option list, sorted, with nothing the composer would later pad in. The
	 * padding never belongs here, because two identical statements must match
	 * whatever examples a field type happens to declare.
	 *
	 * @param   string                                              $column      The source column name.
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  string  The canonical stated identity.
	 * @since   6.1.9
	 */
	public function essence(string $column, array $properties): string
	{
		$stated = $this->bag($column, $properties);
		$option = $this->optionAttribute($properties);

		if ($option !== '')
		{
			$stated['option'] = $option;
		}

		$stated['type'] = strtolower(trim(
			(string) ($properties['xml_type']['value'] ?? '')
		));

		ksort($stated);

		$parts = [];

		foreach ($stated as $name => $value)
		{
			$parts[] = $name . '="' . $value . '"';
		}

		return implode(' ', $parts);
	}

	/**
	 * The ordered, filtered attribute set for one resolved field.
	 *
	 * @param   string                                            $column      The source column name.
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  array<string, string>  The attributes to write.
	 * @since   6.1.6
	 */
	public function attributes(string $column, array $properties, bool $fresh = true, array $standing = []): array
	{
		$bag = $this->bag($column, $properties);
		$type = (string) ($properties['xml_type']['value'] ?? '');
		$link = $this->link($properties, $type);
		// a type JCB does not know is the source's own generated field type,
		// stored as a Custom field whose XML names that type itself
		$own = $link === [] && trim($type) !== ''
			&& $this->fieldtype->resolve($type, false) === null;
		// the Custom entry's declared properties describe a list-backed field
		// JCB generates, and its examples name a table that does not exist;
		// a type the source made itself is nothing of the kind, so nothing
		// is filled in for it -- what the source states is all there is
		$declared = $own ? [] : $this->fieldtype->declared($link === [] ? $type : 'custom');

		$option = $this->optionAttribute($properties);

		if ($option !== '')
		{
			$bag['option'] = $option;
		}

		// on an update the XML the person keeps is the base, and the source
		// only fills what it lacks. A compiled form is derived from that very
		// record -- placeholders resolved, constants looked up -- so where the
		// two differ the record is the truth and the form the echo; and a
		// compiled form never shows every property a record holds -- a
		// subform's own field list, a custom field's PHP -- so a re-run must
		// never take those away or write an echo over them
		$settings = $this->settings($column, $bag);
		$attributes = $standing;
		$kept = $standing !== [];

		// the JCB alignment: every property the field type declares is
		// written in the type's own order, the source's stated value first,
		// the link's own value second. A gap the source leaves is filled the
		// way JCB's own field composition fills it -- a derived setting, then
		// the type's example -- on a fresh field for every property, and on a
		// standing field for the properties the type marks mandatory alone:
		// what the person left out of a field they curated stays out
		foreach ($declared as $property)
		{
			$name = (string) $property['name'];

			if (in_array($name, self::DROP, true)
				|| str_contains($name, 'type_php'))
			{
				continue;
			}

			if (isset($bag[$name]))
			{
				if (!$kept || !isset($attributes[$name]))
				{
					$attributes[$name] = $bag[$name];
				}

				continue;
			}

			if (isset($link[$name]) && in_array($name, self::LINK, true))
			{
				// a standing record already describes its own relationship
				if (!$kept)
				{
					$attributes[$name] ??= (string) $link[$name];
				}

				continue;
			}

			if (isset($attributes[$name]) || (!$fresh && empty($property['mandatory'])))
			{
				continue;
			}

			$attributes[$name] = (string) ($settings[$name] ?? $property['example']);
		}

		// every attribute the source states is the source's own statement,
		// whether or not the catalogue entry declares it -- a form's showon,
		// a modal's own keys -- and the stored XML is what the compiler
		// writes back, so nothing stated is dropped
		foreach (self::ORDER as $name)
		{
			if (isset($bag[$name]) && !in_array($name, self::DROP, true)
				&& (!$kept || !isset($attributes[$name])))
			{
				$attributes[$name] = $bag[$name];
			}
		}

		foreach ($bag as $name => $value)
		{
			if (!in_array($name, self::DROP, true)
				&& (!$kept || !isset($attributes[$name])))
			{
				$attributes[$name] = $value;
			}
		}

		if ($link === [])
		{
			// a Custom field carries its own type in its XML, exactly as JCB
			// stores one: the type attribute is how the compiler names it
			return $own && !isset($attributes['type'])
				? ['type' => trim($type)] + $attributes
				: $attributes;
		}

		// A linked field is a generated custom field type, and these attributes are
		// the only place its target is recorded, so they are written whether or not
		// the catalogue entry happens to declare them -- filling what the source
		// and the standing record left unsaid, never overriding what they state
		if (!$kept)
		{
			foreach (array_intersect_key($link, array_flip(self::LINK)) as $name => $value)
			{
				$attributes[$name] ??= (string) $value;
			}
		}

		return ['type' => $attributes['type'] ?? $link['type']] + $attributes;
	}

	/**
	 * The derived settings a harvested field fills its gaps with.
	 *
	 * These are the same formulas the original extrusion built new fields
	 * with: the label speaks for the field wherever the source stated
	 * nothing of its own.
	 *
	 * @param   string                 $column  The source column name.
	 * @param   array<string, string>  $bag     The harvested attribute bag.
	 *
	 * @return  array<string, string>  The derived settings.
	 * @since   6.1.7
	 */
	protected function settings(string $column, array $bag): array
	{
		$label = (string) ($bag['label'] ?? $column);

		return [
			'name' => $column,
			'label' => $label,
			'description' => 'The ' . strtolower($label) . ' is set here.',
			'message' => 'Error! Please add some ' . strtolower($label) . ' here.',
			'hint' => $label . ' Here!'
		];
	}

	/**
	 * The option attribute one field's harvested options fold into.
	 *
	 * JCB stores a field's options as one attribute of value|text entries,
	 * and its compiler explodes that attribute back into option elements --
	 * so the attribute is the stored form, never child elements.
	 *
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  string  The option attribute value, or '' when the field has none.
	 * @since   6.1.7
	 */
	protected function optionAttribute(array $properties): string
	{
		$entries = [];

		foreach ($this->options($properties) as $option)
		{
			$value = (string) ($option['value'] ?? '');
			$text = (string) ($option['text'] ?? '');

			if ($value === '' && $text === '')
			{
				continue;
			}

			$entries[] = $value . '|' . ($text === '' ? $value : $text);
		}

		return implode(',', $entries);
	}

	/**
	 * The custom field type attributes one field's relationship implies.
	 *
	 * A table definition class states that a column stores a key from another
	 * table and should display a value from it. JCB expresses exactly that as a
	 * generated custom field type, so a relationship is not a separate kind of
	 * record to invent -- it is a field whose type is generated instead of picked.
	 * That makes this the whole answer to how a link lands, and it needs no
	 * decision from the caller.
	 *
	 * The type attribute names the field type JCB will generate. The plural of the
	 * target view is used, because that is the convention JCB's own seeded example
	 * follows and it reads as a list of the thing being selected from.
	 *
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 * @param   string                                             $declared    The declared XML type.
	 *
	 * @return  array<string, string>  The link attributes, or an empty array when the field has none.
	 * @since   6.1.6
	 */
	public function link(array $properties, string $declared = ''): array
	{
		$link = $properties['link']['value'] ?? null;

		if (!is_array($link) || $link === [])
		{
			return [];
		}

		$table = trim((string) ($link['table'] ?? ''));
		$entity = trim((string) ($link['entity'] ?? ''));

		if ($table === '' || $entity === '')
		{
			return [];
		}

		$single = trim((string) ($link['view'] ?? '')) ?: $entity;
		$plural = trim((string) ($link['views'] ?? '')) ?: $single . 's';
		$declared = strtolower(trim($declared));

		// A declared type JCB already knows is the field's type, full stop: a
		// ModalSelect, a list or a text field states its own relationship in
		// its own attributes, and turning it into a generated custom type would
		// change the type the source states -- which an extrusion never does.
		// The link builds a custom type only where the source declares no type
		// JCB knows: the source component's own generated field type keeps its
		// name, and a field with no declared type at all is named after the
		// target it selects from.
		if ($declared !== '' && $this->fieldtype->resolve($declared, false) !== null)
		{
			return [];
		}

		$type = $declared === '' ? $plural : $declared;

		return [
			'type' => $type,
			'extends' => 'list',
			'table' => $table,
			'component' => trim((string) ($link['component'] ?? '')),
			'entity' => $entity,
			'view' => $single,
			'views' => $plural,
			'value_field' => trim((string) ($link['value'] ?? 'name')),
			'key_field' => trim((string) ($link['key'] ?? 'id'))
		];
	}

	/**
	 * Flatten the resolved properties into a raw attribute bag.
	 *
	 * @param   string                                            $column      The source column name.
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  array<string, string>  The raw attribute bag.
	 * @since   6.1.6
	 */
	protected function bag(string $column, array $properties): array
	{
		$bag = [];
		$carried = $properties['attributes']['value'] ?? null;

		if (is_array($carried))
		{
			foreach ($carried as $name => $value)
			{
				if (is_string($name) && (is_scalar($value) || $value === null))
				{
					$bag[$name] = (string) $value;
				}
			}
		}

		foreach (['label', 'description', 'hint', 'message', 'default', 'class', 'required', 'filter', 'validate', 'multiple', 'readonly', 'disabled'] as $name)
		{
			$value = $properties[$name]['value'] ?? null;

			// the XML default is the form's own statement; a column's database
			// default is a different thing, and feeds the data default alone
			if ($name === 'default'
				&& !in_array((string) ($properties[$name]['origin'] ?? ''), ['xml', 'notes'], true))
			{
				continue;
			}

			if (is_scalar($value) && (string) $value !== '')
			{
				$bag[$name] = (string) $value;
			}
		}

		$bag['name'] = $column;

		foreach (self::DROP as $name)
		{
			unset($bag[$name]);
		}

		return $bag;
	}

	/**
	 * The option list of one resolved field.
	 *
	 * @param   array<string, array{value: mixed, origin: string}>  $properties  Resolved properties.
	 *
	 * @return  array<int, array{value: mixed, text: mixed}>  The options.
	 * @since   6.1.6
	 */
	protected function options(array $properties): array
	{
		$options = $properties['options']['value'] ?? null;

		if (!is_array($options))
		{
			return [];
		}

		$list = [];

		foreach ($options as $option)
		{
			$option = (array) $option;

			if (!isset($option['value']) && !isset($option['text']))
			{
				continue;
			}

			$list[] = ['value' => $option['value'] ?? '', 'text' => $option['text'] ?? ''];
		}

		return $list;
	}

	/**
	 * Whether one attribute is declared by the field type.
	 *
	 * An empty declared set means the field type could not be resolved, in which
	 * case nothing is filtered out rather than everything.
	 *
	 * @param   string         $name     The attribute name.
	 * @param   array<string>  $allowed  The declared property names.
	 *
	 * @return  bool  True when the attribute may be written.
	 * @since   6.1.6
	 */
	protected function allowed(string $name, array $allowed): bool
	{
		if (in_array($name, self::DROP, true))
		{
			return false;
		}

		if ($allowed === [])
		{
			return true;
		}

		return in_array($name, $allowed, true);
	}

	/**
	 * Escape one attribute value for XML.
	 *
	 * @param   string  $value  The raw value.
	 *
	 * @return  string  The escaped value.
	 * @since   6.1.6
	 */
	protected function escape(string $value): string
	{
		// an apostrophe stays an apostrophe: JCB stores one as typed inside a
		// double-quoted attribute, and the compiler carries it into the
		// language file as typed -- an entity there reads as an entity
		return htmlspecialchars($value, ENT_COMPAT | ENT_XML1, 'UTF-8');
	}
}

