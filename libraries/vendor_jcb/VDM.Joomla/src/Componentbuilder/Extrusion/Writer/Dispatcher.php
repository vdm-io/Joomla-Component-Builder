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
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\WriterInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;


/**
 * Runs the writers in dependency order.
 * 
 * Fields must exist before anything can reference them, views before the links
 * that point at them, and the component link last of all. Getting that order
 * wrong would produce definitions that reference identities not yet written, so
 * the order is stated here once rather than assumed by each writer.
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
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The Field Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $field;

	/**
	 * The Admin View Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $adminview;

	/**
	 * The Admin Fields Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $adminfields;

	/**
	 * The Admin Fields Conditions Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $conditions;

	/**
	 * The Component Admin Views Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $component;

	/**
	 * The Component Details Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $details;

	/**
	 * The Site View Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $siteview;

	/**
	 * The Component Site Views Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.6
	 */
	protected WriterInterface $sitelink;

	/**
	 * The Dynamic Get Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.8
	 */
	protected WriterInterface $dynamicget;

	/**
	 * The Custom Admin View Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.8
	 */
	protected WriterInterface $customadminview;

	/**
	 * The Component Custom Admin Views Writer.
	 *
	 * @var    WriterInterface
	 * @since  6.1.8
	 */
	protected WriterInterface $customlink;

	/**
	 * Constructor.
	 *
	 * @param   Config           $config       The extrusion configuration.
	 * @param   Report           $report       The run report registry.
	 * @param   WriterInterface  $field        The field writer.
	 * @param   WriterInterface  $adminview    The admin view writer.
	 * @param   WriterInterface  $adminfields  The admin fields writer.
	 * @param   WriterInterface  $conditions   The field conditions writer.
	 * @param   WriterInterface  $component    The component link writer.
	 * @param   WriterInterface  $details      The component details writer.
	 * @param   WriterInterface  $siteview     The site view writer.
	 * @param   WriterInterface  $sitelink     The component site views writer.
	 * @param   WriterInterface  $dynamicget       The dynamic get writer.
	 * @param   WriterInterface  $customadminview  The custom admin view writer.
	 * @param   WriterInterface  $customlink       The component custom admin views writer.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Report $report,
		WriterInterface $field,
		WriterInterface $adminview,
		WriterInterface $adminfields,
		WriterInterface $conditions,
		WriterInterface $component,
		WriterInterface $details,
		WriterInterface $siteview,
		WriterInterface $sitelink,
		WriterInterface $dynamicget,
		WriterInterface $customadminview,
		WriterInterface $customlink
	)
	{
		$this->config = $config;
		$this->report = $report;
		$this->field = $field;
		$this->adminview = $adminview;
		$this->adminfields = $adminfields;
		$this->conditions = $conditions;
		$this->component = $component;
		$this->details = $details;
		$this->siteview = $siteview;
		$this->sitelink = $sitelink;
		$this->dynamicget = $dynamicget;
		$this->customadminview = $customadminview;
		$this->customlink = $customlink;
	}

	/**
	 * Run every writer in dependency order.
	 *
	 * @return  int  The total number of definitions written.
	 * @since   6.1.6
	 */
	public function dispatch(): int
	{
		$written = 0;

		foreach ($this->order() as $name => $writer)
		{
			$count = $writer->write();
			$written += $count;
			$this->report->set('written_counts.' . $name, $count);
		}

		$this->report->set('counts.written', $written);

		return $written;
	}

	/**
	 * The writers in the order they must run.
	 *
	 * @return  array<string, WriterInterface>  Writer name keyed to the writer.
	 * @since   6.1.6
	 */
	public function order(): array
	{
		$order = ['joomla_component' => $this->details];

		if ($this->config->get('admin', true))
		{
			$order['field'] = $this->field;
			$order['admin_view'] = $this->adminview;
			$order['admin_fields'] = $this->adminfields;
			$order['admin_fields_conditions'] = $this->conditions;
		}

		$order['dynamic_get'] = $this->dynamicget;
		$order['site_view'] = $this->siteview;
		$order['component_site_views'] = $this->sitelink;

		if ($this->config->get('admin', true))
		{
			$order['custom_admin_view'] = $this->customadminview;
			$order['component_custom_admin_views'] = $this->customlink;
			$order['component_admin_views'] = $this->component;
		}

		return $order;
	}
}

