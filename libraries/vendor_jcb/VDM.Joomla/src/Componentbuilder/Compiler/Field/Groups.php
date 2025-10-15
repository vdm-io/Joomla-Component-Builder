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

namespace VDM\Joomla\Componentbuilder\Compiler\Field;


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Compiler Field Groups
 * 
 * @since 3.2.0
 */
final class Groups
{
	/**
	 * Field Grouping https://docs.joomla.org/Form_field
	 *
	 * @var    array
	 * @since  3.2.0
	 **/
	protected array $groups = [
		'default' => [
			'accesslevel', 'cachehandler', 'calendar', 'captcha', 'category', 'checkbox', 'checkboxes', 'chromestyle',
			'color', 'combo', 'componentlayout', 'contentlanguage', 'contenttype', 'databaseconnection', 'components',
			'editor', 'editors', 'email', 'file', 'file', 'filelist', 'folderlist', 'groupedlist', 'headertag', 'helpsite', 'hidden', 'imagelist',
			'integer', 'language', 'list', 'media', 'menu', 'modal_menu', 'menuitem', 'meter', 'modulelayout', 'moduleorder', 'moduleposition',
			'moduletag', 'note', 'number', 'password', 'plugins', 'predefinedlist', 'radio', 'range', 'repeatable', 'rules', 'usergrouplist',
			'sessionhandler', 'spacer', 'sql', 'subform', 'tag', 'tel', 'templatestyle', 'text', 'textarea', 'timezone', 'url', 'user', 'usergroup'
		],
		'plain' => [
			'cachehandler', 'calendar', 'checkbox', 'chromestyle', 'color', 'componentlayout', 'contenttype', 'editor', 'editors', 'captcha',
			'email', 'file', 'headertag', 'helpsite', 'hidden', 'integer', 'language', 'media', 'menu', 'modal_menu', 'menuitem', 'meter', 'modulelayout', 'templatestyle',
			'moduleorder', 'moduletag', 'number', 'password', 'range', 'rules', 'tag', 'tel', 'text', 'textarea', 'timezone', 'url', 'user', 'usergroup' , 'usergrouplist'
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
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * Constructor
	 *
	 * @since 3.2.0
	 */
	public function __construct(DatabaseInterface $db)
	{
		$this->db = $db;
	}

	/**
	 * Field Checker
	 *
	 * @param   string   $type The field type
	 * @param   string   $option The field grouping
	 *
	 * @return  bool    if the field was found
	 * @since   3.2.0
	 */
	public function check(string $type, string $option = 'default'): bool
	{
		// now check
		if (isset($this->groups[$option]) && in_array($type, $this->groups[$option]))
		{
			return true;
		}
		return false;
	}

	/**
	 * get the field types $key -> name of a group or groups
	 *
	 * @param   array   $groups  The groups
	 * @param   string  $key     The return key
	 *
	 * @return  array|null  ids of the field types
	 * @since   3.2.0
	 * @since   5.0.4 (add $key arg)
	 */
	public function types(array $groups = [], $key = 'id'): ?array
	{
		// make sure we have a group
		if (($ids = $this->typesIds($groups)) !== null)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->select($this->db->quoteName([$key, 'name']));
			$query->from($this->db->quoteName('#__componentbuilder_fieldtype'));
			$query->where($this->db->quoteName('published') . ' = 1');
			$query->where($this->db->quoteName('id') . ' IN (' . implode(',', $ids) . ')');

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();

			if ($this->db->getNumRows())
			{
				return $this->db->loadAssocList($key, 'name');
			}
		}

		return null;
	}

	/**
	 * get the field types IDs of a group or groups
	 *
	 * @param   array   $groups  The groups
	 *
	 * @return  array|null  ids of the spacer field types
	 * @since   3.2.0
	 */
	public function typesIds(array $groups = []): ?array
	{
		// make sure we have a group
		if (ArrayHelper::check($groups))
		{
			$merge_groups = [];
			foreach ($groups as $group)
			{
				if (isset($this->groups[$group]))
				{
					$merge_groups[] = $this->groups[$group];
				}
			}

			// make sure we have these types of groups
			if (ArrayHelper::check($merge_groups))
			{
				// get the database object to use quote
				return GetHelper::vars(
					'fieldtype',
					(array) array_map(function($name) {
						return $this->db->quote(ucfirst($name));
					}, ArrayHelper::merge($merge_groups)),
					'name',
					'id'
				);
			}
		}

		return null;
	}

	/**
	 * get the spacer IDs
	 *
	 * @return  array|null  ids of the spacer field types
	 * @since   3.2.0
	 */
	public function spacerIds(): ?array
	{
		return $this->typesIds(['spacer']);
	}

	/**
	 * get the field types Guid's of a group or groups
	 *
	 * @param   array   $groups  The groups
	 *
	 * @return  array|null  Guid of the field types
	 * @since   5.0.4
	 */
	public function typesGuids(array $groups = []): ?array
	{
		// make sure we have a group
		if (ArrayHelper::check($groups))
		{
			$merge_groups = [];
			foreach ($groups as $group)
			{
				if (isset($this->groups[$group]))
				{
					$merge_groups[] = $this->groups[$group];
				}
			}

			// make sure we have these types of groups
			if (ArrayHelper::check($merge_groups))
			{
				// get the database object to use quote
				return GetHelper::vars(
					'fieldtype',
					(array) array_map(function($name) {
						return $this->db->quote(ucfirst($name));
					}, ArrayHelper::merge($merge_groups)),
					'name',
					'guid'
				);
			}
		}

		return null;
	}

	/**
	 * get the spacer Guid's
	 *
	 * @return  array|null  guid of the spacer field types
	 * @since   5.0.4
	 */
	public function spacerGuids(): ?array
	{
		return $this->typesGuids(['spacer']);
	}
}

