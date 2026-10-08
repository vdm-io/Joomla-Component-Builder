<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    25th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Discovery;


use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Reads the access rules a component ships.
 * 
 * access.xml is where a component states every permission it has and at which
 * level it offers it: an action in the component section is set once for the
 * whole component, an action in a view's own section is set per record, and an
 * action in both is offered at both levels. That is exactly the shape JCB
 * stores in a view's permissions, so the file answers the question outright
 * and nothing has to be assumed on the component's behalf.
 * 
 * @since 6.1.8
 */
final class Access
{
	/**
	 * The Scanner Class.
	 *
	 * @var    Scanner
	 * @since  6.1.8
	 */
	protected Scanner $scanner;

	/**
	 * The Selector Class.
	 *
	 * @var    Selector
	 * @since  6.1.8
	 */
	protected Selector $selector;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.8
	 */
	protected Source $source;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.8
	 */
	protected Report $report;

	/**
	 * Constructor.
	 *
	 * @param   Scanner   $scanner   The source tree scanner.
	 * @param   Selector  $selector  The layout selector.
	 * @param   Source    $source    The source identity registry.
	 * @param   Report    $report    The run report registry.
	 *
	 * @since   6.1.8
	 */
	public function __construct(
		Scanner $scanner,
		Selector $selector,
		Source $source,
		Report $report
	)
	{
		$this->scanner = $scanner;
		$this->selector = $selector;
		$this->source = $source;
		$this->report = $report;
	}

	/**
	 * Read the access rules below one root into the source registry.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  int  The number of sections read.
	 * @since   6.1.8
	 */
	public function establish(string $root): int
	{
		$path = $this->find($root);

		if ($path === null)
		{
			return 0;
		}

		$content = $this->scanner->read($path);

		if ($content === null || trim($content) === '')
		{
			return 0;
		}

		$xml = @simplexml_load_string($content);

		if ($xml === false)
		{
			$this->report->set('failed.read.access', $path);

			return 0;
		}

		$sections = 0;

		foreach ($xml->section as $section)
		{
			$name = strtolower(trim((string) $section['name']));

			if ($name === '')
			{
				continue;
			}

			$actions = [];
			$titles = [];

			foreach ($section->action as $action)
			{
				$named = trim((string) $action['name']);

				if ($named !== '')
				{
					$actions[] = $named;
					$titles[$named] = trim((string) $action['title']);
				}
			}

			if ($actions === [])
			{
				continue;
			}

			$this->source->set('access.' . $name, $actions);
			$sections++;

			// every action names the screen it belongs to, so the rules also
			// say which screens the component has -- the only place a screen
			// without a table of its own is named besides the menu
			foreach ($actions as $action)
			{
				$position = strpos($action, '.');

				if ($position === false)
				{
					continue;
				}

				$screen = strtolower(substr($action, 0, $position));

				if ($screen === '' || $screen === 'core')
				{
					continue;
				}

				$this->source->set('access_screens.' . $screen, true);

				// the tail may itself carry dots (edit.created_by), which a
				// registry path would read as further keys
				$tail = str_replace('.', '_', strtolower(substr($action, $position + 1)));

				$this->source->set('access_screens_actions.' . $screen . '.' . $tail, true);

				// the title names the constant the rule is worded under, and
				// JCB words a screen's rules under its list name: the title
				// is the one place the source states which list a screen has
				if (($titles[$action] ?? '') !== '')
				{
					$this->source->set('access_titles.' . $screen . '.' . $tail, $titles[$action]);
				}
			}
		}

		if ($sections > 0)
		{
			$this->source->set('access_path', $path);
			$this->report->set('source.access_sections', $sections);
		}

		return $sections;
	}

	/**
	 * The access rules file below one root, when the component ships one.
	 *
	 * @param   string  $root  The resolved source root.
	 *
	 * @return  string|null  Absolute path, or null when there is none.
	 * @since   6.1.8
	 */
	protected function find(string $root): ?string
	{
		$layout = $this->selector->layout();
		$tokens = ['option' => (string) $this->source->get('code_name', ''), 'tag' => 'en-GB'];

		foreach ($layout->candidates('access', $tokens) as $relative)
		{
			$path = $this->scanner->resolve($root, $relative);

			if ($path !== null && is_file($path))
			{
				return $path;
			}
		}

		return null;
	}
}

