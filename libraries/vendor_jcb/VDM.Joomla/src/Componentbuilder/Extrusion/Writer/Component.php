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
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Language;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Fills in the JCB component record from the component's own manifest.
 * 
 * The manifest is the component's account of itself, and it is the one artifact
 * every Joomla component has: a component with no schema, no table class and no
 * form XML still declares who wrote it, under what licence, at what version and
 * what it is for. Every one of those has a column waiting for it, so leaving them
 * empty would mean the person who ran the extrusion has to retype what the source
 * already said.
 * 
 * Only what the manifest actually stated is written. A column the manifest is
 * silent about is left out of the update entirely rather than blanked, because the
 * caller may well have filled it in before running this and an extrusion has no
 * business erasing that.
 * 
 * @since 6.1.6
 */
final class Component extends Writer
{
	/**
	 * The manifest keys that map straight onto a component column.
	 *
	 * @var    array<string, string>
	 * @since  6.1.6
	 */
	private const DIRECT = [
		'author' => 'author',
		'email' => 'email',
		'website' => 'website',
		'copyright' => 'copyright',
		'license' => 'license'
	];

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Language Resolver.
	 *
	 * @var    Language
	 * @since  6.1.6
	 */
	protected Language $language;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.7
	 */
	protected Guid $guid;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config    The extrusion configuration.
	 * @param   Resolved       $resolved  The resolved definition registry.
	 * @param   ItemInterface  $item      The JCB data item writer.
	 * @param   Report         $report    The run report registry.
	 * @param   Delta          $delta     The change weigher.
	 * @param   Source         $source    The source identity registry.
	 * @param   Language       $language  The language constant resolver.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta,
		Source $source,
		Language $language,
		Guid $guid
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->source = $source;
		$this->language = $language;
		$this->guid = $guid;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.6
	 */
	protected function table(): string
	{
		return 'joomla_component';
	}

	/**
	 * Fill in what the manifest stated about the component.
	 *
	 * @return  int  One when the component record was updated, zero otherwise.
	 * @since   6.1.6
	 */
	public function write(): int
	{
		$component = (int) $this->config->get('component', 0);

		if (!$this->config->get('component_details', true))
		{
			return 0;
		}

		// no target component is not licence to leave the harvest unlinked:
		// a component source names a component, so one is created and every
		// linked-map writer links to it -- an unlinked import is a failure
		if ($component <= 0)
		{
			return $this->create();
		}

		$definition = $this->definition();

		if ($definition === [])
		{
			$this->report->set('component.details', 'the manifest stated nothing to fill in');

			return 0;
		}

		// a component that stands is a person's own: what its record already
		// says stays exactly as they wrote it -- a compiled manifest is derived
		// from that very record, and its echo never overwrites the original.
		// The manifest fills only what the record leaves empty
		$standing = $this->item->table($this->table())->get((string) $component, 'id');

		if ($standing !== null)
		{
			$kept = [];

			foreach (array_keys($definition) as $column)
			{
				if (trim((string) ($standing->{$column} ?? '')) !== '')
				{
					$kept[] = $column;
					unset($definition[$column]);
				}
			}

			if ($kept !== [])
			{
				$this->report->set('kept.joomla_component.' . $component, $kept);
			}

			if ($definition === [])
			{
				$this->report->set('component.details', 'the record already states everything the manifest does');
			}
		}

		if ($definition !== [])
		{
			$this->report->set('component.details', array_keys($definition));
		}

		// the same gate every other record passes: the run's policy on what
		// already stands is read in exactly one place, and a component row is
		// no more exempt from it than a field is
		$row = $this->componentRow((string) $this->source->get('code_name', ''));

		if (!$this->store((object) (['id' => $component] + $definition), [], 'id', $row))
		{
			return 0;
		}

		$this->report->set('counts.joomla_component', 1);

		return 1;
	}

	/**
	 * Create the component record a target-less harvest belongs to.
	 *
	 * The source's own code name gives the identity, the manifest gives the
	 * details, and the recorded guid is what every linked-map writer links
	 * through -- so nothing the harvest found stands unrelated.
	 *
	 * @return  int  One when the component record was created, zero otherwise.
	 * @since   6.1.7
	 */
	protected function create(): int
	{
		$code = strtolower(trim((string) $this->source->get('code_name', '')));
		$code = trim(str_replace('com_', '', $code), '_');

		if ($code === '')
		{
			$this->report->set('failed.joomla_component.no_code_name', true);

			return 0;
		}

		$details = $this->definition();
		$name = trim((string) ($details['name'] ?? '')) ?: ucfirst($code);
		$guid = $this->guid->derive(['joomla_component', $code]);

		// the identity is this writer's own; the manifest details come next,
		// language already resolved; and where the manifest stated nothing,
		// a plain readable fallback stands in
		$definition = (object) ([
			'guid' => $guid,
			'name_code' => $code,
			'system_name' => $name . ' (extruded)',
			'published' => 1
		] + $details + [
			'name' => $name,
			'short_description' => $name . ' (extruded from its installed source)',
			'description' => '',
			'component_version' => '1.0.0'
		]);

		// the naming and the version are scaffolding for a component that does
		// not exist yet; a person who has since named their own must keep it
		$row = $this->componentRow((string) $this->source->get('code_name', ''));

		if (!$this->store($definition, [
			'system_name', 'published', 'short_description', 'description',
			'component_version'
		], null, $row))
		{
			return 0;
		}

		$this->resolved->set('component.guid', $guid);
		$this->config->set('targetComponentGuid', $guid);
		$this->report->set('counts.joomla_component', 1);

		return 1;
	}

