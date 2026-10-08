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

namespace VDM\Joomla\Componentbuilder\Extrusion\Reader;


use SimpleXMLElement;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Form as FormRegistry;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ReaderInterface;


/**
 * Reads one form XML document into the Form registry.
 * 
 * Every field attribute is carried across verbatim rather than curated, because
 * JCB's own field.xml is itself an attribute bag and the value of this reader is
 * exactly the attributes we hold no opinion about. Structure is captured in the
 * same pass: fieldsets become the tab signal, and a field nested in a
 *  group records that group name. Both fields and fieldsets
 * carry a zero-based order, which is their position in the document, so the
 * source ordering survives into the definitions.
 * 
 * The document is untrusted, so it is parsed as a string with libxml's internal
 * error buffer active. A malformed file therefore neither warns nor throws: it
 * is recorded in the report and the read returns false. The file is never
 * included, required, or evaluated.
 * 
 * @since 6.1.6
 */
final class Form implements ReaderInterface
{
	/**
	 * How deep the element walk may descend before it stops.
	 *
	 * A bound is needed because the document comes from an unzipped upload and
	 * may be nested arbitrarily deeply.
	 *
	 * @var    int
	 * @since  6.1.6
	 */
	private const DEPTH = 32;

	/**
	 * The Form Registry.
	 *
	 * @var    FormRegistry
	 * @since  6.1.6
	 */
	protected FormRegistry $form;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * How many unnamed fieldsets the document being read has produced.
	 *
	 * Named fieldsets key on their name, so only the unnamed ones need a
	 * positional key. Resetting this per read keeps a second read of the same
	 * document idempotent.
	 *
	 * @var    int
	 * @since  6.1.6
	 */
	private int $anonymous = 0;

	/**
	 * Constructor.
	 *
	 * @param   FormRegistry  $form    The parsed form registry.
	 * @param   Report        $report  The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(FormRegistry $form, Report $report)
	{
		$this->form = $form;
		$this->report = $report;
	}

	/**
	 * Read one form XML document into the Form registry.
	 *
	 * @param   string       $path  Absolute path to the form XML.
	 * @param   string|null  $name  The view name, derived from the file name when null.
	 *
	 * @return  bool  True when at least one field was read.
	 * @since   6.1.6
	 */
	public function read(string $path, ?string $name = null): bool
	{
		$view = $this->key($name ?? pathinfo($path, PATHINFO_FILENAME));
		$this->anonymous = 0;
		$this->report->set('form.' . $view . '.path', $path);

		$content = $this->content($path);

		if ($content === null)
		{
			$this->report->set('form.' . $view . '.error', 'the file could not be read');

			return false;
		}

		$xml = $this->parse($content, $view);

		if ($xml === null)
		{
			return false;
		}

		$this->form->set('view.' . $view . '.name', $view);

		if ($xml->getName() !== 'form')
		{
			$this->report->set('form.' . $view . '.root', $xml->getName());
		}

		$read = $this->element($xml, $view, '', null, 0);

		$this->report->set('form.' . $view . '.fields', $this->total($view, 'field'));
		$this->report->set('form.' . $view . '.fieldsets', $this->total($view, 'fieldset'));

		return $read > 0;
	}

	/**
	 * Sanitise one value into a safe registry path segment.
	 *
	 * The registry addresses state by a dot separated path and discards empty
	 * segments, so anything that is not a plain word character collapses to an
	 * underscore and an empty result becomes a stable placeholder.
	 *
	 * @param   string  $value  The raw value.
	 *
	 * @return  string  A safe single path segment.
	 * @since   6.1.6
	 */
	public function key(string $value): string
	{
		$key = preg_replace('/[^A-Za-z0-9_]+/', '_', trim($value));

		return $key === null || $key === '' ? 'unknown' : $key;
	}

