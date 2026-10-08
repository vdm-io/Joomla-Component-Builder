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

namespace VDM\Joomla\Componentbuilder\Extrusion;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Extrusion Configuration
 * 
 * Holds one run's options. The Extruder's fluent setters validate and write
 * here, and every downstream service receives this object by injection, so the
 * options are read from exactly one place.
 * 
 * @since 6.1.6
 */
final class Config extends Registry implements Registryinterface
{
	/**
	 * The reviewed option defaults for a run.
	 *
	 * @var    array<string, mixed>
	 * @since  6.1.6
	 */
	private const DEFAULTS = [
		'mode' => 'create',
		'component' => 0,
		'codeName' => '',
		'dump' => '',
		'onExisting' => 'update',
		'repairNamespaces' => false,
		'admin' => true,
		'site' => false,
		'tabs' => true,
		'conditions' => true,
		'language' => true,
		'translations' => false,
		'relations' => true,
		'component_details' => true,
		'siteViews' => true,
		'adminPath' => '',
		'sitePath' => '',
		'libraries' => [],
		'code' => false,
		'include' => [],
		'exclude' => [],
		'precedence' => ['table', 'notes', 'xml', 'derived'],
		'tableClass' => 'auto',
		'layout' => 'auto',
		'languageTag' => 'en-GB',
		'dryRun' => false,
		'strict' => false,
		'depth' => 12,
		'maxFiles' => 20000,
		'skipColumns' => self::BOILERPLATE,
		'skipViews' => self::GENERATED_VIEWS
	];

	/**
	 * Columns Joomla manages itself, which are never extruded as fields.
	 *
	 * JCB generates all of these for every view from its own switches, so
	 * carrying them across would produce duplicate, unusable field definitions.
	 * The guid column is deliberately NOT here: JCB models it as a real field
	 * (the Globally Unique ID field every view links), so it is extruded and
	 * paired like any other -- a JCB-built source even states its identity.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	public const BOILERPLATE = [
		'id', 'asset_id', 'published', 'created_by', 'modified_by',
		'created', 'modified', 'checked_out', 'checked_out_time', 'version',
		'hits', 'access', 'ordering', 'metakey', 'metadesc', 'metadata', 'params'
	];

	/**
	 * The view files JCB's own compiler owns, so they are never user content.
	 *
	 * This is not a guess and not a heuristic. Every name here is a template file
	 * shipped in admin/compiler/joomla_*, placed by the same create and move maps
	 * the placement rule is inverted from, which makes it the compiler's own
	 * statement of what it generates.
	 *
	 * It matters because the boilerplate is indistinguishable from user content by
	 * shape alone. A real component carries default_body.php inside every one of its
	 * list views -- twelve of them in getbible, each with different content, because
	 * the compiler writes each from that view's own field set. Extruding those as
	 * reusable templates would produce a dozen records fighting over one code name,
	 * eleven of which would be silently overwritten, and none of which described
	 * anything a person wrote.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	public const GENERATED_VIEWS = [
		'default', 'default_batch_body', 'default_batch_footer', 'default_body',
		'default_custom_admin', 'default_custom_admin_template', 'default_foot',
		'default_head', 'default_import', 'default_import_custom',
		'default_list_custom_admin', 'default_list_site', 'default_main',
		'default_site', 'default_site_template', 'default_toolbar', 'default_vdm'
	];

	/**
	 * The permitted values for the enumerated options.
	 *
	 * @var    array<string, array<string>>
	 * @since  6.1.6
	 */
	private const ALLOWED = [
		'mode' => ['create', 'update'],
		'onExisting' => ['skip', 'update', 'replace'],
		'tableClass' => ['auto', 'off'],
		'layout' => ['auto', 'j3', 'j4', 'j5', 'j6']
	];

	/**
	 * The precedence tiers, highest first, that a run may reorder.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	public const TIERS = ['table', 'notes', 'xml', 'derived'];

	/**
	 * Constructor.
	 *
	 * Options handed in survive; the reviewed defaults only fill what is absent,
	 * so a run may be configured up front without the defaults erasing it again.
	 *
	 * @param   mixed        $data       Optional data to load into the registry.
	 * @param   string|null  $separator  The path separator.
	 *
	 * @since   6.1.6
	 */
	public function __construct($data = null, ?string $separator = null)
	{
		parent::__construct($data, $separator);

		$this->seed(false);
	}

