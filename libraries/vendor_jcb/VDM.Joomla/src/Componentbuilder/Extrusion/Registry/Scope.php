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

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Componentbuilder\Extrusion\Config;


/**
 * The run boundary for every piece of extrusion state.
 * 
 * The registries are shared services, so without an explicit boundary a second
 * extrusion in one request would inherit the first one's findings. Clearing them
 * from one place makes that boundary impossible to forget, and keeps the entry
 * point from having to know the full set.
 * 
 * @since 6.1.6
 */
final class Scope
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Inventory Registry.
	 *
	 * @var    Inventory
	 * @since  6.1.6
	 */
	protected Inventory $inventory;

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
	 * The Language Registry.
	 *
	 * @var    Language
	 * @since  6.1.6
	 */
	protected Language $language;

	/**
	 * The View Registry.
	 *
	 * @var    View
	 * @since  6.1.6
	 */
	protected View $view;

	/**
	 * The Resolved Registry.
	 *
	 * @var    Resolved
	 * @since  6.1.6
	 */
	protected Resolved $resolved;

	/**
	 * The Harvest Registry.
	 *
	 * @var    Harvest
	 * @since  6.1.7
	 */
	protected Harvest $harvest;

	/**
	 * The Decision Registry.
	 *
	 * @var    Decision
	 * @since  6.1.7
	 */
	protected Decision $decision;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The Message Bus.
	 *
	 * @var    Message
	 * @since  6.1.6
	 */
	protected Message $message;

	/**
	 * The Proposal Registry.
	 *
	 * @var    Proposal
	 * @since  6.2.0
	 */
	protected Proposal $proposal;

	/**
	 * The complete-operation write plan.
	 *
	 * @var    Plan
	 * @since  6.2.0
	 */
	protected Plan $plan;

	/**
	 * Context-independent lexical observations from this operation.
	 *
	 * @var    Parsed
	 * @since  6.2.0
	 */
	protected Parsed $parsed;

	/**
	 * Constructor.
	 *
	 * @param   Config     $config     The extrusion configuration.
	 * @param   Source     $source     The source identity registry.
	 * @param   Inventory  $inventory  The located artifact registry.
	 * @param   Table      $table      The table definition registry.
	 * @param   Schema     $schema     The parsed schema registry.
	 * @param   Form       $form       The parsed form registry.
	 * @param   Language   $language   The language catalogue registry.
	 * @param   View       $view       The classified view registry.
	 * @param   Resolved   $resolved   The resolved definition registry.
	 * @param   Harvest    $harvest    The powers harvest registry.
	 * @param   Decision   $decision   The pairing decision registry.
	 * @param   Report     $report     The run report registry.
	 * @param   Message    $message    The message bus.
	 * @param   Proposal   $proposal   The proposal registry.
	 * @param   Plan       $plan       The complete operation write plan.
	 * @param   Parsed     $parsed     The source-content parsing cache.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Source $source,
		Inventory $inventory,
		Table $table,
		Schema $schema,
		Form $form,
		Language $language,
		View $view,
		Resolved $resolved,
		Harvest $harvest,
		Decision $decision,
		Report $report,
		Message $message,
		Proposal $proposal,
		Plan $plan,
		Parsed $parsed
	)
	{
		$this->config = $config;
		$this->source = $source;
		$this->inventory = $inventory;
		$this->table = $table;
		$this->schema = $schema;
		$this->form = $form;
		$this->language = $language;
		$this->view = $view;
		$this->resolved = $resolved;
		$this->harvest = $harvest;
		$this->decision = $decision;
		$this->report = $report;
		$this->message = $message;
		$this->proposal = $proposal;
		$this->plan = $plan;
		$this->parsed = $parsed;
	}

	/**
	 * Clear every registry, starting a fresh run.
	 *
	 * The configuration is cleared too, which restores its reviewed defaults
	 * rather than leaving it empty.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	public function reset(): void
	{
		$this->config->clear();

		foreach ($this->registries() as $registry)
		{
			$registry->clear();
		}
	}

	/**
	 * Every state registry in the run, excluding the configuration.
	 *
	 * @return  array<string, Source|Inventory|Table|Schema|Form|Language|View|Resolved|Harvest|Decision|Report|Message>  The registries by name.
	 * @since   6.1.6
	 */
	public function registries(): array
	{
		return [
			'source' => $this->source,
			'inventory' => $this->inventory,
			'table' => $this->table,
			'schema' => $this->schema,
			'form' => $this->form,
			'language' => $this->language,
			'view' => $this->view,
			'resolved' => $this->resolved,
			'harvest' => $this->harvest,
			'decision' => $this->decision,
			'report' => $this->report,
			'message' => $this->message,
			'proposal' => $this->proposal,
			'plan' => $this->plan,
			'parsed' => $this->parsed
		];
	}
}

