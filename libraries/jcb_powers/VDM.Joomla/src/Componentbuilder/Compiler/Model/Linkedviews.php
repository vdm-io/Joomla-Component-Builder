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
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Linked Views Class
 * 
 * @since 3.2.0
 */
class Linkedviews
{
	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Constructor
	 *
	 * @param Registry|null    $registry     The compiler registry object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Registry $registry = null)
	{
		$this->registry = $registry ?: Compiler::_('Registry');
	}

	/**
	 * Set the linked views
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addlinked_views  = (isset($item->addlinked_views)
			&& JsonHelper::check($item->addlinked_views))
			? json_decode((string) $item->addlinked_views, true) : null;

		if (ArrayHelper::check($item->addlinked_views))
		{
			// setup linked views to global data sets
			$this->registry->set('builder.linked_admin_views.' . $item->name_single_code,
				array_values(
					$item->addlinked_views
				)
			);
		}

		unset($item->addlinked_views);
	}

}

