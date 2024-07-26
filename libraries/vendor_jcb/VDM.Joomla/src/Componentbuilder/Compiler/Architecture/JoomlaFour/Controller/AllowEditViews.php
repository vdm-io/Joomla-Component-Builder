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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryOtherName;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowEditViewsInterface;


/**
 * Controller Allow Edit Views Class for Joomla 4
 * 
 * @since 5.0.2
 */
final class AllowEditViews implements AllowEditViewsInterface
{
	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 5.0.2
	 */
	protected Permission $permission;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 5.0.2
	 */
	protected Dispenser $dispenser;

	/**
	 * The Category Class.
	 *
	 * @var   Category
	 * @since 5.0.2
	 */
	protected Category $category;

	/**
	 * The CategoryOtherName Class.
	 *
	 * @var   CategoryOtherName
	 * @since 5.0.2
	 */
	protected CategoryOtherName $categoryothername;

	/**
	 * Constructor.
	 *
	 * @param Permission          $permission          The Permission Class.
	 * @param Dispenser           $dispenser           The Dispenser Class.
	 * @param Category            $category            The Category Class.
	 * @param CategoryOtherName   $categoryothername   The CategoryOtherName Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Permission $permission,
		Dispenser $dispenser, Category $category,
		CategoryOtherName $categoryothername)
	{
		$this->permission = $permission;
		$this->dispenser = $dispenser;
		$this->category = $category;
		$this->categoryothername = $categoryothername;
	}

	/**
	 * Get Array Code
	 *
	 * @param array   $views
	 *
	 * @since 5.0.2
	 * @return  string   The array of Code (string)
	 */
	public function getArray(array $views): string
	{
		$allow = [];
		foreach ($views as $nameSingleCode => $nameListCode)
		{
			$allow[] = $this->getViewArray($nameSingleCode, $nameListCode);
		}

		if ($allow === [])
		{
			return '';
		}

		return PHP_EOL . Indent::_(2) . implode("," . PHP_EOL . Indent::_(2), $allow);
	}

	/**
	 * Get Custom Function Code
	 *
	 * @param array   $views
	 *
	 * @since 5.0.2
	 * @return  string   The functions of Code (string)
	 */
	public function getFunctions(array $views): string
	{
		$allow = [];
		foreach ($views as $nameSingleCode => $nameListCode)
		{
			if (($function = $this->getViewFunction($nameSingleCode, $nameListCode)) !== null)
			{
				$allow[] = $function;
			}
		}

		if ($allow === [])
		{
			return '';
		}

		return PHP_EOL . PHP_EOL . implode(PHP_EOL . PHP_EOL, $allow);
	}

	/**
	 * Get View Permissions Array Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 * @param string   $nameListCode    The list code name of the view.
	 *
	 * @since 3.2.0
	 * @return  string   The allow edit method code
	 */
	protected function getViewArray(string $nameSingleCode, string $nameListCode): string
	{
		$allow = [];

		// prepare custom permission script
		$customAllow = $this->dispenser->get(
			'php_allowedit', $nameSingleCode
		);

		if ($customAllow !== '')
		{
			$allow[] = Indent::_(3) . "'function' => 'allowEdit_{$nameSingleCode}'";
		}

		if ($this->category->exists("{$nameListCode}"))
		{
			// check if category has another name
			$otherView  = $this->categoryothername->
				get($nameListCode . '.view', $nameSingleCode);

			// check if the item has permissions.
			if ($this->permission->globalExist($otherView, 'core.access'))
			{
				$access = $this->permission->getGlobal($otherView, 'core.access');
				$allow[] = Indent::_(3) . "'access' => '{$access}'";
			}
			$edit = $this->permission->getAction($otherView, 'core.edit');
			$allow[] = Indent::_(3) . "'edit' => '{$edit}'";

			$edit_own = $this->permission->getAction($otherView, 'core.edit.own');
			$allow[] = Indent::_(3) . "'edit.own' => '{$edit_own}'";
		}
		else
		{
			// check if the item has permissions.
			if ($this->permission->actionExist($nameSingleCode, 'core.access'))
			{
				$access = $this->permission->getAction($nameSingleCode, 'core.access');
				$allow[] = Indent::_(3) . "'access' => '{$access}'";
			}
			$edit = $this->permission->getAction($nameSingleCode, 'core.edit');
			$allow[] = Indent::_(3) . "'edit' => '{$edit}'";

			$edit_own = $this->permission->getAction($nameSingleCode, 'core.edit.own');
			$allow[] = Indent::_(3) . "'edit.own' => '{$edit_own}'";
		}

		return "'{$nameSingleCode}' => [" . PHP_EOL . implode(',' . PHP_EOL, $allow) . PHP_EOL . Indent::_(2) . ']';
	}

	/**
	 * Get View Permissions Function Code
	 *
	 * @param string   $nameSingleCode  The single code name of the view.
	 * @param string   $nameListCode    The list code name of the view.
	 *
	 * @since 3.2.0
	 * @return  string|null   The allow edit method code
	 */
	protected function getViewFunction(string $nameSingleCode, string $nameListCode): ?string
	{
		$allow = [];

		// prepare custom permission script
		$customAllow = $this->dispenser->get(
			'php_allowedit', $nameSingleCode
		);

		if ($customAllow !== '')
		{
			// setup the function
			$allow[] = Indent::_(1) . '/**';
			$allow[] = Indent::_(1) . " * Method to check if you can edit an existing {$nameSingleCode} record.";
			$allow[] = Indent::_(1) . ' *';
			$allow[] = Indent::_(1) . ' * @param   array   $data  An array of input data.';
			$allow[] = Indent::_(1) . ' * @param   string  $key   The name of the key for the primary key.';
			$allow[] = Indent::_(1) . ' *';
			$allow[] = Indent::_(1) . ' * @return  boolean';
			$allow[] = Indent::_(1) . ' *';
			$allow[] = Indent::_(1) . ' * @since   5.0.2';
			$allow[] = Indent::_(1) . ' */';
			$allow[] = Indent::_(1) . "protected function allowEdit_{$nameSingleCode}(\$data = [], \$key = 'id')";
			$allow[] = Indent::_(1) . '{';
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get user object.";
			$allow[] = Indent::_(2) . "\$user = \$this->identity;";
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get record id.";
			$allow[] = Indent::_(2)
				. "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = Indent::_(1) . '}';

			return implode(PHP_EOL, $allow);
		}

		return null;
	}
}

