<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

###POWER_AUTOLOADER###

###ADMIN_HELPER_CLASS_HEADER###

/**
 * ###Component### component helper.
 */
abstract class ###Component###Helper
{
	/**
	 * Composer Switch
	 *
	 * @var      array
	 */
	protected static $composer = [];

	/**
	 * The Main Active Language
	 *
	 * @var      string
	 */
	public static $langTag;###ADMIN_GLOBAL_EVENT_HELPER######CUSTOM_HELPER_SCRIPT######BOTH_CUSTOM_HELPER_SCRIPT###

	/**
	 * Load the Composer Vendors
	 */
	public static function composerAutoload($target)
	{
		// insure we load the composer vendor only once
		if (!isset(self::$composer[$target]))
		{
			// get the function name
			$functionName = Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe('compose' . $target);
			// check if method exist
			if (method_exists(__CLASS__, $functionName))
			{
				return self::{$functionName}();
			}
			return false;
		}
		return self::$composer[$target];
	}

	/**
	 * Load the Component xml manifest.
	 */
	public static function manifest()
	{
		$manifestUrl = JPATH_ADMINISTRATOR."/components/com_###component###/###component###.xml";
		return simplexml_load_file($manifestUrl);
	}

	/**
	 * Joomla version object
	 */
	protected static $JVersion;

	/**
	 * set/get Joomla version
	 */
	public static function jVersion()
	{
		// check if set
		if (!Super___91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(self::$JVersion))
		{
			self::$JVersion = new Version();
		}
		return self::$JVersion;
	}

