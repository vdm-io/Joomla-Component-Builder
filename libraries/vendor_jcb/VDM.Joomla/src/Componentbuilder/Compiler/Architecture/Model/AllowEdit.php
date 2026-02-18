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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryOtherName;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\AllowEditInterface;


/**
 * Model Allow Edit Class
 * 
 * @since 5.1.4
 */
class AllowEdit implements AllowEditInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.4
	 */
	protected Config $config;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 5.1.4
	 */
	protected Permission $permission;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 5.1.4
	 */
	protected Dispenser $dispenser;

	/**
	 * The Category Class.
	 *
	 * @var   Category
	 * @since 5.1.4
	 */
	protected Category $category;

	/**
	 * The CategoryOtherName Class.
	 *
	 * @var   CategoryOtherName
	 * @since 5.1.4
	 */
	protected CategoryOtherName $categoryothername;

	/**
	 * Constructor.
	 *
	 * @param Config              $config              The Config Class.
	 * @param Permission          $permission          The Permission Class.
	 * @param Dispenser           $dispenser           The Dispenser Class.
	 * @param Category            $category            The Category Class.
	 * @param CategoryOtherName   $categoryothername   The CategoryOtherName Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, Permission $permission,
		Dispenser $dispenser, Category $category,
		CategoryOtherName $categoryothername)
	{
		$this->config = $config;
		$this->permission = $permission;
		$this->dispenser = $dispenser;
		$this->category = $category;
		$this->categoryothername = $categoryothername;
	}

	/**
	 * Get Allow Edit Function Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 * @param string   $nameListCode  The list code name of the view.
	 *
	 * @since   5.1.4
	 * @return  string   The can edit state method code
	 */
	public function get(string $nameSingleCode, string $nameListCode): string
	{
		$allow = [];
		$component = $this->config->component_code_name;

		// prepare custom permission script
		$customAllow = $this->dispenser->get(
			'php_allowedit', $nameSingleCode
		);

		if ($this->category->exists("{$nameListCode}"))
		{
			// check if category has another name
			$otherViews = $this->categoryothername->
				get($nameListCode . '.views', $nameListCode);
			$otherView  = $this->categoryothername->
				get($nameListCode . '.view', $nameSingleCode);
			// setup the category script
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get user object.";
			$allow[] = Indent::_(2) . "\$user = \$this->getCurrentUser();";
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get record id.";
			$allow[] = Indent::_(2)
				. "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($this->permission->globalExist($otherView, 'core.access'))
			{
				$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Access check.";
				$allow[] = Indent::_(2) . "\$access = (\$user->authorise('"
					. $this->permission->getGlobal($otherView, 'core.access')
					. "', 'com_" . $component . "." . $otherView
					. ".' . (int) \$recordId) && \$user->authorise('"
					. $this->permission->getGlobal($otherView, 'core.access')
					. "', 'com_" . $component . "'));";
				$allow[] = Indent::_(2) . "if (!\$access)";
				$allow[] = Indent::_(2) . "{";
				$allow[] = Indent::_(3) . "return false;";
				$allow[] = Indent::_(2) . "}";
			}
			$allow[] = PHP_EOL . Indent::_(2) . "if (\$recordId)";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " The record has been set. Check the record permissions.";
			// check if the item has permissions.
			$allow[] = Indent::_(3) . "\$permission = \$user->authorise('"
				. $this->permission->getAction($otherView, 'core.edit') . "', 'com_" . $component . "."
				. $otherView . ".' . (int) \$recordId);";
			$allow[] = Indent::_(3) . "if (!\$permission)";
			$allow[] = Indent::_(3) . "{";
			// check if the item has permissions.
			$allow[] = Indent::_(4) . "if (\$user->authorise('"
				. $this->permission->getAction($otherView, 'core.edit.own') . "', 'com_" . $component . "."
				. $otherView . ".' . \$recordId))";
			$allow[] = Indent::_(4) . "{";
			$allow[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " Fallback on edit.own. Now test the owner is the user.";
			$allow[] = Indent::_(5)
				. "\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = Indent::_(5) . "if (empty(\$ownerId))";
			$allow[] = Indent::_(5) . "{";
			$allow[] = Indent::_(6) . "return false;";
			$allow[] = Indent::_(5) . "}";
			$allow[] = PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " If the owner matches 'me' then do the test.";
			$allow[] = Indent::_(5) . "if (\$ownerId == \$user->id)";
			$allow[] = Indent::_(5) . "{";
			// check if the item has permissions.
			$allow[] = Indent::_(6) . "if (\$user->authorise('"
				. $this->permission->getGlobal($otherView, 'core.edit.own') . "', \$this->option))";
			$allow[] = Indent::_(6) . "{";
			$allow[] = Indent::_(7) . "return true;";
			$allow[] = Indent::_(6) . "}";
			$allow[] = Indent::_(5) . "}";
			$allow[] = Indent::_(4) . "}";
			$allow[] = Indent::_(4) . "return false;";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(2) . "}";
			if ($this->permission->globalExist($otherView, 'core.edit'))
			{
				$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Since there is no permission, revert to the component permissions.";
				$allow[] = Indent::_(2) . "return \$user->authorise('"
					. $this->permission->getGlobal($otherView, 'core.edit') . "', \$this->option);";
			}
			else
			{
				$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Since there is no permission given, core edit must be checked.";
				$allow[] = Indent::_(2)
					. "return \$user->authorise('core.edit', \$this->option);";
			}
		}
		else
		{
			// setup the category script
			$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get user object.";
			$allow[] = Indent::_(2) . "\$user = \$this->getCurrentUser();";
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get record id.";
			$allow[] = Indent::_(2)
				. "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($this->permission->actionExist($nameSingleCode, 'core.access'))
			{
				$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Access check.";
				$allow[] = Indent::_(2) . "\$access = (\$user->authorise('"
					. $this->permission->getAction($nameSingleCode, 'core.access') . "', 'com_" . $component . "."
					. $nameSingleCode
					. ".' . (int) \$recordId) && \$user->authorise('"
					. $this->permission->getAction($nameSingleCode, 'core.access') . "', 'com_" . $component . "'));";
				$allow[] = Indent::_(2) . "if (!\$access)";
				$allow[] = Indent::_(2) . "{";
				$allow[] = Indent::_(3) . "return false;";
				$allow[] = Indent::_(2) . "}";
			}
			$allow[] = PHP_EOL . Indent::_(2) . "if (\$recordId)";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " The record has been set. Check the record permissions.";
			// check if the item has permissions.
			$allow[] = Indent::_(3) . "\$permission = \$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit') . "', 'com_" . $component . "."
				. $nameSingleCode . ".' . (int) \$recordId);";
			$allow[] = Indent::_(3) . "if (!\$permission)";
			$allow[] = Indent::_(3) . "{";
			// check if the item has permissions.
			$allow[] = Indent::_(4) . "if (\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.own') . "', 'com_" . $component . "."
				. $nameSingleCode . ".' . \$recordId))";
			$allow[] = Indent::_(4) . "{";
			$allow[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " Now test the owner is the user.";
			$allow[] = Indent::_(5)
				. "\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = Indent::_(5) . "if (empty(\$ownerId))";
			$allow[] = Indent::_(5) . "{";
			$allow[] = Indent::_(6) . "return false;";
			$allow[] = Indent::_(5) . "}";
			$allow[] = PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " If the owner matches 'me' then allow.";
			$allow[] = Indent::_(5) . "if (\$ownerId == \$user->id)";
			$allow[] = Indent::_(5) . "{";
			// check if the item has permissions.
			$allow[] = Indent::_(6) . "if (\$user->authorise('"
				. $this->permission->getGlobal($nameSingleCode, 'core.edit.own') . "', 'com_" . $component . "'))";
			$allow[] = Indent::_(6) . "{";
			$allow[] = Indent::_(7) . "return true;";
			$allow[] = Indent::_(6) . "}";
			$allow[] = Indent::_(5) . "}";
			$allow[] = Indent::_(4) . "}";
			$allow[] = Indent::_(4) . "return false;";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(2) . "}";
			if ($this->permission->globalExist($nameSingleCode, 'core.edit'))
			{
				$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Since there is no permission, revert to the component permissions.";
				$allow[] = Indent::_(2) . "return \$user->authorise('"
					. $this->permission->getGlobal($nameSingleCode, 'core.edit') . "', \$this->option);";
			}
			else
			{
				$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Since there is no permission given, core edit must be checked.";
				$allow[] = Indent::_(2)
					. "return \$user->authorise('core.edit', \$this->option);";
			}
		}

		return implode(PHP_EOL, $allow);
	}
}