	/**
	 * The columns the manifest supplied a value for.
	 *
	 * @return  array<string, mixed>  Column name keyed to its raw value.
	 * @since   6.1.6
	 */
	public function definition(): array
	{
		$stated = (array) $this->source->get('manifest_data', []);
		$definition = [];

		foreach (self::DIRECT as $key => $column)
		{
			$value = trim((string) ($stated[$key] ?? ''));

			if ($value !== '')
			{
				$definition[$column] = $value;
			}
		}

		foreach ($this->names() as $column => $value)
		{
			$definition[$column] = $value;
		}

		$description = trim((string) ($stated['description'] ?? ''));

		if ($description !== '')
		{
			// the manifest wraps a marketing page of HTML in its description;
			// the description column holds what a person would have typed there,
			// so the readable text is stored, never the markup
			$definition['description'] = $this->readable(
				$this->language->resolve($description)
			);
			$definition['short_description'] = $this->summarise($definition['description']);
		}

		$version = trim((string) $this->source->get('version', ''));

		if ($version !== '')
		{
			$definition['component_version'] = $version;
		}

		$namespace = trim((string) ($stated['namespace'] ?? ''));

		if ($namespace !== '' && str_contains($namespace, '\\'))
		{
			// A Joomla namespace is Vendor\Component\Name; JCB owns the second and third
			// segments and asks only for the vendor prefix, so keeping the whole string
			// would have the compiler generate Vendor\Component\Name\Component\Name.
			$definition['namespace_prefix'] = strstr($namespace, '\\', true);
			$definition['add_namespace_prefix'] = 1;
		}

		return $definition + $this->target((string) ($stated['target'] ?? ''));
	}

	/**
	 * The readable text of a description that may be a page of HTML.
	 *
	 * Block tags become line breaks and every other tag a space, so the text
	 * keeps its paragraphs without keeping a single element of markup.
	 *
	 * @param   string  $html  The description as the manifest gave it.
	 *
	 * @return  string  The readable text.
	 * @since   6.1.8
	 */
	public function readable(string $html): string
	{
		$text = preg_replace('/<\/?(?:p|br|div|h[1-6]|li|ul|ol|tr)[^>]*>/i', "\n", $html) ?? $html;
		$text = preg_replace('/<[^>]*>/', ' ', $text) ?? $text;
		$text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = preg_replace('/[ \t]+/', ' ', $text) ?? $text;
		$text = preg_replace('/ ?\n[ \n]*/', "\n", $text) ?? $text;

		return trim($text);
	}

	/**
	 * A one-line summary of a description that may be a page of HTML.
	 *
	 * A manifest description is routinely a marketing page wrapped in CDATA, and the
	 * short description column is a single line shown beside the component. The
	 * first sentence of the readable text is what a person would have written there
	 * themselves, so that is what is taken.
	 *
	 * @param   string  $description  The full description.
	 *
	 * @return  string  A single line of at most 150 characters.
	 * @since   6.1.6
	 */
	public function summarise(string $description): string
	{
		// A tag is a word boundary. Stripping it without one turns </h1><p> into a
		// single run-on word, which is the whole of the summary ruined by markup that
		// was never meant to be read.
		$spaced = preg_replace('/<[^>]*>/', ' ', $description) ?? $description;
		$text = html_entity_decode(strip_tags($spaced), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = trim(preg_replace('/\\s+/', ' ', $text) ?? $text);

		if ($text === '')
		{
			return '';
		}

		if (preg_match('/^(.{20,150}?[.!?])\\s/u', $text . ' ', $matches) === 1)
		{
			return trim($matches[1]);
		}

		if (function_exists('mb_strlen') && mb_strlen($text, 'UTF-8') > 150)
		{
			return rtrim(mb_substr($text, 0, 147, 'UTF-8')) . '...';
		}

		return strlen($text) > 150 ? rtrim(substr($text, 0, 147)) . '...' : $text;
	}

	/**
	 * The component's own name, and the code name its tables carry.
	 *
	 * A manifest name is very often a language constant, and the resolved English
	 * string is what belongs in JCB; falling back to a readable form of the constant
	 * is still better than storing the constant itself.
	 *
	 * @return  array<string, string>  The name columns.
	 * @since   6.1.6
	 */
	public function names(): array
	{
		$names = [];
		$name = trim((string) $this->source->get('name', ''));
		$option = trim((string) $this->source->get('code_name', ''));

		if ($name !== '')
		{
			$resolved = $this->language->resolve($name);
			$names['name'] = $resolved;
			$names['system_name'] = $resolved;
		}

		if ($option !== '')
		{
			$names['name_code'] = preg_replace('/^com_/', '', strtolower($option)) ?? $option;
		}

		return $names;
	}

	/**
	 * The Joomla version the manifest targets, as JCB records it.
	 *
	 * A manifest states its target as a decimal such as 4.0 or 6.0. JCB keeps the
	 * major number alone, so anything that is not a whole major version is dropped
	 * rather than rounded into a version the component never claimed.
	 *
	 * @param   string  $target  The manifest version attribute.
	 *
	 * @return  array<string, int>  The preferred version column, or an empty array.
	 * @since   6.1.6
	 */
	public function target(string $target): array
	{
		$major = (int) strtok(trim($target), '.');

		return $major >= 3 && $major <= 9 ? ['preferred_joomla_version' => $major] : [];
	}
}