	/**
	 * Walk one element and store every field, fieldset, and group it holds.
	 *
	 * @param   SimpleXMLElement  $element   The element to walk.
	 * @param   string            $view      The view key.
	 * @param   string            $fieldset  The enclosing fieldset key, or an empty string.
	 * @param   string|null       $subform   The enclosing fields group name, or null.
	 * @param   int               $depth     The current walk depth.
	 *
	 * @return  int  How many fields were stored below this element.
	 * @since   6.1.6
	 */
	protected function element(
		SimpleXMLElement $element,
		string $view,
		string $fieldset,
		?string $subform,
		int $depth
	): int
	{
		if ($depth >= self::DEPTH)
		{
			$this->report->set('form.' . $view . '.depth', 'the element walk stopped at depth ' . $depth);

			return 0;
		}

		$read = 0;

		foreach ($element->children() as $child)
		{
			switch ($child->getName())
			{
				case 'field':
					$name = $this->attribute($child, 'name');
					$read += $this->field($child, $view, $fieldset, $subform) === null ? 0 : 1;
					$read += $this->element(
						$child,
						$view,
						$fieldset,
						$name === '' ? $subform : $name,
						$depth + 1
					);
					break;

				case 'fieldset':
					$read += $this->element(
						$child,
						$view,
						$this->fieldset($child, $view),
						$subform,
						$depth + 1
					);
					break;

				case 'fields':
					$name = $this->attribute($child, 'name');
					$read += $this->element(
						$child,
						$view,
						$fieldset,
						$name === '' ? $subform : $name,
						$depth + 1
					);
					break;

				default:
					$read += $this->element($child, $view, $fieldset, $subform, $depth + 1);
					break;
			}
		}

		return $read;
	}

	/**
	 * Store one field element.
	 *
	 * @param   SimpleXMLElement  $element   The field element.
	 * @param   string            $view      The view key.
	 * @param   string            $fieldset  The enclosing fieldset key, or an empty string.
	 * @param   string|null       $subform   The enclosing fields group name, or null.
	 *
	 * @return  string|null  The field key, or null when the field has no name.
	 * @since   6.1.6
	 */
	protected function field(
		SimpleXMLElement $element,
		string $view,
		string $fieldset,
		?string $subform
	): ?string
	{
		$name = $this->attribute($element, 'name');

		if ($name === '')
		{
			$this->report->set(
				'form.' . $view . '.unnamed',
				((int) $this->report->get('form.' . $view . '.unnamed', 0)) + 1
			);

			return null;
		}

		$key = $this->identity($view, $name, $subform);
		$path = 'view.' . $view . '.field.' . $key;
		$group = $this->group($element, $fieldset);
		$order = (int) $this->form->get($path . '.order', $this->total($view, 'field'));

		$this->form->set($path . '.name', $name);
		$this->form->set($path . '.type', $this->attribute($element, 'type'));
		$this->form->set($path . '.fieldset', $group);
		$this->form->set($path . '.order', $order);

		if ($subform !== null && $subform !== '')
		{
			$this->form->set($path . '.subform', $subform);
		}

		foreach ($element->attributes() as $attribute => $value)
		{
			$this->form->set($path . '.attribute.' . $this->key((string) $attribute), (string) $value);
		}

		$this->options($element, $path);

		return $key;
	}

	/**
	 * Resolve which fieldset one field belongs to.
	 *
	 * An enclosing <fieldset> wins, because that is the structure the document
	 * actually declares, and a fieldset= attribute is the fallback for the flat
	 * form layout that declares no enclosing element. A field that names neither
	 * belongs to no fieldset, which is recorded as an empty string rather than as
	 * the placeholder a sanitised empty name would produce.
	 *
	 * @param   SimpleXMLElement  $element   The field element.
	 * @param   string            $fieldset  The enclosing fieldset key, or an empty string.
	 *
	 * @return  string  The fieldset key, or an empty string.
	 * @since   6.1.6
	 */
	protected function group(SimpleXMLElement $element, string $fieldset): string
	{
		if ($fieldset !== '')
		{
			return $fieldset;
		}

		$name = $this->attribute($element, 'fieldset');

		return $name === '' ? '' : $this->key($name);
	}

	/**
	 * Store one fieldset element.
	 *
	 * @param   SimpleXMLElement  $element  The fieldset element.
	 * @param   string            $view     The view key.
	 *
	 * @return  string  The fieldset key.
	 * @since   6.1.6
	 */
	protected function fieldset(SimpleXMLElement $element, string $view): string
	{
		$name = $this->attribute($element, 'name');
		$key = $name === '' ? 'fieldset_' . $this->anonymous++ : $this->key($name);
		$path = 'view.' . $view . '.fieldset.' . $key;
		$order = (int) $this->form->get($path . '.order', $this->total($view, 'fieldset'));

		$this->form->set($path . '.name', $name);
		$this->form->set($path . '.label', $this->attribute($element, 'label'));
		$this->form->set($path . '.order', $order);

		return $key;
	}

