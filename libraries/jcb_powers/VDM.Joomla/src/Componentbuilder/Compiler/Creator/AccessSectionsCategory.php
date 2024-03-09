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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Access Sections Category Creator Class
 * 
 * @since 3.2.0
 */
final class AccessSectionsCategory
{
	/**
	 * The CategoryCode Class.
	 *
	 * @var   CategoryCode
	 * @since 3.2.0
	 */
	protected CategoryCode $categorycode;

	/**
	 * Constructor.
	 *
	 * @param CategoryCode   $categorycode   The CategoryCode Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(CategoryCode $categorycode)
	{
		$this->categorycode = $categorycode;
	}

	/**
	 * Get Access Sections Category
	 *
	 * @param string $nameSingleCode
	 * @param string $nameListCode
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function get(string $nameSingleCode, string $nameListCode): string
	{
		$component = '';
		// check if view has category
		$otherViews = $this->categorycode->getString("{$nameSingleCode}.views");
		if ($otherViews !== null && $otherViews == $nameListCode)
		{
			$component .= PHP_EOL . Indent::_(1)
				. '<section name="category.' . $otherViews . '">';
			$component .= PHP_EOL . Indent::_(2)
				. '<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
			$component .= PHP_EOL . Indent::_(2)
				. '<action name="core.delete" title="JACTION_DELETE" description="COM_CATEGORIES_ACCESS_DELETE_DESC" />';
			$component .= PHP_EOL . Indent::_(2)
				. '<action name="core.edit" title="JACTION_EDIT" description="COM_CATEGORIES_ACCESS_EDIT_DESC" />';
			$component .= PHP_EOL . Indent::_(2)
				. '<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_CATEGORIES_ACCESS_EDITSTATE_DESC" />';
			$component .= PHP_EOL . Indent::_(2)
				. '<action name="core.edit.own" title="JACTION_EDITOWN" description="COM_CATEGORIES_ACCESS_EDITOWN_DESC" />';
			$component .= PHP_EOL . Indent::_(1) . "</section>";
		}

		return $component;
	}
}

