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

namespace VDM\Joomla\Componentbuilder\Extrusion\Abstraction;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\WriterInterface;


/**
 * Shared mechanics for every writer that persists into JCB.
 * 
 * Writing goes through the shared Data pipeline, which resolves insert against
 * update from the GUID and applies the storage encoding declared in JCB's own
 * table definition class. Two consequences shape every subclass: a writer must
 * pass raw values, because encoding here would double-encode; and idempotency is
 * a property of the identity supplied, not of anything the writer does.
 * 
 * A dry run stops at exactly this boundary, so a caller can see the whole report
 * before any definition table is touched.
 * 
 * @since 6.1.6
 */
abstract class Writer implements WriterInterface
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.6
	 */
	protected Resolved $resolved;

	/**
	 * The Data Item Class.
	 *
	 * @var    ItemInterface
	 * @since  6.1.6
	 */
	protected ItemInterface $item;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The Delta Resolver.
	 *
	 * @var    Delta
	 * @since  6.2.0
	 */
	protected Delta $delta;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config    The extrusion configuration.
	 * @param   Resolved       $resolved  The resolved definition registry.
	 * @param   ItemInterface  $item      The JCB data item writer.
	 * @param   Report         $report    The run report registry.
	 * @param   Delta          $delta     The change weigher.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Resolved $resolved,
		ItemInterface $item,
		Report $report,
		Delta $delta
	)
	{
		$this->config = $config;
		$this->resolved = $resolved;
		$this->item = $item;
		$this->report = $report;
		$this->delta = $delta;
	}

	/**
	 * The JCB table this writer persists into.
	 *
	 * @return  string  The table name without its prefix.
	 * @since   6.1.6
	 */
	abstract protected function table(): string;

	/**
	 * Every view name in the resolved set.
	 *
	 * @return  array<string>  The view names.
	 * @since   6.1.6
	 */
	protected function views(): array
	{
		$views = $this->resolved->get('views', []);

		return is_array($views) ? array_values(array_filter($views, 'is_string')) : [];
	}

	/**
	 * The resolved registry path of one view.
	 *
	 * @param   string  $view  The view name.
	 *
	 * @return  string  The registry path.
	 * @since   6.1.6
	 */
	protected function path(string $view): string
	{
		return 'view.' . $this->key($view);
	}

	/**
	 * Persist one definition through the Data pipeline.
	 *
	 * A definition carries two kinds of value: what the source actually
	 * stated, and the scaffolding a brand new record needs to be usable.
	 * The scaffolding is offered only when the record is new -- updating a
	 * definition someone has since curated must refresh what the source
	 * says and touch nothing else, or every re-run would undo their work.
	 *
	 * What survives that is weighed against the record that stands before any
	 * of it is written, and the weighing is what a person is shown on the
	 * pairing board. Because it happens here, at the one boundary every writer
	 * passes, what the board shows and what the import does cannot come apart:
	 * they are the same composition, weighed and then written.
	 *
	 * A write that would change nothing is not made. The record already says
	 * what the source says, and touching it would only move its modified date
	 * and add a version of itself that reads identically.
	 *
	 * @param   object          $definition   The definition, carrying its guid.
	 * @param   array<string>   $boilerplate  Properties to offer only on creation.
	 * @param   string|null     $key          The column the table is keyed by.
	 * @param   string|null     $origin       The pairing board row this record belongs to.
	 *
	 * @return  bool  True when the definition was written, or nothing needed writing.
	 * @since   6.1.6
	 */
	protected function store(
		object $definition,
		array $boilerplate = [],
		?string $key = null,
		?string $origin = null
	): bool
	{
		$key = $key ?? $this->linkKey();
		$identity = (string) ($definition->{$key} ?? '');

		if ($identity === '')
		{
			$this->report->set('failed.' . $this->table() . '.missing_' . $key, true);

			return false;
		}

		$existing = $this->item->table($this->table())->value($identity, $key, 'id');
		$stands = $existing !== null && $existing > 0;
		$policy = (string) $this->config->get('onExisting', 'update');

		if ($stands && $policy === 'skip')
		{
			$this->report->set('skipped.existing.' . $this->table() . '.' . $identity, true);

			return true;
		}

		if ($stands && $boilerplate !== [])
		{
			foreach ($boilerplate as $property)
			{
				unset($definition->{$property});
			}

			$this->report->set(
				'kept.' . $this->table() . '.' . $identity,
				$boilerplate
			);
		}

		$delta = $this->delta->weigh(
			$this->table(), $key, $identity, $definition, $stands, $origin
		);

		if (empty($delta['changed']))
		{
			$this->report->set('unchanged.' . $this->table() . '.' . $identity, true);

			return true;
		}

		if ($this->delta->staging())
		{
			return true;
		}

		if ($this->config->get('dryRun', false))
		{
			$this->report->set('dryrun.' . $this->table() . '.' . $identity, true);

			return true;
		}

		if ($stands)
		{
			foreach (get_object_vars($definition) as $column => $value)
			{
				if ($column !== $key && !array_key_exists($column, $delta['columns']))
				{
					unset($definition->{$column});
				}
			}
		}

		if (!$this->item->table($this->table())->set($definition, $key))
		{
			$this->report->set('failed.' . $this->table() . '.' . $identity, true);

			return false;
		}

		$this->report->set('written.' . $this->table() . '.' . $identity, true);

		return true;
	}

	/**
	 * The column this writer's table is keyed by.
	 *
	 * The entity tables carry their own guid, so guid is the default. A
	 * linked-map table (admin_fields, component_admin_views, and their kin)
	 * holds no guid at all -- the Table class defines none for it -- and is
	 * keyed by the column that names its parent, exactly as JCB's Package
	 * import declares a key field per area. A writer for such a table
	 * declares that column by overriding this method.
	 *
	 * @return  string  The key column of this writer's table.
	 * @since   6.1.7
	 */
	protected function linkKey(): string
	{
		return 'guid';
	}

	/**
	 * The value of one resolved field property.
	 *
	 * @param   array<string, mixed>  $properties  The resolved properties.
	 * @param   string                $property    The property name.
	 * @param   mixed                 $default     A value to use when unresolved.
	 *
	 * @return  mixed  The resolved value, or the default.
	 * @since   6.1.6
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
	 * The pairing board row one record belongs to.
	 *
	 * The board is keyed by the candidate a person sees -- a view, one of its
	 * fields, a screen -- while records are keyed by table and identity. A
	 * record has to name its row or there is nowhere to show what it would
	 * change, and the parts are sanitised exactly as the candidates are so the
	 * two names meet.
	 *
	 * @param   string  $kind      The candidate kind.
	 * @param   string  ...$parts  The candidate key, in parts.
	 *
	 * @return  string  The board row.
	 * @since   6.2.0
	 */
	protected function row(string $kind, string ...$parts): string
	{
		return $kind . '|' . implode('.', array_map([$this, 'key'], $parts));
	}

	/**
	 * The pairing board row every component-level record belongs to.
	 *
	 * The component itself, and the tables that link its views to it, are not
	 * candidates a person pairs -- they follow from the run. They still name a
	 * row, so what they would change is never lost from the account, and the
	 * row is spelt as the component's own identity is: the code name without
	 * its prefix.
	 *
	 * @param   string  $code  The source's code name, with or without com_.
	 *
	 * @return  string  The board row.
	 * @since   6.2.0
	 */
	protected function componentRow(string $code): string
	{
		$code = trim(str_replace('com_', '', strtolower(trim($code))), '_');

		return $this->row('component', $code === '' ? 'component' : $code);
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