	/**
	 * Restore every option to its reviewed default.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function defaults(): self
	{
		return $this->seed(true);
	}

	/**
	 * Clear the configuration and restore the defaults.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function clear(): self
	{
		parent::clear();

		return $this->defaults();
	}

	/**
	 * Whether a value is permitted for an enumerated option.
	 *
	 * @param   string  $key    The option name.
	 * @param   string  $value  The candidate value.
	 *
	 * @return  bool  True when the option is unconstrained or the value is allowed.
	 * @since   6.1.6
	 */
	public function permitted(string $key, string $value): bool
	{
		if (!isset(self::ALLOWED[$key]))
		{
			return true;
		}

		return in_array($value, self::ALLOWED[$key], true);
	}

	/**
	 * The permitted values for an enumerated option.
	 *
	 * @param   string  $key  The option name.
	 *
	 * @return  array<string>  The allowed values, or an empty list when unconstrained.
	 * @since   6.1.6
	 */
	public function allowed(string $key): array
	{
		return self::ALLOWED[$key] ?? [];
	}

	/**
	 * Whether an option name is part of the reviewed catalogue.
	 *
	 * @param   string  $key  The option name.
	 *
	 * @return  bool  True when the option is known.
	 * @since   6.1.6
	 */
	public function known(string $key): bool
	{
		return array_key_exists($key, self::DEFAULTS);
	}

	/**
	 * Whether a source table or view name passes the include and exclude filters.
	 *
	 * @param   string  $name  The table or view name.
	 *
	 * @return  bool  True when the name should be extruded.
	 * @since   6.1.6
	 */
	public function selected(string $name): bool
	{
		$include = (array) $this->get('include', []);
		$exclude = (array) $this->get('exclude', []);

		if ($include !== [] && !in_array($name, $include, true))
		{
			return false;
		}

		return !in_array($name, $exclude, true);
	}

	/**
	 * Whether one column should become a JCB field at all.
	 *
	 * @param   string  $column  The source column name.
	 *
	 * @return  bool  True when the column should be extruded.
	 * @since   6.1.6
	 */
	public function extrudable(string $column): bool
	{
		$skip = array_map(
			static fn ($name): string => strtolower(trim((string) $name)),
			(array) $this->get('skipColumns', self::BOILERPLATE)
		);

		return !in_array(strtolower(trim($column)), $skip, true);
	}

	/**
	 * Whether one view file is user content rather than compiler boilerplate.
	 *
	 * @param   string  $name  The file name without its extension.
	 *
	 * @return  bool  True when the file is worth extruding.
	 * @since   6.1.6
	 */
	public function templatable(string $name): bool
	{
		$skip = array_map(
			static fn ($name): string => strtolower(trim((string) $name)),
			(array) $this->get('skipViews', self::GENERATED_VIEWS)
		);

		return !in_array(strtolower(trim($name)), $skip, true);
	}

	/**
	 * The precedence rank of one tier, lower being stronger.
	 *
	 * @param   string  $tier  The tier name.
	 *
	 * @return  int  The rank, or a rank past every tier when unknown.
	 * @since   6.1.6
	 */
	public function rank(string $tier): int
	{
		$order = (array) $this->get('precedence', self::TIERS);
		$rank = array_search($tier, $order, true);

		return $rank === false ? count(self::TIERS) + 1 : (int) $rank;
	}

	/**
	 * Write the reviewed defaults into the registry.
	 *
	 * An option is treated as absent when it holds no value at all, so a null
	 * carried in from loaded data still falls back to its reviewed default and
	 * every catalogued option is guaranteed to be usable.
	 *
	 * @param   bool  $overwrite  True to reset present options, false to only fill the gaps.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	private function seed(bool $overwrite): self
	{
		foreach (self::DEFAULTS as $key => $value)
		{
			if ($overwrite || !$this->exists($key))
			{
				$this->set($key, $value);
			}
		}

		return $this;
	}
}