	/**
	 * Load the Contributors details.
	 */
	public static function getContributors()
	{
		// get params
		$params    = ComponentHelper::getParams('com_###component###');
		// start contributors array
		$contributors = [];
		// get all Contributors (max 20)
		$searchArray = range('0','20');
		foreach($searchArray as $nr)
		{
			if ((NULL !== $params->get("showContributor".$nr)) && ($params->get("showContributor".$nr) == 1 || $params->get("showContributor".$nr) == 3))
			{
				// set link based of selected option
				if($params->get("useContributor".$nr) == 1)
				{
					$link_front = '<a href="mailto:'.$params->get("emailContributor".$nr).'" target="_blank">';
					$link_back = '</a>';
				}
				elseif($params->get("useContributor".$nr) == 2)
				{
					$link_front = '<a href="'.$params->get("linkContributor".$nr).'" target="_blank">';
					$link_back = '</a>';
				}
				else
				{
					$link_front = '';
					$link_back = '';
				}
				$contributors[$nr]['title']   = Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($params->get("titleContributor".$nr));
				$contributors[$nr]['name']    = $link_front.Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($params->get("nameContributor".$nr)).$link_back;
			}
		}
		return $contributors;
	}###HELP###

	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu)
	{
		// load user for access menus
		$user = Factory::getUser();
		// load the submenus to sidebar
		###SUBMENU###
	}###HELPER_CREATEUSER######HELPER_UIKIT######HELPER_EXEL###

	/**
	 * Get a Variable
	 *
	 * @param   string   $table        The table from which to get the variable
	 * @param   string   $where        The value where
	 * @param   string   $whereString  The target/field string where/name
	 * @param   string   $what         The return field
	 * @param   string   $operator     The operator between $whereString/field and $where/value
	 * @param   string   $main         The component in which the table is found
	 *
	 * @return  mix string/int/float
	 * @deprecated 3.3 Use Super___db87c339_5bb6_4291_a7ef_2c48ea1b06bc___Power::var(...);
	 */
	public static function getVar($table, $where = null, $whereString = 'user', $what = 'id', $operator = '=', $main = '###component###')
	{
		return Super___db87c339_5bb6_4291_a7ef_2c48ea1b06bc___Power::var(
			$table,
			$where,
			$whereString,
			$what,
			$operator,
			$main
		);
	}

	/**
	 * Get array of variables
	 *
	 * @param   string   $table        The table from which to get the variables
	 * @param   string   $where        The value where
	 * @param   string   $whereString  The target/field string where/name
	 * @param   string   $what         The return field
	 * @param   string   $operator     The operator between $whereString/field and $where/value
	 * @param   string   $main         The component in which the table is found
	 * @param   bool     $unique       The switch to return a unique array
	 *
	 * @return  array
	 * @deprecated 3.3 Use Super___db87c339_5bb6_4291_a7ef_2c48ea1b06bc___Power::vars(...);
	 */
	public static function getVars($table, $where = null, $whereString = 'user', $what = 'id', $operator = 'IN', $main = '###component###', $unique = true)
	{
		return Super___db87c339_5bb6_4291_a7ef_2c48ea1b06bc___Power::vars(
			$table,
			$where,
			$whereString,
			$what,
			$operator,
			$main,
			$unique
		);
	}

	/**
	 * Convert a json object to a string
	 *
	 * @input    string  $value  The json string to convert
	 *
	 * @returns a string
	 * @deprecated 3.3 Use Super___4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(...);
	 */
	public static function jsonToString($value, $sperator = ", ", $table = null, $id = 'id', $name = 'name')
	{
		return Super___4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(
			$value,
			$sperator,
			$table,
			$id,
			$name
		);
	}

	public static function isPublished($id,$type)
	{
		if ($type == 'raw')
		{
			$type = 'item';
		}
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.published'));
		$query->from('#__###component###_'.$type.' AS a');
		$query->where('a.id = '. (int) $id);
		$query->where('a.published = 1');
		$db->setQuery($query);
		$db->execute();
		$found = $db->getNumRows();
		if($found)
		{
			return true;
		}
		return false;
	}

	public static function getGroupName($id)
	{
		$db = Factory::getDBO();
		$query = $db->getQuery(true);
		$query->select(array('a.title'));
		$query->from('#__usergroups AS a');
		$query->where('a.id = '. (int) $id);
		$db->setQuery($query);
		$db->execute();
		$found = $db->getNumRows();
		if($found)
		  {
			return $db->loadResult();
		}
		return $id;
	}

	/**
	 * Get the action permissions
	 *
	 * @param  string   $view        The related view name
	 * @param  int      $record      The item to act upon
	 * @param  string   $views       The related list view name
	 * @param  mixed    $target      Only get this permission (like edit, create, delete)
	 * @param  string   $component   The target component
	 * @param  object   $user        The user whose permissions we are loading
	 *
	 * @return  object   The CMSObject of permission/authorised actions
	 *
	 */
	public static function getActions($view, &$record = null, $views = null, $target = null, $component = '###component###', $user = 'null')
	{
		// load the user if not given
		if (!Super___91004529_94a9_4590_b842_e7c6b624ecf5___Power::check($user))
		{
			// get the user object
			$user = Factory::getUser();
		}
		// load the CMSObject
		$result = new CMSObject;
		// make view name safe (just incase)
		$view = Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($view);
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($views))
		{
			$views = Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($views);
		 }
		// get all actions from component
		$actions = Access::getActionsFromFile(
			JPATH_ADMINISTRATOR . '/components/com_' . $component . '/access.xml',
			"/access/section[@name='component']/"
		);
		// if non found then return empty CMSObject
		if (empty($actions))
		{
			return $result;
		}
		// get created by if not found
		if (Super___91004529_94a9_4590_b842_e7c6b624ecf5___Power::check($record) && !isset($record->created_by) && isset($record->id))
		{
			$record->created_by = Super___db87c339_5bb6_4291_a7ef_2c48ea1b06bc___Power::var($view, $record->id, 'id', 'created_by', '=', $component);
		}
		// set actions only set in component settings
		$componentActions = array('core.admin', 'core.manage', 'core.options', 'core.export');
		// check if we have a target
		$checkTarget = false;
		if ($target)
		{
			// convert to an array
			if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($target))
			{
				$target = array($target);
			}
			// check if we are good to go
			if (Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($target))
			{
				$checkTarget = true;
			}
		}
		// loop the actions and set the permissions
		foreach ($actions as $action)
		{
			// check target action filter
			if ($checkTarget && self::filterActions($view, $action->name, $target))
			{
				continue;
			}
			// set to use component default
			$fallback = true;
			// reset permission per/action
			$permission = false;
			$catpermission = false;
			// set area
			$area = 'comp';
			// check if the record has an ID and the action is item related (not a component action)
			if (Super___91004529_94a9_4590_b842_e7c6b624ecf5___Power::check($record) && isset($record->id) && $record->id > 0 && !in_array($action->name, $componentActions) &&
				(strpos($action->name, 'core.') !== false || strpos($action->name, $view . '.') !== false))
			{
				// we are in item
				$area = 'item';
				// The record has been set. Check the record permissions.
				$permission = $user->authorise($action->name, 'com_' . $component . '.' . $view . '.' . (int) $record->id);
				// if no permission found, check edit own
				if (!$permission)
				{
					// With edit, if the created_by matches current user then dig deeper.
					if (($action->name === 'core.edit' || $action->name === $view . '.edit') && $record->created_by > 0 && ($record->created_by == $user->id))
					{
						// the correct target
						$coreCheck = (array) explode('.', $action->name);
						// check that we have both local and global access
						if ($user->authorise($coreCheck[0] . '.edit.own', 'com_' . $component . '.' . $view . '.' . (int) $record->id) &&
							$user->authorise($coreCheck[0]  . '.edit.own', 'com_' . $component))
						{
							// allow edit
							$result->set($action->name, true);
							// set not to use global default
							// because we already validated it
							$fallback = false;
						}
						else
						{
							// do not allow edit
							$result->set($action->name, false);
							$fallback = false;
						}
					}
				}
				elseif (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($views) && isset($record->catid) && $record->catid > 0)
				{
					// we are in item
					$area = 'category';
					// set the core check
					$coreCheck = explode('.', $action->name);
					$core = $coreCheck[0];
					// make sure we use the core. action check for the categories
					if (strpos($action->name, $view) !== false && strpos($action->name, 'core.') === false )
					{
						$coreCheck[0] = 'core';
						$categoryCheck = implode('.', $coreCheck);
					}
					else
					{
						$categoryCheck = $action->name;
					}
					// The record has a category. Check the category permissions.
					$catpermission = $user->authorise($categoryCheck, 'com_' . $component . '.' . $views . '.category.' . (int) $record->catid);
					if (!$catpermission && !is_null($catpermission))
					{
						// With edit, if the created_by matches current user then dig deeper.
						if (($action->name === 'core.edit' || $action->name === $view . '.edit') && $record->created_by > 0 && ($record->created_by == $user->id))
						{
							// check that we have both local and global access
							if ($user->authorise('core.edit.own', 'com_' . $component . '.' . $views . '.category.' . (int) $record->catid) &&
								$user->authorise($core . '.edit.own', 'com_' . $component))
							{
								// allow edit
								$result->set($action->name, true);
								// set not to use global default
								// because we already validated it
								$fallback = false;
							}
							else
							{
								// do not allow edit
								$result->set($action->name, false);
								$fallback = false;
							}
						}
					}
				}
			}
			// if allowed then fallback on component global settings
			if ($fallback)
			{
				// if item/category blocks access then don't fall back on global
				if ((($area === 'item') && !$permission) || (($area === 'category') && !$catpermission))
				{
					// do not allow
					$result->set($action->name, false);
				}
				// Finally remember the global settings have the final say. (even if item allow)
				// The local item permissions can block, but it can't open and override of global permissions.
				// Since items are created by users and global permissions is set by system admin.
				else
				{
					$result->set($action->name, $user->authorise($action->name, 'com_' . $component));
				}
			}
		}
		return $result;
	}

	/**
	 * Filter the action permissions
	 *
	 * @param  string   $action   The action to check
	 * @param  array    $targets  The array of target actions
	 *
	 * @return  boolean   true if action should be filtered out
	 *
	 */
	protected static function filterActions(&$view, &$action, &$targets)
	{
		foreach ($targets as $target)
		{
			if (strpos($action, $view . '.' . $target) !== false ||
				strpos($action, 'core.' . $target) !== false)
			{
				return false;
				break;
			}
		}
		return true;
	}

	/**
	 * Get any component's model
	 */
	public static function getModel($name, $path = JPATH_COMPONENT_ADMINISTRATOR, $Component = '###Component###', $config = [])
	{
		// fix the name
		$name = Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($name);
		// full path to models
		$fullPathModels = $path . '/models';
		// load the model file
		BaseDatabaseModel::addIncludePath($fullPathModels, $Component . 'Model');
		// make sure the table path is loaded
		if (!isset($config['table_path']) || !Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($config['table_path']))
		{
			// This is the JCB default path to tables in Joomla 3.x
			$config['table_path'] = JPATH_ADMINISTRATOR . '/components/com_' . strtolower($Component) . '/tables';
		}
		// get instance
		$model = BaseDatabaseModel::getInstance($name, $Component . 'Model', $config);
		// if model not found (strange)
		if ($model == false)
		{
			jimport('joomla.filesystem.file');
			// get file path
			$filePath = $path . '/' . $name . '.php';
			$fullPathModel = $fullPathModels . '/' . $name . '.php';
			// check if it exists
			if (File::exists($filePath))
			{
				// get the file
				require_once $filePath;
			}
			elseif (File::exists($fullPathModel))
			{
				// get the file
				require_once $fullPathModel;
			}
			// build class names
			$modelClass = $Component . 'Model' . $name;
			if (class_exists($modelClass))
			{
				// initialize the model
				return new $modelClass($config);
			}
		}
		return $model;
	}

	/**
	 * Add to asset Table
	 */
	public static function setAsset($id, $table, $inherit = true)
	{
		$parent = Table::getInstance('Asset');
		$parent->loadByName('com_###component###');

		$parentId = $parent->id;
		$name     = 'com_###component###.'.$table.'.'.$id;
		$title    = '';

		$asset = Table::getInstance('Asset');
		$asset->loadByName($name);

		// Check for an error.
		$error = $asset->getError();

		if ($error)
		{
			return false;
		}
		else
		{
			// Specify how a new or moved node asset is inserted into the tree.
			if ($asset->parent_id != $parentId)
			{
				$asset->setLocation($parentId, 'last-child');
			}

			// Prepare the asset to be stored.
			$asset->parent_id = $parentId;
			$asset->name      = $name;
			$asset->title     = $title;
			// get the default asset rules
			$rules = self::getDefaultAssetRules('com_###component###', $table, $inherit);
			if ($rules instanceof AccessRules)
			{
				$asset->rules = (string) $rules;
			}

			if (!$asset->check() || !$asset->store())
			{
				Factory::getApplication()->enqueueMessage($asset->getError(), 'warning');
				return false;
			}
			else
			{
				// Create an asset_id or heal one that is corrupted.
				$object = new stdClass();

				// Must be a valid primary key value.
				$object->id = $id;
				$object->asset_id = (int) $asset->id;

				// Update their asset_id to link to the asset table.
				return Factory::getDbo()->updateObject('#__###component###_'.$table, $object, 'id');
			}
		}
		return false;
	}

	/**
	 * Gets the default asset Rules for a component/view.
	 */
	protected static function getDefaultAssetRules($component, $view, $inherit = true)
	{
		// if new or inherited
		$assetId = 0;
		// Only get the actual item rules if not inheriting
		if (!$inherit)
		{
			// Need to find the asset id by the name of the component.
			$db = Factory::getDbo();
			$query = $db->getQuery(true)
				->select($db->quoteName('id'))
				->from($db->quoteName('#__assets'))
				->where($db->quoteName('name') . ' = ' . $db->quote($component));
			$db->setQuery($query);
			$db->execute();
			// check that there is a value
			if ($db->getNumRows())
			{
				// asset already set so use saved rules
				$assetId = (int) $db->loadResult();
			}
		}
		// get asset rules
		$result =  Access::getAssetRules($assetId);
		if ($result instanceof AccessRules)
		{
			$_result = (string) $result;
			$_result = json_decode($_result);
			foreach ($_result as $name => &$rule)
			{
				$v = explode('.', $name);
				if ($view !== $v[0])
				{
					// remove since it is not part of this view
					unset($_result->$name);
				}
				elseif ($inherit)
				{
					// clear the value since we inherit
					$rule = [];
				}
			}
			// check if there are any view values remaining
			if (count((array) $_result))
			{
				$_result = json_encode($_result);
				$_result = array($_result);
				// Instantiate and return the AccessRules object for the asset rules.
				$rules = new AccessRules($_result);
				// return filtered rules
				return $rules;
			}
		}
		return $result;
	}

	/**
	 * xmlAppend
	 *
	 * @param   SimpleXMLElement   $xml      The XML element reference in which to inject a comment
	 * @param   mixed              $node     A SimpleXMLElement node to append to the XML element reference, or a stdClass object containing a comment attribute to be injected before the XML node and a fieldXML attribute containing a SimpleXMLElement
	 *
	 * @return  void
	 * @deprecated 3.3 Use Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::append($xml, $node);
	 */
	public static function xmlAppend(&$xml, $node)
	{
		Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::append($xml, $node);
	}

	/**
	 * xmlComment
	 *
	 * @param   SimpleXMLElement   $xml        The XML element reference in which to inject a comment
	 * @param   string             $comment    The comment to inject
	 *
	 * @return  void
	 * @deprecated 3.3 Use Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::comment($xml, $comment);
	 */
	public static function xmlComment(&$xml, $comment)
	{
		Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::comment($xml, $comment);
	}

	/**
	 * xmlAddAttributes
	 *
	 * @param   SimpleXMLElement   $xml          The XML element reference in which to inject a comment
	 * @param   array              $attributes   The attributes to apply to the XML element
	 *
	 * @return  null
	 * @deprecated 3.3 Use Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::attributes($xml, $attributes);
	 */
	public static function xmlAddAttributes(&$xml, $attributes = [])
	{
		Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::attributes($xml, $attributes);
	}

	/**
	 * xmlAddOptions
	 *
	 * @param   SimpleXMLElement   $xml          The XML element reference in which to inject a comment
	 * @param   array              $options      The options to apply to the XML element
	 *
	 * @return  void
	 * @deprecated 3.3 Use Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::options($xml, $options);
	 */
	public static function xmlAddOptions(&$xml, $options = [])
	{
		Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::options($xml, $options);
	}

	/**
	 * get the field object
	 *
	 * @param   array      $attributes   The array of attributes
	 * @param   string     $default      The default of the field
	 * @param   array      $options      The options to apply to the XML element
	 *
	 * @return  object
	 * @deprecated 3.3 Use Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::field($attributes, $default, $options);
	 */
	public static function getFieldObject(&$attributes, $default = '', $options = null)
	{
		return Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::field($attributes, $default, $options);
	}

	/**
	 * get the field xml
	 *
	 * @param   array      $attributes   The array of attributes
	 * @param   array      $options      The options to apply to the XML element
	 *
	 * @return  object
	 * @deprecated 3.3 Use Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::xml($attributes, $options);
	 */
	public static function getFieldXML(&$attributes, $options = null)
	{
		return Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::xml($attributes, $options);
	}

	/**
	 * Render Bool Button
	 *
	 * @param   array   $args   All the args for the button
	 *                             0) name
	 *                             1) additional (options class) // not used at this time
	 *                             2) default
	 *                             3) yes (name)
	 *                             4) no (name)
	 *
	 * @return  string    The input html of the button
	 *
	 */
	public static function renderBoolButton()
	{
		$args = func_get_args();
		// check if there is additional button class
		$additional = isset($args[1]) ? (string) $args[1] : ''; // not used at this time
		// button attributes
		$buttonAttributes = array(
			'type' => 'radio',
			'name' => isset($args[0]) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($args[0]) : 'bool_button',
			'label' => isset($args[0]) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe(Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($args[0]), 'Ww') : 'Bool Button', // not seen anyway
			'class' => 'btn-group',
			'filter' => 'INT',
			'default' => isset($args[2]) ? (int) $args[2] : 0);
		// set the button options
		$buttonOptions = array(
			'1' => isset($args[3]) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($args[3]) : 'JYES',
			'0' => isset($args[4]) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($args[4]) : 'JNO');
		// return the input
		return Super___1198aecf_84c6_45d2_aea8_d531aa4afdfa___Power::field($buttonAttributes, $buttonAttributes['default'], $buttonOptions)->input;
	}

	/**
	 * Check if have an json string
	 *
	 * @input    string   The json string to check
	 *
	 * @returns bool true on success
	 * @deprecated 3.3 Use Super___4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check($string);
	 */
	public static function checkJson($string)
	{
		return Super___4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check($string);
	}

	/**
	 * Check if have an object with a length
	 *
	 * @input    object   The object to check
	 *
	 * @returns bool true on success
	 * @deprecated 3.3 Use Super___91004529_94a9_4590_b842_e7c6b624ecf5___Power::check($object);
	 */
	public static function checkObject($object)
	{
		return Super___91004529_94a9_4590_b842_e7c6b624ecf5___Power::check($object);
	}

	/**
	 * Check if have an array with a length
	 *
	 * @input    array   The array to check
	 *
	 * @returns bool/int  number of items in array on success
	 * @deprecated 3.3 Use Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($array, $removeEmptyString);
	 */
	public static function checkArray($array, $removeEmptyString = false)
	{
		return Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($array, $removeEmptyString);
	}

	/**
	 * Check if have a string with a length
	 *
	 * @input    string   The string to check
	 *
	 * @returns bool true on success
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($string);
	 */
	public static function checkString($string)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($string);
	}

	/**
	 * Check if we are connected
	 * Thanks https://stackoverflow.com/a/4860432/1429677
	 *
	 * @returns bool true on success
	 */
	public static function isConnected()
	{
		// If example.com is down, then probably the whole internet is down, since IANA maintains the domain. Right?
		$connected = @fsockopen("www.example.com", 80);
		// website, port  (try 80 or 443)
		if ($connected)
		{
			//action when connected
			$is_conn = true;
			fclose($connected);
		}
		else
		{
			//action in connection failure
			$is_conn = false;
		}
		return $is_conn;
	}

	/**
	 * Merge an array of array's
	 *
	 * @input    array   The arrays you would like to merge
	 *
	 * @returns array on success
	 * @deprecated 3.3 Use Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::merge($arrays);
	 */
	public static function mergeArrays($arrays)
	{
		return Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::merge($arrays);
	}

	// typo sorry!
	public static function sorten($string, $length = 40, $addTip = true)
	{
		return self::shorten($string, $length, $addTip);
	}

	/**
	 * Shorten a string
	 *
	 * @input    string   The you would like to shorten
	 *
	 * @returns string on success
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::shorten(...);
	 */
	public static function shorten($string, $length = 40, $addTip = true)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::shorten($string, $length, $addTip);
	}

	/**
	 * Making strings safe (various ways)
	 *
	 * @input    string   The you would like to make safe
	 *
	 * @returns string on success
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe(...);
	 */
	public static function safeString($string, $type = 'L', $spacer = '_', $replaceNumbers = true, $keepOnlyCharacters = true)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe(
			$string,
			$type,
			$spacer,
			$replaceNumbers,
			$keepOnlyCharacters
		);
	}

	/**
	 * Convert none English strings to code usable string
	 *
	 * @input    an string
	 *
	 * @returns a string
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::transliterate($string);
	 */
	public static function transliterate($string)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::transliterate($string);
	}

	/**
	 * make sure a string is HTML save
	 *
	 * @input    an html string
	 *
	 * @returns a string
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html(...);
	 */
	public static function htmlEscape($var, $charset = 'UTF-8', $shorten = false, $length = 40)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html(
			$var,
			$charset,
			$shorten,
			$length
		);
	}###HELPER_LICENSE_LOCK###

	/**
	 * Convert all int in a string to an English word string
	 *
	 * @input    an string with numbers
	 *
	 * @returns a string
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::numbers($string);
	 */
	public static function replaceNumbers($string)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::numbers($string);
	}

	/**
	 * Convert an integer into an English word string
	 * Thanks to Tom Nicholson <http://php.net/manual/en/function.strval.php#41988>
	 *
	 * @input    an int
	 * @returns a string
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::number($x);
	 */
	public static function numberToString($x)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::number($x);
	}

	/**
	 * Random Key
	 *
	 * @returns a string
	 * @deprecated 3.3 Use Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::random($size);
	 */
	public static function randomkey($size)
	{
		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::random($size);
	}###GET_CRYPT_KEY###
}
