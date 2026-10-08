<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Admin Views Can Do Class.
 * 
 * Builds the permission object a list view is given, which the view asks
 * before it shows anything the user may not be allowed to do.
 * 
 * @since 6.1.7
 */
final class CanDo
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Permission Creator Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * Constructor.
	 *
	 * @param Config     $config     The Config Class.
	 * @param Permission $permission The Permission Creator Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Permission $permission)
	{
		$this->config = $config;
		$this->permission = $permission;
	}

	/**
	 * Build the permission object of a list view.
	 *
	 * What the component was given to check decides which permissions it holds.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	public function get($nameSingleCode, $nameListCode): string
	{
		$allow = [];
		// set component name
		$component = $this->config->component_code_name;
		// check if the item has permissions for edit.
		$allow[] = PHP_EOL . Indent::_(2)
			. "\$this->canEdit = \$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.edit')
			. "');";
		// check if the item has permissions for edit state.
		$allow[] = Indent::_(2) . "\$this->canState = \$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.edit.state')
			. "');";
		// check if the item has permissions for create.
		$allow[] = Indent::_(2) . "\$this->canCreate = \$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.create') . "');";
		// check if the item has permissions for delete.
		$allow[] = Indent::_(2) . "\$this->canDelete = \$this->canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.delete') . "');";
		// check if the item has permissions for batch.
		if ($this->permission->globalExist($nameSingleCode, 'core.batch'))
		{
			$allow[] = Indent::_(2) . "\$this->canBatch = (\$this->canDo->get('"
				. $this->permission->getGlobal($nameSingleCode, 'core.batch')
				. "') && \$this->canDo->get('core.batch'));";
		}
		else
		{
			$allow[] = Indent::_(2)
				. "\$this->canBatch = \$this->canDo->get('core.batch');";
		}

		return implode(PHP_EOL, $allow);
	}
}

