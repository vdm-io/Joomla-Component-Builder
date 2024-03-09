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


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Access Sections Joomla Fields Creator Class
 * 
 * @since 3.2.0
 */
final class AccessSectionsJoomlaFields
{
	/**
	 * Set Access Sections Joomla Fields
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function get(): string
	{
		$component = '';
		// set all the core field permissions
		$component .= PHP_EOL . Indent::_(1) . '<section name="fieldgroup">';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.create" title="JACTION_CREATE" description="COM_FIELDS_GROUP_PERMISSION_CREATE_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.delete" title="JACTION_DELETE" description="COM_FIELDS_GROUP_PERMISSION_DELETE_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit" title="JACTION_EDIT" description="COM_FIELDS_GROUP_PERMISSION_EDIT_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_FIELDS_GROUP_PERMISSION_EDITSTATE_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit.own" title="JACTION_EDITOWN" description="COM_FIELDS_GROUP_PERMISSION_EDITOWN_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit.value" title="JACTION_EDITVALUE" description="COM_FIELDS_GROUP_PERMISSION_EDITVALUE_DESC" />';
		$component .= PHP_EOL . Indent::_(1) . '</section>';
		$component .= PHP_EOL . Indent::_(1) . '<section name="field">';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.delete" title="JACTION_DELETE" description="COM_FIELDS_FIELD_PERMISSION_DELETE_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit" title="JACTION_EDIT" description="COM_FIELDS_FIELD_PERMISSION_EDIT_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_FIELDS_FIELD_PERMISSION_EDITSTATE_DESC" />';
		$component .= PHP_EOL . Indent::_(2)
			. '<action name="core.edit.value" title="JACTION_EDITVALUE" description="COM_FIELDS_FIELD_PERMISSION_EDITVALUE_DESC" />';
		$component .= PHP_EOL . Indent::_(1) . '</section>';

		return $component;
	}
}