	/**
	 * Store the option children of one field.
	 *
	 * @param   SimpleXMLElement  $element  The field element.
	 * @param   string            $path     The field's registry path.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function options(SimpleXMLElement $element, string $path): void
	{
		$index = 0;

		foreach ($element->children() as $child)
		{
			if ($child->getName() !== 'option')
			{
				continue;
			}

			$this->form->set($path . '.option.' . $index . '.value', $this->attribute($child, 'value'));
			$this->form->set($path . '.option.' . $index . '.text', trim((string) $child));
			$index++;
		}
	}

	/**
	 * Resolve the registry key for one field name.
	 *
	 * A form may legitimately reuse a field name in two different groups, so a
	 * key that is already taken by the same name and group is reused, keeping a
	 * repeated read idempotent, while a genuine clash is given a numbered key
	 * and recorded rather than silently overwritten.
	 *
	 * @param   string       $view     The view key.
	 * @param   string       $name     The raw field name.
	 * @param   string|null  $subform  The enclosing fields group name, or null.
	 *
	 * @return  string  A free or matching field key.
	 * @since   6.1.6
	 */
	protected function identity(string $view, string $name, ?string $subform): string
	{
		$base = $this->key($name);
		$key = $base;
		$index = 1;

		while ($this->form->exists('view.' . $view . '.field.' . $key . '.name'))
		{
			$path = 'view.' . $view . '.field.' . $key;

			if ((string) $this->form->get($path . '.name', '') === $name
				&& (string) $this->form->get($path . '.subform', '') === (string) $subform)
			{
				return $key;
			}

			$index++;
			$key = $base . '_' . $index;
		}

		if ($index > 1)
		{
			$this->report->set('form.' . $view . '.duplicate.' . $base, $name);
		}

		return $key;
	}

	/**
	 * How many entries of one kind the view already holds.
	 *
	 * @param   string  $view  The view key.
	 * @param   string  $kind  The entry kind, field or fieldset.
	 *
	 * @return  int  The stored entry count.
	 * @since   6.1.6
	 */
	protected function total(string $view, string $kind): int
	{
		return count((array) $this->form->get('view.' . $view . '.' . $kind, []));
	}

	/**
	 * Read one attribute as a trimmed string.
	 *
	 * @param   SimpleXMLElement  $element  The element.
	 * @param   string            $name     The attribute name.
	 *
	 * @return  string  The attribute value, or an empty string.
	 * @since   6.1.6
	 */
	protected function attribute(SimpleXMLElement $element, string $name): string
	{
		return trim((string) ($element[$name] ?? ''));
	}

	/**
	 * Read the document without allowing a failure to surface as a warning.
	 *
	 * @param   string  $path  Absolute path to the form XML.
	 *
	 * @return  string|null  The content, or null when it is unusable.
	 * @since   6.1.6
	 */
	protected function content(string $path): ?string
	{
		if ($path === '' || !is_file($path))
		{
			return null;
		}

		$content = @file_get_contents($path);

		return $content === false || trim($content) === '' ? null : $content;
	}

	/**
	 * Parse the document with libxml's internal error buffer active.
	 *
	 * @param   string  $content  The document content.
	 * @param   string  $view     The view key.
	 *
	 * @return  SimpleXMLElement|null  The document element, or null when malformed.
	 * @since   6.1.6
	 */
	protected function parse(string $content, string $view): ?SimpleXMLElement
	{
		$previous = libxml_use_internal_errors(true);
		libxml_clear_errors();
		$xml = simplexml_load_string($content, SimpleXMLElement::class, LIBXML_NONET | LIBXML_NOCDATA);
		$errors = libxml_get_errors();
		libxml_clear_errors();
		libxml_use_internal_errors($previous);

		if ($xml instanceof SimpleXMLElement)
		{
			return $xml;
		}

		$this->report->set(
			'form.' . $view . '.error',
			$errors === [] ? 'the document could not be parsed' : trim($errors[0]->message)
		);

		return null;
	}
}

