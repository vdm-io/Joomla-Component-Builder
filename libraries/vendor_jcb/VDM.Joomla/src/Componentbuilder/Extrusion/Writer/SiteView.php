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
use VDM\Joomla\Componentbuilder\Extrusion\Registry\View;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Pairing;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Delta;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Placeholder;
use VDM\Joomla\Interfaces\Data\ItemInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Writer;


/**
 * Writes the front end views a component's site templates describe.
 * 
 * A site view is the front end counterpart of an admin view, but it is not built
 * from a database table: its body is the default template of its own folder. That
 * makes it recoverable from any component with a site folder, whether or not JCB
 * built it and whether or not the run ever saw a schema.
 * 
 * The view's data source is the dynamic get the run wrote for it: a real back
 * end source when an admin view of this run answers for the view's name, and a
 * custom-get scaffold when none does -- either way main_get names it, because a
 * site view without a source displays nothing at all.
 * 
 * @since 6.1.6
 */
final class SiteView extends Writer
{
	/**
	 * The View Registry.
	 *
	 * @var    View
	 * @since  6.1.6
	 */
	protected View $view;

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
	 * @param   View           $view         The classified view registry.
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
		View $view,
		Guid $guid,
		Source $source,
		Pairing $pairing,
		Placeholder $placeholder
	)
	{
		parent::__construct($config, $resolved, $item, $report, $delta);

		$this->view = $view;
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
		return 'site_view';
	}

	/**
	 * Write every site view the reader recovered.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.6
	 */
	public function write(): int
	{
		if (!$this->config->get('siteViews', true))
		{
			return 0;
		}

		$written = 0;

		foreach ((array) $this->view->get('site_view') as $key => $entry)
		{
			$entry = (array) $entry;
			$name = (string) ($entry['name'] ?? $key);

			if ($name === '')
			{
				continue;
			}

			if ($this->one($name, (string) $key, $entry))
			{
				$written++;
			}
		}

		$this->report->set('counts.site_view', $written);

		return $written;
	}

	/**
	 * Write one site view.
	 *
	 * @param   string                $name   The view code name.
	 * @param   string                $key    The view's registry key.
	 * @param   array<string, mixed>  $entry  What the reader recovered.
	 *
	 * @return  bool  True when the definition was written.
	 * @since   6.1.6
	 */
	protected function one(string $name, string $key, array $entry): bool
	{
		$guid = $this->pairing->guid(
			'site_view',
			$this->key($name),
			$this->guid->derive([$this->option(), 'site_view', $name])
		);

		if ($guid === null)
		{
			return false;
		}

		$readable = (string) ($entry['system_name'] ?? $name);

		$definition = new \stdClass();
		$definition->guid = $guid;
		$definition->name = $name;
		$definition->codename = $name;
		$definition->context = (string) ($entry['context'] ?? $name);
		$definition->system_name = $readable;
		$definition->description = (string) ($entry['description'] ?? $readable);
		// what the screen shows is what its own template shows; only a screen
		// whose template could not be read is given something to start from
		$definition->default = $this->body($entry, $readable);
		$definition->php_view = (string) ($entry['php_view'] ?? '');
		$definition->add_php_view = (int) ($entry['add_php_view'] ?? 0);
		$definition->main_get = (string) $this->resolved->get(
			'dynamic_get.site_view.' . $this->key($key) . '.guid',
			''
		);
		$definition->published = 1;

		// a view that already stands is a person's own work -- its names, its
		// context, its body, its PHP, its description and its data source --
		// and a re-run touches none of it: the compiled template is derived
		// from that very record, and nothing a source states about a custom
		// screen outranks what the person keeps in JCB. Only a new view is
		// scaffolded
		if (!$this->store($definition, [
			'name', 'codename', 'context', 'system_name', 'description', 'default',
			'php_view', 'add_php_view', 'main_get', 'published'
		], null, $this->row('site_view', $name)))
		{
			return false;
		}

		$this->resolved->set('site_view.' . $this->key($name) . '.guid', $guid);
		$this->resolved->set('site_view.' . $this->key($name) . '.name', $name);

		return true;
	}

	/**
	 * What the screen shows, taken from the screen's own template.
	 *
	 * A component states what a screen looks like in that screen's template,
	 * and the reader has already separated that markup from the PHP which
	 * prepares it. The markup is what JCB holds for the screen, so it is what
	 * is stored -- never something invented in its place.
	 *
	 * A screen whose template could not be read -- one its component states
	 * with a class before any template was laid out for it -- is given
	 * somewhere to start instead. That starting point carries plain words on
	 * purpose: JCB makes the language constants itself when it compiles, and a
	 * constant written in here would be one it never made and cannot
	 * translate.
	 *
	 * @param   array<string, mixed>  $entry     The screen as the reader noted it.
	 * @param   string                $readable  The screen's name, in words.
	 *
	 * @return  string  The body to store.
	 * @since   6.1.8
	 */
	protected function body(array $entry, string $readable): string
	{
		$body = trim((string) ($entry['body'] ?? ''));

		if ($body !== '')
		{
			// the compiler wrote the component's name into this markup, so a
			// screen that read it back would name that component wherever it
			// was used next
			return $this->placeholder->reverse($body);
		}

		$title = htmlspecialchars($readable, ENT_QUOTES, 'UTF-8');

		return <<<HTML
<div class="j-container">
	<h1>{$title}</h1>
	<p>Nothing has been laid out for this page yet.</p>
</div>
HTML;
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

