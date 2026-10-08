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


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ReaderInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Inventory;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Php\Template;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\View;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * Reads everything the inventory located into the registries.
 * 
 * The order matters in one place only: the language catalogue is read before
 * anything that resolves a constant, so a label never has to be looked up twice.
 * Otherwise each reader is independent and a failure in one is recorded rather
 * than allowed to abort the run.
 * 
 * @since 6.1.6
 */
final class Dispatcher
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Inventory Registry.
	 *
	 * @var    Inventory
	 * @since  6.1.6
	 */
	protected Inventory $inventory;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The Language Reader.
	 *
	 * @var    ReaderInterface
	 * @since  6.1.6
	 */
	protected ReaderInterface $language;

	/**
	 * The Table Class Reader.
	 *
	 * @var    ReaderInterface
	 * @since  6.1.6
	 */
	protected ReaderInterface $table;

	/**
	 * The Schema Reader.
	 *
	 * @var    ReaderInterface
	 * @since  6.1.6
	 */
	protected ReaderInterface $schema;

	/**
	 * The Form Reader.
	 *
	 * @var    ReaderInterface
	 * @since  6.1.6
	 */
	protected ReaderInterface $form;

	/**
	 * The View Registry.
	 *
	 * @var    View
	 * @since  6.1.6
	 */
	protected View $view;

	/**
	 * The Template Reader.
	 *
	 * @var    Template
	 * @since  6.2.0
	 */
	protected Template $template;

	/**
	 * Constructor.
	 *
	 * @param   Config           $config     The extrusion configuration.
	 * @param   Inventory        $inventory  The located artifact registry.
	 * @param   Report           $report     The run report registry.
	 * @param   ReaderInterface  $language   The language reader.
	 * @param   ReaderInterface  $table      The table class reader.
	 * @param   ReaderInterface  $schema     The schema reader.
	 * @param   ReaderInterface  $form       The form reader.
	 * @param   View             $view       The view registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Inventory $inventory,
		Report $report,
		ReaderInterface $language,
		ReaderInterface $table,
		ReaderInterface $schema,
		ReaderInterface $form,
		View $view,
		Template $template
	)
	{
		$this->config = $config;
		$this->inventory = $inventory;
		$this->report = $report;
		$this->language = $language;
		$this->table = $table;
		$this->schema = $schema;
		$this->form = $form;
		$this->view = $view;
		$this->template = $template;
	}

	/**
	 * Read every located artifact.
	 *
	 * @return  int  The number of artifacts read successfully.
	 * @since   6.1.6
	 */
	public function dispatch(): int
	{
		$read = 0;

		if ($this->config->get('language', true))
		{
			$read += $this->each('language', $this->language);
		}

		if ((string) $this->config->get('tableClass', 'auto') !== 'off')
		{
			$read += $this->each('table_class', $this->table);
		}

		$read += $this->each('schema', $this->schema);
		$read += $this->each('form', $this->form);
		$read += $this->views();

		$this->report->set('counts.read', $read);

		return $read;
	}

	/**
	 * Record one located view file that was deliberately not read.
	 *
	 * The path is the key, because several views legitimately hold a file of the
	 * same name and keying on the name alone would collapse a dozen findings into
	 * one -- which is the very kind of quiet loss this report exists to prevent.
	 *
	 * @param   string  $reason  Why the file was passed over.
	 * @param   string  $path    Absolute path to the file.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function skipped(string $reason, string $path): void
	{
		$this->report->set('view.skipped.' . $reason . '.' . md5($path), $path);
	}

	/**
	 * Read every located artifact of one kind.
	 *
	 * @param   string           $kind    The inventory artifact kind.
	 * @param   ReaderInterface  $reader  The reader for that kind.
	 *
	 * @return  int  The number read successfully.
	 * @since   6.1.6
	 */
	protected function each(string $kind, ReaderInterface $reader): int
	{
		$read = 0;

		foreach ($this->located($kind) as $entry)
		{
			if ($reader->read($entry['path'], $entry['name']))
			{
				$read++;

				continue;
			}

			$this->report->set('failed.read.' . $kind . '.' . md5($entry['path']), $entry['path']);
		}

		return $read;
	}

	/**
	 * Note which views the component has, without reading a line of their code.
	 *
	 * A view's own PHP is the component author's, not a record: JCB writes a
	 * view's files from its fields and its settings, so there is nothing in
	 * those files that a record could be recovered from without assuming the
	 * files were JCB's own output in the first place. What the folders do state,
	 * in a way every Joomla component states it, is which views exist and on
	 * which side of the component they live. That is what is recorded here, and
	 * the writers build each view's record from it with settings of their own.
	 *
	 * @return  int  The number of views noted.
	 * @since   6.1.6
	 */
	protected function views(): int
	{
		$noted = 0;

		// a screen's own template names it first, because it is also the body
		// the screen shows; a class names one the template never got to
		foreach (['main', 'class'] as $says)
		{
		foreach ($this->located('view') as $entry)
		{
			if (($entry['role'] ?? '') !== $says)
			{
				// an editor, a layout or a sub-template belongs to a screen
				// something else names
				continue;
			}

			$name = strtolower(trim((string) ($entry['view'] ?? '')));

			if ($name === '')
			{
				$this->skipped('unnamed', $entry['path']);

				continue;
			}

			$kind = ($entry['scope'] ?? '') === 'site'
				? 'site_view'
				: 'custom_admin_view';

			if ($this->view->exists($kind . '.' . $name))
			{
				continue;
			}

			// what the screen shows is in the screen's own template, so it is
			// read from there rather than invented for it
			$body = $says === 'main'
				? $this->template->read((string) $entry['path'])
				: null;

			$this->view->set($kind . '.' . $name, [
				'name' => $name,
				'path' => $entry['path'],
				'template' => $says === 'main' ? (string) $entry['path'] : '',
				'body' => $body ?? '',
				'scope' => (string) ($entry['scope'] ?? '')
			]);
			$noted++;
		}
		}

		$this->report->set('counts.noted_views', $noted);

		return $noted;
	}

	/**
	 * Every located artifact of one kind.
	 *
	 * @param   string  $kind  The inventory artifact kind.
	 *
	 * @return  array<int, array{path: string, name: string|null, role: string}>  Located artifacts.
	 * @since   6.1.6
	 */
	public function located(string $kind): array
	{
		$count = (int) $this->inventory->get($kind . '_count', 0);
		$entries = [];

		for ($index = 0; $index < $count; $index++)
		{
			$path = $this->inventory->get($kind . '.' . $index . '.path');

			if (!is_string($path) || $path === '')
			{
				continue;
			}

			$name = $this->inventory->get($kind . '.' . $index . '.name');
			$view = $this->inventory->get($kind . '.' . $index . '.view');
			$entries[] = [
				'path' => $path,
				'name' => is_string($name) && $name !== '' ? $name : null,
				'role' => (string) $this->inventory->get($kind . '.' . $index . '.role', ''),
				'scope' => (string) $this->inventory->get($kind . '.' . $index . '.scope', ''),
				'view' => is_string($view) && $view !== '' ? $view : null
			];
		}

		return $entries;
	}
}

