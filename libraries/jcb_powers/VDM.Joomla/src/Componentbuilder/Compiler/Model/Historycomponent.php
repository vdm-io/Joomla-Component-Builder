<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface;
use VDM\Joomla\Componentbuilder\Compiler\Model\Updatesql;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\JsonHelper;


/**
 * Model Component History Class
 * 
 * @since 3.2.0
 */
class Historycomponent
{
	/**
	 * The compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler history
	 *
	 * @var    HistoryInterface
	 * @since 3.2.0
	 */
	protected HistoryInterface $history;

	/**
	 * The compiler update sql
	 *
	 * @var    Updatesql
	 * @since 3.2.0
	 */
	protected Updatesql $updatesql;

	/**
	 * Constructor
	 *
	 * @param Config|null             $config      The compiler config object.
	 * @param HistoryInterface|null   $history     The compiler history object.
	 * @param Updatesql|null          $updatesql   The compiler updatesql object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?HistoryInterface $history = null,
		?Updatesql $updatesql = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->history = $history ?: Compiler::_('History');
		$this->updatesql = $updatesql ?: Compiler::_('Model.Updatesql');
	}

	/**
	 * check if an update SQL is needed
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		// update SQL for admin views
		$this->setAdminView($item);

		// update SQL for component
		$this->setComponent($item);
	}

	/**
	 * check if an update SQL is needed
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setAdminView(object $item)
	{
		$old_admin_views = null;
		if (isset($item->addadmin_views_id))
		{
			$old_admin_views = $this->history->get(
				'component_admin_views', $item->addadmin_views_id
			);
		}

		// add new views if found
		if ($old_admin_views && ObjectHelper::check($old_admin_views))
		{
			if (isset($old_admin_views->addadmin_views)
				&& JsonHelper::check(
					$old_admin_views->addadmin_views
				))
			{
				$this->updatesql->set(
					json_decode((string) $old_admin_views->addadmin_views, true),
					$item->addadmin_views, 'adminview'
				);
			}
		}
	}

	/**
	 * Set the component history
	 *
	 * @param   object    $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setComponent(object &$item)
	{
		$old_component = null;
		if (isset($this->config->component_id))
		{
			$old_component = $this->history->get(
				'joomla_component', $this->config->component_id
			);
		}

		// check if a new version was manually set
		if ($old_component && ObjectHelper::check($old_component))
		{
			$old_component_version = preg_replace(
				'/[^0-9.]+/', '', (string) $old_component->component_version
			);
			if ($old_component_version != $this->config->component_version)
			{
				// yes, this is a new version, this mean there may
				// be manual sql and must be checked and updated
				$item->old_component_version
					= $old_component_version;
			}
		}
	}

}

