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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


/**
 * The Field Helper
 * 
 * @since 3.2.0
 */
abstract class FieldHelper
{
	/**
	 * Field Grouping https://docs.joomla.org/Form_field
	 **/
	protected static $fields = [
		'default' => [
			'accesslevel', 'cachehandler', 'calendar', 'captcha', 'category', 'checkbox', 'checkboxes', 'chromestyle',
			'color', 'combo', 'componentlayout', 'contentlanguage', 'contenttype', 'databaseconnection', 'components',
			'editor', 'editors', 'email', 'file', 'file', 'filelist', 'folderlist', 'groupedlist', 'headertag', 'helpsite', 'hidden', 'imagelist',
			'integer', 'language', 'list', 'media', 'menu', 'modal_menu', 'menuitem', 'meter', 'modulelayout', 'moduleorder', 'moduleposition',
			'moduletag', 'note', 'number', 'password', 'plugins', 'predefinedlist', 'radio', 'range', 'repeatable', 'rules',
			'sessionhandler', 'spacer', 'sql', 'subform', 'tag', 'tel', 'templatestyle', 'text', 'textarea', 'timezone', 'url', 'user', 'usergroup'
		],
		'plain' => [
			'cachehandler', 'calendar', 'checkbox', 'chromestyle', 'color', 'componentlayout', 'contenttype', 'editor', 'editors', 'captcha',
			'email', 'file', 'headertag', 'helpsite', 'hidden', 'integer', 'language', 'media', 'menu', 'modal_menu', 'menuitem', 'meter', 'modulelayout', 'templatestyle',
			'moduleorder', 'moduletag', 'number', 'password', 'range', 'rules', 'tag', 'tel', 'text', 'textarea', 'timezone', 'url', 'user', 'usergroup'
		],
		'option' => [
			'accesslevel', 'category', 'checkboxes', 'combo', 'contentlanguage', 'databaseconnection', 'components',
			'filelist', 'folderlist', 'imagelist', 'list', 'plugins', 'predefinedlist', 'radio', 'sessionhandler', 'sql', 'groupedlist'
		],
		'text' => [
			'calendar', 'color', 'editor', 'email', 'number', 'password', 'range', 'tel', 'text', 'textarea', 'url'
		],
		'list' => [
			'checkbox', 'checkboxes', 'list', 'radio', 'groupedlist', 'combo'
		],
		'dynamic' => [
			'category', 'file', 'filelist', 'folderlist', 'headertag', 'imagelist', 'integer', 'media', 'meter', 'rules', 'tag', 'timezone', 'user'
		],
		'spacer' => [
			'note', 'spacer'
		],
		'special' => [
			'contentlanguage', 'moduleposition', 'plugin', 'repeatable', 'subform'
		],
		'search' => [
			'editor', 'email', 'tel', 'text', 'textarea', 'url', 'subform'
		]
	];

	/**
	 * Field Checker
	 *
	 * @param   string   $type The field type
	 * @param   string  $option The field grouping
	 *
	 * @return  bool if the field was found
	 */
	public static function check(string $type, string $option = 'default'): bool
	{
		// now check
		if (isset(self::$fields[$option]) &&
			in_array($type, self::$fields[$option]))
		{
			return true;
		}
		return false;
	}

}

