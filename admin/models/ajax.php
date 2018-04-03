<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		ajax.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper');

/**
 * Componentbuilder Ajax Model
 */
class ComponentbuilderModelAjax extends JModelList
{
	protected $app_params;
	
	public function __construct() 
	{		
		parent::__construct();		
		// get params
		$this->app_params	= JComponentHelper::getParams('com_componentbuilder');
		
	}

	// Used in joomla_component

	/**
	* 	Check and if a vdm notice is new (per/user)
	**/
	public function isNew($notice)
	{
		// first get the file path
		$path_filename = ComponentbuilderHelper::getFilePath('path', 'usernotice', 'md', JFactory::getUser()->username, JPATH_COMPONENT_ADMINISTRATOR);
		// check if the file is set
		if (($content = @file_get_contents($path_filename)) !== FALSE)
		{
			if ($notice == $content)
			{
				return false;
			}
		}
		return true;
	}

	/**
	* 	set That a notice has been read (per/user)
	**/
	public function isRead($notice)
	{
		// first get the file path
		$path_filename = ComponentbuilderHelper::getFilePath('path', 'usernotice', 'md', JFactory::getUser()->username, JPATH_COMPONENT_ADMINISTRATOR);
		// set as read if not already set
		if (($content = @file_get_contents($path_filename)) !== FALSE)
		{
			if ($notice == $content)
			{
				return true;
			}
		}
		return $this->saveFile($notice,$path_filename);
	}

	protected function saveFile($data,$path_filename)
	{
		if (ComponentbuilderHelper::checkString($data))
		{
			$fp = fopen($path_filename, 'w');
			fwrite($fp, $data);
			fclose($fp);
			return true;
		}
		return false;
	}
	/**
	* 	get the component details (html)
	**/
	public function getComponentDetails($id)
	{
		// Need to find the asset id by the name of the component.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName(array(
				'id','companyname','component_version','copyright','debug_linenr',
				'description','email','image','license','name',
				'short_description','website','author','add_placeholders',
				'system_name','mvc_versiondate')))
			->from($db->quoteName('#__componentbuilder_joomla_component'))
			->where($db->quoteName('id') . ' = ' . (int) $id);
		$db->setQuery($query);
		$db->execute();
		if ($db->loadRowList())
		{
			return array( 'html' => $this->componentDetailsDisplay($db->loadObject()));
		}
		return false;
	}

	/**
	* 	set the component display
	**/
	protected function componentDetailsDisplay($object)
	{
		// set some vars
		$image = (ComponentbuilderHelper::checkString($object->image)) ? '<img alt="Joomla Component Image" src="'. JURI::root() . $object->image . '" style="float: right;">': '';
		$desc = (ComponentbuilderHelper::checkString($object->description)) ? $object->description : $object->short_description;
		$placeholder = ($object->add_placeholders == 1) ? '<span class="btn btn-small btn-success"> ' . JText::_('COM_COMPONENTBUILDER_YES') . ' </span>' : '<span class="btn btn-small btn-danger"> ' .JText::_('COM_COMPONENTBUILDER_NO') . ' </span>' ;
		$debug = ($object->debug_linenr == 1) ? '<span class="btn btn-small btn-success"> ' .JText::_('COM_COMPONENTBUILDER_YES') . '</span>'  : ' <span class="btn btn-small btn-danger"> ' .JText::_('COM_COMPONENTBUILDER_NO') . ' </span>' ;
		$html = array();
		$html[] = '<h3>' . $object->name . ' (v' . $object->component_version . ')</h3>';
		$html[] = '<p>' . $desc . $image . '</p>';
		$html[] = '<ul>';
		$html[] = '<li>' . JText::_('COM_COMPONENTBUILDER_COMPANY') . ': <b>' . $object->companyname . '</b></li>';
		$html[] = '<li>' . JText::_('COM_COMPONENTBUILDER_AUTHOR') . ': <b>' . $object->author . '</b></li>';
		$html[] = '<li>' . JText::_('COM_COMPONENTBUILDER_EMAIL') . ': <b>' . $object->email . '</b></li>';
		$html[] = '<li>' . JText::_('COM_COMPONENTBUILDER_WEBSITE') . ': <b>' . $object->website . '</b></li>';
		$html[] = '</ul>';
		$html[] = '<h4>' . JText::_('COM_COMPONENTBUILDER_COMPONENT_GLOBAL_SETTINGS') . '</h4>';
		$html[] = '<p>';
		$html[] = JText::_('COM_COMPONENTBUILDER_ADD_CUSTOM_CODE_PLACEHOLDERS') . '<br />' . $placeholder . '<br />';
		$html[] = JText::_('COM_COMPONENTBUILDER_DEBUG_LINE_NUMBERS') . '<br />' . $debug ;
		$html[] = '</p>';
		$html[] = '<h4>' . JText::_('COM_COMPONENTBUILDER_LICENSE') . '</h4>';
		$html[] = '<p>' . $object->license . '</p>';
		$html[] = '<h4>' . JText::_('COM_COMPONENTBUILDER_COPYRIGHT') . '</h4>';
		$html[] = '<p>' . $object->copyright . '<br /><br />';
		$html[] = '<a href="index.php?option=com_componentbuilder&ref=compiler&view=joomla_components&task=joomla_component.edit&id=' . (int) $object->id . '" class="btn btn-small span12"><span class="icon-edit"></span> ' . JText::_('COM_COMPONENTBUILDER_EDIT') . ' ' .$object->system_name . '</a></p>';
		// now return the diplay
		return implode("\n", $html);
	}

	/**
	* 	get the component details (html)
	**/
	public function getCronPath($type)
	{
		$result = array('error' => '<span style="color: red;">' . JText::_('COM_COMPONENTBUILDER_NO_CRONJOB_PATH_FOUND_SINCE_INCORRECT_TYPE_REQUESTED') . '</span>');
		if ('backup' === $type)
		{
			$result['error'] = '<span style="color: red;">' . JText::sprintf('COM_COMPONENTBUILDER_NO_CRONJOB_PATH_FOUND_FOR_S', $type) . '</span>';
			if ($this->hasCurl())
			{
				$path = '*/5 * * * * curl -s "' .JURI::root() . 'index.php?option=com_componentbuilder&task=api.backup" >/dev/null 2>&1';
			}
			else
			{
				$path = '*/5 * * * * wget "' .JURI::root() . 'index.php?option=com_componentbuilder&task=api.backup" >/dev/null 2>&1';
			}
			$result['path'] =  '<code>' . $path . '</code>';
		}
		return $result;
	}
	
	protected function hasCurl()
	{
		return function_exists('curl_version');
	}

	// Used in admin_view

	protected $viewid = array();

	protected function getViewID($call = 'table')
	{
		if (!isset($this->viewid[$call]))
		{
			// get the vdm key
			$jinput = JFactory::getApplication()->input;
			$vdm = $jinput->get('vdm', null, 'WORD');
			if ($vdm) 
			{
				if ($view = ComponentbuilderHelper::get($vdm))
				{
					$current = (array) explode('__', $view);
					if (ComponentbuilderHelper::checkString($current[0]) && isset($current[1]) && is_numeric($current[1]))
					{
						// get the view name & id
						$this->viewid[$call] = array(
							'a_id' => (int) $current[1],
							'a_view' => $current[0]
						);
					}
				}
			}
		}
		if (isset($this->viewid[$call]))
		{
			return $this->viewid[$call];
		}
		return false;
	}

	protected $buttonArray = array(
				'library_config' => 'libraries_config',
				'library_files_folders_urls' => 'libraries_files_folders_urls',
				'admin_fields' => 'admins_fields',
				'admin_fields_conditions' => 'admins_fields_conditions',
				'validation_rule' => 'validation_rules',
				'field' => 'fields',
				'component_admin_views' => 'components_admin_views' ,
				'component_site_views' => 'components_site_views',
				'component_custom_admin_views' => 'components_custom_views',
				'component_updates' => 'components_updates',
				'component_mysql_tweaks' => 'components_mysql_tweaks',
				'component_custom_admin_menus' => 'components_custom_admin_menus',
				'component_config' => 'components_config',
				'component_dashboard' => 'components_dashboard',
				'component_files_folders' => 'components_files_folders',
				'language' => true);

	public function getButton($type, $size)
	{
		if (isset($this->buttonArray[$type]))
		{
			$user = JFactory::getUser();
			// only add if user allowed to create
			if ($user->authorise($type.'.create', 'com_componentbuilder'))
			{
				// get the view name & id
				$values = $this->getViewID();
				// check if new item
				$ref = '';
				if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
				{
					// only load referal if not new item.
					$ref = '&amp;ref=' . $values['a_view'] . '&amp;refid=' . $values['a_id'];
				}
				// build url (A tag)
				$startAtag = '<a class="btn btn-success vdm-button-new" onclick="UIkit2.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \'index.php?option=com_componentbuilder&amp;view='.$type.'&amp;layout=edit'.$ref.'\' })" href="javascript:void(0)"  title="'.JText::sprintf('COM_COMPONENTBUILDER_CREATE_NEW_S', ComponentbuilderHelper::safeString($type, 'W')).'">';
				// build the smaller button
				if (2 == $size)
				{
					$button = $startAtag.'<span class="icon-new icon-white"></span> ' . JText::_('COM_COMPONENTBUILDER_CREATE') . '</a>';
				}
				else
				// build the big button
				{
					$button = '<div class="control-group">
								<div class="control-label">
									<label>' . ucwords($type) . '</label>
								</div>
								<div class="controls">	'.$startAtag.'
									<span class="icon-new icon-white"></span> 
										' . JText::_('COM_COMPONENTBUILDER_NEW') . '
									</a>
								</div>
							</div>';
				}
				// return the button attached to input field
				return $button;
			}
			return '';
		}
		return false;
	}

	public function getButtonID($type, $size)
	{
		if (isset($this->buttonArray[$type]))
		{
			$user = JFactory::getUser();
			// only add if user allowed to create
			if ($user->authorise($type.'.create', 'com_componentbuilder'))
			{
				// get the view name & id
				$values = $this->getViewID();
				// set the button ID
				$css_class = 'control-group-'.ComponentbuilderHelper::safeString($type. '-' . $size, 'L', '-');
				// check if new item
				$ref = '';
				if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
				{
					// only load referral if not new item.
					$ref = '&amp;ref=' . $values['a_view'] . '&amp;refid=' . $values['a_id'];
					// get item id
					if ($id = ComponentbuilderHelper::getVar($type, $values['a_id'], $values['a_view'], 'id'))
					{
						$buttonText = JText::sprintf('COM_COMPONENTBUILDER_EDIT_S_FOR_THIS_S', ComponentbuilderHelper::safeString($type, 'w'), ComponentbuilderHelper::safeString($values['a_view'], 'w'));
						$buttonTextSmall = JText::_('COM_COMPONENTBUILDER_EDIT');
						$editThis = 'index.php?option=com_componentbuilder&amp;view='.$this->buttonArray[$type].'&amp;task='.$type.'.edit&amp;id='.$id;
						$icon = 'icon-apply';
					}
					else
					{
						$buttonText = JText::sprintf('COM_COMPONENTBUILDER_CREATE_S_FOR_THIS_S', ComponentbuilderHelper::safeString($type, 'w'), ComponentbuilderHelper::safeString($values['a_view'], 'w'));
						$buttonTextSmall = JText::_('COM_COMPONENTBUILDER_CREATE');
						$editThis = 'index.php?option=com_componentbuilder&amp;view='.$type.'&amp;layout=edit';
						$icon = 'icon-new';
					}
					// build the button
					$button = array();
					if (1 == $size)
					{
						$button[] = '<div class="control-group '.$css_class.'">';
						$button[] = '<div class="control-label">';
						$button[] = '<label>' . ComponentbuilderHelper::safeString($type, 'Ww') . '</label>';
						$button[] = '</div>';
						$button[] = '<div class="controls">';
					}
					$button[] = '<a class="btn btn-success vdm-button-new" onclick="UIkit2.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \''.$editThis.$ref.'\' })" href="javascript:void(0)" title="'.$buttonText.'">';
					if (1 == $size)
					{
						$button[] = '<span class="'.$icon.' icon-white"></span>';
						$button[] = $buttonText;
						$button[] = '</a>';
						$button[] = '</div>';
						$button[] = '</div>';
					}
					elseif (2 == $size)
					{
						$button[] = '<span class="'.$icon.' icon-white"></span>';
						$button[] = $buttonTextSmall;
						$button[] = '</a>';
					}
					// return the button attached to input field
					return implode("\n", $button);
				}
				// only return notice if big button
				if (1 == $size)
				{
					return '<div class="control-group '.$css_class.'"><div class="alert alert-info">' . JText::sprintf('COM_COMPONENTBUILDER_BUTTON_TO_CREATE_S_WILL_SHOW_ONCE_S_IS_SAVED_FOR_THE_FIRST_TIME', ComponentbuilderHelper::safeString($type, 'w'), ComponentbuilderHelper::safeString($values['a_view'], 'w')) . '</div></div>';
				}
			}
		}
		return '';
	}

	public function checkAliasField($type)
	{
		// get the view name & id
		$values = $this->getViewID();
		if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']) && in_array($values['a_view'], $this->allowedViewsArray))
		{
			// get the fields
			if ($fields = ComponentbuilderHelper::getVar('admin_fields', $values['a_id'], 'admin_view', 'addfields'))
			{
				// open the fields
				if (ComponentbuilderHelper::checkJson($fields))
				{
					$fields = json_decode($fields, true);
					if (ComponentbuilderHelper::checkArray($fields))
					{
						foreach($fields as $field)
						{
							if (isset($field['alias']) && $field['alias'] == 1)
							{
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	public function getDynamicScripts($type)
	{
		// get from global helper
		return ComponentbuilderHelper::getDynamicScripts($type);
	}

	protected $functionArray = array(
				// Library
				'rename' => 'setYesNo',
				'update' => 'setYesNo',
				'type' => 'setURLType',
				// Admin View
				'field' => 'setItemNames',
				'list' => 'setYesNo',
				'title' => 'setYesNo',
				'alias' => 'setYesNo',
				'sort' => 'setYesNo',
				'search' => 'setYesNo',
				'filter' => 'setYesNo',
				'link' => 'setYesNo',
				'permission' => 'setYesNo',
				'tab' => 'setTabName',
				'alignment' => 'setAlignmentName',
				'target_field' => 'setItemNames',
				'target_behavior' => 'setTargetBehavior',
				'target_relation' => 'setTargetRelation',
				'match_field' => 'setItemNames',
				'match_behavior' => 'setMatchBehavior',
				'match_options' => 'setMatchOptions',
				// Joomla Component
				'menu' => 'setYesNo',
				'metadata' => 'setYesNo',
				'default_view' => 'setYesNo',
				'access' => 'setYesNo',
				'public_access' => 'setYesNo',
				'mainmenu' => 'setYesNo',
				'dashboard_list' => 'setYesNo',
				'submenu' => 'setYesNo',
				'dashboard_add' => 'setYesNo',
				'checkin' => 'setYesNo',
				'history' => 'setYesNo',
				'port' => 'setYesNo',
				'edit_create_site_view' => 'setYesNo',
				'icomoon' => 'setIcoMoon',
				'customadminview' => 'setItemNames',
				'adminviews' => 'setItemNames',
				'adminview' => 'setItemNames',
				'siteview' => 'setItemNames',
				'before' => 'setItemNames');

	protected function getLanguage($key)
	{
		$language = array(
			// Library (folder file url)
			'rename' => JText::_('COM_COMPONENTBUILDER_RENAME'),
			'path' => JText::_('COM_COMPONENTBUILDER_TARGET_PATH'),
			'update' => JText::_('COM_COMPONENTBUILDER_UPDATE'),
			// Admin View (fields)
			'field' => JText::_('COM_COMPONENTBUILDER_FIELD'),
			'list' => JText::_('COM_COMPONENTBUILDER_ADMIN_LIST'),
			'order_list' => JText::_('COM_COMPONENTBUILDER_ORDER_IN_LIST_VIEWS'),
			'title' => JText::_('COM_COMPONENTBUILDER_TITLE'),
			'alias' => JText::_('COM_COMPONENTBUILDER_ALIAS'),
			'sort' => JText::_('COM_COMPONENTBUILDER_SORTABLE'),
			'search' => JText::_('COM_COMPONENTBUILDER_SEARCHABLE'),
			'filter' => JText::_('COM_COMPONENTBUILDER_FILTER'),
			'link' => JText::_('COM_COMPONENTBUILDER_LINK'),
			'permission' => JText::_('COM_COMPONENTBUILDER_PERMISSIONS'),
			'tab' => JText::_('COM_COMPONENTBUILDER_TAB'),
			'alignment' => JText::_('COM_COMPONENTBUILDER_ALIGNMENT'),
			'order_edit' => JText::_('COM_COMPONENTBUILDER_ORDER_IN_EDIT'),
			// Admin View (conditions)
			'target_field' => JText::_('COM_COMPONENTBUILDER_TARGET_FIELDS'),
			'target_behavior' => JText::_('COM_COMPONENTBUILDER_TARGET_BEHAVIOR'),
			'target_relation' => JText::_('COM_COMPONENTBUILDER_TARGET_RELATION'),
			'match_field' => JText::_('COM_COMPONENTBUILDER_MATCH_FIELD'),
			'match_behavior' => JText::_('COM_COMPONENTBUILDER_MATCH_BEHAVIOR'),
			'match_options' => JText::_('COM_COMPONENTBUILDER_MATCH_OPTIONS'),
			// Joomla Component
			'menu' => JText::_('COM_COMPONENTBUILDER_ADD_MENU'),
			'metadata' => JText::_('COM_COMPONENTBUILDER_HAS_METADATA'),
			'default_view' => JText::_('COM_COMPONENTBUILDER_DEFAULT_VIEW'),
			'access' => JText::_('COM_COMPONENTBUILDER_ADD_ACCESS'),
			'public_access' => JText::_('COM_COMPONENTBUILDER_PUBLIC_ACCESS'),
			'mainmenu' => JText::_('COM_COMPONENTBUILDER_MAIN_MENU'),
			'dashboard_list' => JText::_('COM_COMPONENTBUILDER_DASHBOARD_LIST_OF_RECORDS'),
			'dashboard_add' => JText::_('COM_COMPONENTBUILDER_DASHBOARD_ADD_RECORD'),
			'submenu' => JText::_('COM_COMPONENTBUILDER_SUBMENU'),
			'checkin' => JText::_('COM_COMPONENTBUILDER_AUTO_CHECKIN'),
			'history' => JText::_('COM_COMPONENTBUILDER_KEEP_HISTORY'),
			'port' => JText::_('COM_COMPONENTBUILDER_EXPORTIMPORT_DATA'),
			'edit_create_site_view' => JText::_('COM_COMPONENTBUILDER_EDITCREATE_SITE_VIEW'),
			'icomoon' => JText::_('COM_COMPONENTBUILDER_ICON'),
			'customadminview' => JText::_('COM_COMPONENTBUILDER_VIEW'),
			'adminviews' => JText::_('COM_COMPONENTBUILDER_VIEWS'),
			'adminview' => JText::_('COM_COMPONENTBUILDER_VIEW'),
			'siteview' => JText::_('COM_COMPONENTBUILDER_VIEW'),
			'before' => JText::_('COM_COMPONENTBUILDER_ORDER_BEFORE')
		);
		// check if a unique value is available
		if (isset($language[$key]))
		{
			return $language[$key];
		}
		// check a shared value is available
		$keys = explode('|=VDM=|', $key);
		if (isset($language[$keys[1]]))
		{
			return $language[$keys[1]];
		}
		return ComponentbuilderHelper::safeString($keys[1], 'Ww');
	}


	protected function getSubformTable($idName, $data)
	{
		// make sure we convert the json to array
		if (ComponentbuilderHelper::checkJson($data))
		{
			$data = json_decode($data, true);
		}
		// make sure we have an array
		if (ComponentbuilderHelper::checkArray($data) && ComponentbuilderHelper::checkString($idName))
		{ 
			// Build heading
			$head = array();
			foreach ($data as $headers)
			{
				foreach ($headers as $header => $value)
				{
					if (!isset($head[$header]))
					{
						$head[$header] = $this->getLanguage($idName . '|=VDM=|' . $header);
					}
				}
			}
			// build the rows
			$rows = array();
			if (ComponentbuilderHelper::checkArray($data) && ComponentbuilderHelper::checkArray($head))
			{
				foreach ($data as $nr => $values)
				{
					foreach ($head as $key => $_header)
					{
						// set the value for the row
						if (isset($values[$key]))
						{
							$this->setSubformRows($nr, $this->setSubformValue($key, $values[$key]), $rows, $_header);
						}
						else
						{
							$this->setSubformRows($nr, $this->setSubformValue($key, ''), $rows, $_header);
						}
					}
				}
			}
			// build table
			if (ComponentbuilderHelper::checkArray($rows) && ComponentbuilderHelper::checkArray($head))
			{
				// set the number of rows
				$this->rowNumber = count($rows);
				// return the table
				return $this->setSubformTable($head, $rows, $idName);
			}
		}
		return false;
	}

	protected function setSubformTable($head, $rows, $idName)
	{
		$table[] = "<div class=\"row-fluid\" id=\"vdm_table_display_".$idName."\">";
		$table[] = "\t<div class=\"subform-repeatable-wrapper subform-table-layout subform-table-sublayout-section-byfieldsets\">";
		$table[] = "\t\t<div class=\"subform-repeatable\">";
		$table[] = "\t\t\t<table class=\"adminlist table table-striped table-bordered\">";
		$table[] = "\t\t\t\t<thead>";
		$table[] = "\t\t\t\t\t<tr>";
		$table[] = "\t\t\t\t\t\t<th>" .  implode("</th><th>", $head) . "</th>";
		$table[] = "\t\t\t\t\t</tr>";
		$table[] = "\t\t\t\t</thead>";
		$table[] = "\t\t\t\t<tbody>";
		foreach ($rows as $row)
		{
			$table[] = "\t\t\t\t\t<tr class=\"subform-repeatable-group\">";
			$table[] = "\t\t\t\t\t\t" . $row;
			$table[] = "\t\t\t\t\t</tr>";
		}
		$table[] = "\t\t\t\t</tbody>";
		$table[] = "\t\t\t</table>";
		$table[] = "\t\t</div>";
		$table[] = "\t</div>";
		$table[] = "</div>";
		// return the table
		return implode("\n", $table);
	}

	protected function setSubformValue($header, $value)
	{
		if (array_key_exists($header, $this->functionArray) && method_exists($this, $this->functionArray[$header]))
		{
			$value = $this->{$this->functionArray[$header]}($header, $value);
		}
		// if no value are set
		if (!ComponentbuilderHelper::checkString($value))
		{
			$value = '-';
		}
		return $value;
	}

	protected function setSubformRows($nr, $value, &$rows, $_header)
	{
		// build rows
		if (!isset($rows[$nr]))
		{
			$rows[$nr] = '<td data-column=" '.$_header.' ">'.$value.'</td>';
		}
		else
		{
			$rows[$nr] .= '<td data-column=" '.$_header.' ">'.$value.'</td>';
		}
	}

	protected $ref;
	protected $fieldsArray = array(
				'library_config' => 'addconfig',
				'library_files_folders_urls' => array('addurls','addfiles','addfolders'),
				'admin_fields' => 'addfields',
				'admin_fields_conditions' => 'addconditions',
				'component_admin_views' =>  'addadmin_views',
				'component_site_views' =>  'addsite_views',
				'component_custom_admin_views' =>  'addcustom_admin_views');
	protected $allowedViewsArray = array(
				'admin_view',
				'joomla_component',
				'library');

	public function getAjaxDisplay($type)
	{
		if (isset($this->fieldsArray[$type]))
		{
			// set type name
			$typeName = ComponentbuilderHelper::safeString($type, 'w');
			// get the view name & id
			$values = $this->getViewID();
			// check if we are in the correct view.
			if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']) && in_array($values['a_view'], $this->allowedViewsArray))
			{
				$this->ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'];
				// load the results
				$result = array();
				// return field table
				if (ComponentbuilderHelper::checkArray($this->fieldsArray[$type]))
				{
					foreach ($this->fieldsArray[$type] as $fieldName)
					{
						if ($table = $this->getFieldTable($type, $values['a_id'], $values['a_view'], $fieldName, $typeName))
						{
							$result[] = $table;
						}
					}
				}
				elseif (ComponentbuilderHelper::checkString($this->fieldsArray[$type]))
				{
					if ($table = $this->getFieldTable($type, $values['a_id'], $values['a_view'], $this->fieldsArray[$type], $typeName))
					{
						$result[] = $table;
					}
				}
				// check if we have results
				if (ComponentbuilderHelper::checkArray($result) && count($result) == 1)
				{
					// return the display
					return implode('', $result);
				}
				elseif (ComponentbuilderHelper::checkArray($result))
				{
					// return the display
					return '<div>' . implode('</div><div>', $result) . '</div>';
				}
			}
			return '<div class="control-group"><div class="alert alert-info">' . JText::sprintf('COM_COMPONENTBUILDER_NO_S_HAVE_BEEN_LINKED_TO_THIS_VIEW_SOON_AS_THIS_IS_DONE_IT_WILL_BE_DISPLAYED_HERE', $typeName) . '</div></div>';
		}
		return '<div class="control-group"><div class="alert alert-error"><h4>' . JText::_('COM_COMPONENTBUILDER_TYPE_ERROR') . '</h4><p>' . JText::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_IF_THIS_CONTINUES_PLEASE_INFORM_YOUR_SYSTEM_ADMINISTRATOR_OF_A_TYPE_ERROR_IN_THE_FIELDS_DISPLAY_REQUEST') . '</p></div></div>';
	}

	protected function getFieldTable($type, $id, $idName, $fieldName, $typeName)
	{
		// get the field data
		if ($fieldsData = ComponentbuilderHelper::getVar($type, (int) $id, $idName, $fieldName))
		{
			// check repeatable conversion
			$this->checkRepeatableConversion($fieldsData, $fieldName, $id, $idName);
			// get the table
			$table = $this->getSubformTable($type, $fieldsData);
			// set notice of bad practice
			$notice = '';
			if ($idName === 'admin_view' && isset($this->rowNumber) && $this->rowNumber > 50)
			{
				$notice = '<div class="alert alert-warning">' . JText::sprintf('COM_COMPONENTBUILDER_YOU_HAVE_S_S_ADDING_MORE_THEN_FIFTY_S_IS_CONSIDERED_BAD_PRACTICE_YOUR_S_PAGE_LOAD_IN_JCB_WILL_SLOWDOWN_YOU_SHOULD_CONSIDER_DECOUPLING_SOME_OF_THESE_S', $this->rowNumber, $typeName, $typeName, $typeName, $typeName) . '</div>';
			}
			elseif ($idName === 'admin_view' && isset($this->rowNumber))
			{
				$notice = '<div class="alert alert-info">' . JText::sprintf('COM_COMPONENTBUILDER_YOU_HAVE_S_S_ADDING_MORE_THEN_FIFTY_S_IS_CONSIDERED_BAD_PRACTICE', $this->rowNumber, $typeName, $typeName) . '</div>';
			}
			// return table
			return $notice.$table;
		}
		return false;
	}

	protected $conversionCheck = array(
				'addfields' => 'field',
				'addconditions' => 'target_field',
				'addadmin_views' => 'adminview',
				'addconfig' => 'field',
				'addcustom_admin_views' => 'customadminview',
				'addcustommenus' => 'name',
				'addsite_views' => 'siteview',
				'sql_tweak' => 'adminview',
				'version_update' => 'version');

	protected function checkRepeatableConversion(&$fieldsData, $fieldsArrayType, $id, $linked_id_name)
	{
		if (ComponentbuilderHelper::checkJson($fieldsData) && isset($this->conversionCheck[$fieldsArrayType]))
		{
			$fieldsData = json_decode($fieldsData, true);
			if (isset($fieldsData[$this->conversionCheck[$fieldsArrayType]]))
			{
				$bucket = array();
				foreach($fieldsData as $option => $values)
				{
					foreach($values as $nr => $value)
					{
						$bucket[$fieldsArrayType.$nr][$option] = $value;
					}
				}
				$fieldsData = json_encode($bucket);
				// update the fields
				$objectUpdate = new stdClass();
				$objectUpdate->{$linked_id_name} = (int) $id;
				$objectUpdate->{$fieldsArrayType} = $fieldsData;
				JFactory::getDbo()->updateObject('#__componentbuilder_'.$type, $objectUpdate, 'admin_view');
			}
		}
	}

	protected $itemNames = array(
			'field' => array(),
			'admin_view' => array(),
			'site_view' => array(),
			'custom_admin_view' => array()			
		);

	protected $itemKeys = array(
			// admin view
			'field' => array('table' => 'field', 'tables' => 'fields', 'id' => 'id', 'name' => 'name', 'text' => 'Field', 'type' => array('table' => 'fieldtype', 'field' => 'id', 'key' => 'fieldtype', 'get' => 'name')),
			'target_field' => array('table' => 'field', 'tables' => 'fields', 'id' => 'id', 'name' => 'name', 'text' => 'Field', 'type' => array('table' => 'fieldtype', 'field' => 'id', 'key' => 'fieldtype', 'get' => 'name')),
			'match_field' => array('table' => 'field', 'tables' => 'fields', 'id' => 'id', 'name' => 'name', 'text' => 'Field', 'type' => array('table' => 'fieldtype', 'field' => 'id', 'key' => 'fieldtype', 'get' => 'name')),
			// joomla component view
			'siteview' => array('table' => 'site_view', 'tables' => 'site_views', 'id' => 'id', 'name' => 'name', 'text' => 'Site View'),
			'customadminview' => array('table' => 'custom_admin_view', 'tables' => 'custom_admin_views', 'id' => 'id', 'name' => 'system_name', 'text' => 'Custom Admin View'),
			'adminviews' => array('table' => 'admin_view', 'tables' => 'admin_views', 'id' => 'id', 'name' => 'system_name', 'text' => 'Admin View'),
			'adminview' => array('table' => 'admin_view', 'tables' => 'admin_views', 'id' => 'id', 'name' => 'system_name', 'text' => 'Admin View'),
			'before' => array('table' => 'admin_view', 'tables' => 'admin_views', 'id' => 'id', 'name' => 'system_name', 'text' => 'Admin View')	
		);

	protected function setItemNames($header, $value)
	{
		if (isset($this->itemKeys[$header]) && isset($this->itemKeys[$header]['table']) && isset($this->itemNames[$this->itemKeys[$header]['table']]))
		{
			// reset bucket
			$bucket = array();
			if (ComponentbuilderHelper::checkArray($value))
			{
				foreach ($value as $item)
				{
					$edit = true;
					if (!isset($this->itemNames[$this->itemKeys[$header]['table']][$item]))
					{
						if (!$this->itemNames[$this->itemKeys[$header]['table']][$item] =  ComponentbuilderHelper::getVar($this->itemKeys[$header]['table'], (int) $item, $this->itemKeys[$header]['id'], $this->itemKeys[$header]['name']))
						{
							$this->itemNames[$this->itemKeys[$header]['table']][$item] = JText::sprintf('COM_COMPONENTBUILDER_NO_S_FOUND', $this->itemKeys[$header]['text']);
							$edit = false;
						}
						// check if we should load a type
						if ($edit && isset($this->itemKeys[$header]['type']) && ComponentbuilderHelper::checkArray($this->itemKeys[$header]['type']) && isset($this->itemKeys[$header]['type']['table']))
						{
							// get the linked value 
							if ($_key = ComponentbuilderHelper::getVar($this->itemKeys[$header]['table'], (int) $item, $this->itemKeys[$header]['id'], $this->itemKeys[$header]['type']['key']))
							{
								$this->itemNames[$this->itemKeys[$header]['table']][$item] .=  ' [' . ComponentbuilderHelper::getVar($this->itemKeys[$header]['type']['table'], (int) $_key,  $this->itemKeys[$header]['type']['field'], $this->itemKeys[$header]['type']['get']) .']';
							}
						}
					}
					// set edit link
					$link = ($edit) ? $this->addEditLink($item, $this->itemKeys[$header]['table'], $this->itemKeys[$header]['tables']) : '';
					// load item
					$bucket[] = $this->itemNames[$this->itemKeys[$header]['table']][$item] . $link;
				}
			}
			elseif (is_numeric($value))
			{
				$edit = true;
				if (!isset($this->itemNames[$this->itemKeys[$header]['table']][$value]))
				{
					if (!$this->itemNames[$this->itemKeys[$header]['table']][$value] =  ComponentbuilderHelper::getVar($this->itemKeys[$header]['table'], (int) $value, $this->itemKeys[$header]['id'], $this->itemKeys[$header]['name']))
					{
						$this->itemNames[$this->itemKeys[$header]['table']][$value] = JText::sprintf('COM_COMPONENTBUILDER_NO_S_FOUND', $this->itemKeys[$header]['text']);
						$edit = false;
					}
					// check if we should load a type
					if ($edit && isset($this->itemKeys[$header]['type']) && ComponentbuilderHelper::checkArray($this->itemKeys[$header]['type']) && isset($this->itemKeys[$header]['type']['table']))
					{
						// get the linked value 
						if ($_key = ComponentbuilderHelper::getVar($this->itemKeys[$header]['table'], (int) $value, $this->itemKeys[$header]['id'], $this->itemKeys[$header]['type']['key']))
						{
							$this->itemNames[$this->itemKeys[$header]['table']][$value] .=  ' [' . ComponentbuilderHelper::getVar($this->itemKeys[$header]['type']['table'], (int) $_key,  $this->itemKeys[$header]['type']['field'], $this->itemKeys[$header]['type']['get']) .']';
						}
					}
				}
				// set edit link
				$link = ($edit) ? $this->addEditLink($value, $this->itemKeys[$header]['table'], $this->itemKeys[$header]['tables']) : '';
				// load item
				$bucket[] = $this->itemNames[$this->itemKeys[$header]['table']][$value] . $link;
			}
			// return found items
			if (ComponentbuilderHelper::checkArray($bucket))
			{
				return implode('<br />', $bucket);
			}
			return JText::sprintf('COM_COMPONENTBUILDER_NO_S_FOUND', $this->itemKeys[$header]['text']);
		}
		return JText::_('COM_COMPONENTBUILDER_NO_ITEM_FOUND');
	}

	protected function setURLType($header, $value)
	{
		switch ($value)
		{
			case 1:
				return JText::_('COM_COMPONENTBUILDER_DEFAULT_LINK');
			break;
			case 2:
				return JText::_('COM_COMPONENTBUILDER_LOCAL_GET');
			break;
			case 3:
				return JText::_('COM_COMPONENTBUILDER_LINK_LOCAL_DYNAMIC');
			break;
		}
		return JText::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	protected function setIcoMoon($header, $value)
	{
		if (ComponentbuilderHelper::checkString($value))
		{
			return '<span class="icon-' . $value . '"></span>';
		}
		return '-';
	}

	protected function setAlignmentName($header, $value)
	{
		switch ($value)
		{
			case 1:
				return JText::_('COM_COMPONENTBUILDER_LEFT_IN_TAB');
			break;
			case 2:
				return JText::_('COM_COMPONENTBUILDER_RIGHT_IN_TAB');
			break;
			case 3:
				return JText::_('COM_COMPONENTBUILDER_FULL_WIDTH_IN_TAB');
			break;
			case 4:
				return JText::_('COM_COMPONENTBUILDER_ABOVE_TABS');
			break;
			case 5:
				return JText::_('COM_COMPONENTBUILDER_UNDERNEATH_TABS');
			break;
			case 6:
				return JText::_('COM_COMPONENTBUILDER_LEFT_OF_TABS');
			break;
			case 7:
				return JText::_('COM_COMPONENTBUILDER_RIGHT_OF_TABS');
			break;
		}
		return JText::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	protected function addEditLink($id, $view, $views)
	{
		// can edit
		if ($this->canEdit($id, $view))
		{
			$edit = "index.php?option=com_componentbuilder&view=".$views."&task=".$view.".edit&id=".$id.$this->ref;
			$title = ComponentbuilderHelper::safeString(JText::_('COM_COMPONENTBUILDER_EDIT').' '.$view, 'W');
			return ' <a onclick="UIkit.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \''.$edit.'\' })"  href="javascript:void(0)" class="uk-icon-pencil" title="'.$title.'"></a>';
			
		}
		return '';
	}

	protected $user;

	protected function canEdit($id, $view = 'admin_fields')
	{
		// load field permission check
		if (!ComponentbuilderHelper::checkObject($this->user)) // TODO && $this->user instanceof JUser)
		{
			$this->user = JFactory::getUser();
		}
		return $this->user->authorise($view.'.edit', 'com_componentbuilder.'.$view.'.' . (int) $id);
	}

	protected $tabNames = array();

	protected function setTabName($header, $value)
	{
		// return published if set to 15 (since this is the default number for it)
		if (15 == $value)
		{
			return JText::_('COM_COMPONENTBUILDER_PUBLISHING');
		}
		if (!ComponentbuilderHelper::checkArray($this->tabNames))
		{
			// get the view name & id
			$values = $this->getViewID();
			if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']) && $values['a_view'] === 'admin_view')
			{
				if ($tabs = ComponentbuilderHelper::getVar('admin_view', $values['a_id'], 'id', 'addtabs'))
				{
					$tabs = json_decode($tabs, true);
					if (ComponentbuilderHelper::checkArray($tabs))
					{
						$nr = 1;
						foreach ($tabs as $tab)
						{
							if (ComponentbuilderHelper::checkArray($tab) && isset($tab['name']))
							{
								$this->tabNames[$nr] = $tab['name'];
								$nr++;
							}
						}
					}
				}
			}
		}
		// has it been set
		if (ComponentbuilderHelper::checkArray($this->tabNames) && isset($this->tabNames[$value]))
		{
			return $this->tabNames[$value];
		}
		return JText::_('COM_COMPONENTBUILDER_DETAILS');
	}

	protected function setYesNo($header, $value)
	{
		if (1 == $value)
		{
			return '<span style="color: #46A546;" class="icon-ok"></span>';
		}
		return '<span style="color: #e6e6e6;" class="icon-delete"></span>';
	}

	protected function setTargetBehavior($header, $value)
	{
		if (1 == $value)
		{
			return JText::_('COM_COMPONENTBUILDER_SHOW');
		}
		return JText::_('COM_COMPONENTBUILDER_HIDE');
	}

	protected function setTargetRelation($header, $value)
	{
		switch ($value)
		{
			case 0:
				return JText::_('COM_COMPONENTBUILDER_ISOLATE');
			break;
			case 1:
				return JText::_('COM_COMPONENTBUILDER_CHAIN');
			break;
		}
		return  JText::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	protected function setMatchBehavior($header, $value)
	{
		switch ($value)
		{
			case 1:
				return JText::_('COM_COMPONENTBUILDER_IS_ONLY_FOUR_LISTRADIOCHECKBOXES');
			break;
			case 2:
				return JText::_('COM_COMPONENTBUILDER_IS_NOT_ONLY_FOUR_LISTRADIOCHECKBOXES');
			break;
			case 3:
				return JText::_('COM_COMPONENTBUILDER_ANY_SELECTION_ONLY_FOUR_LISTRADIOCHECKBOXESDYNAMIC_LIST');
			break;
			case 4:
				return JText::_('COM_COMPONENTBUILDER_ACTIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 5:
				return JText::_('COM_COMPONENTBUILDER_UNACTIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 6:
				return JText::_('COM_COMPONENTBUILDER_KEY_WORD_ALL_CASESENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 7:
				return JText::_('COM_COMPONENTBUILDER_KEY_WORD_ANY_CASESENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 8:
				return JText::_('COM_COMPONENTBUILDER_KEY_WORD_ALL_CASEINSENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 9:
				return JText::_('COM_COMPONENTBUILDER_KEY_WORD_ANY_CASEINSENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 10:
				return JText::_('COM_COMPONENTBUILDER_MIN_LENGTH_ONLY_FOUR_TEXT_FIELD');
			break;
			case 11:
				return JText::_('COM_COMPONENTBUILDER_MAX_LENGTH_ONLY_FOUR_TEXT_FIELD');
			break;
			case 12:
				return JText::_('COM_COMPONENTBUILDER_EXACT_LENGTH_ONLY_FOUR_TEXT_FIELD');
			break;
		}
		return  JText::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	protected function setMatchOptions($header, $value)
	{
		return str_replace("\n", "<br />", $value);
	}

	public function getFieldSelectOptions($id)
	{		 
		// Create a new query object.
		$query = $this->_db->getQuery(true);
		$query->select($this->_db->quoteName(array('a.xml', 'b.name')));
		$query->from($this->_db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', $this->_db->quoteName('#__componentbuilder_fieldtype', 'b') . ' ON (' . $this->_db->quoteName('a.fieldtype') . ' = ' . $this->_db->quoteName('b.id') . ')');
		$query->where($this->_db->quoteName('a.published') . ' = 1');
		$query->where($this->_db->quoteName('a.id') . ' = '. (int) $id);
		 
		// Reset the query using our newly populated query object.
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			$result		= $this->_db->loadObject();
			$result->name	= strtolower($result->name);
			if (ComponentbuilderHelper::typeField($result->name,'list'))
			{
				// load the values form params
				$xml = json_decode($result->xml);
				
				$xmlOptions = ComponentbuilderHelper::getBetween($xml,'option="','"');
				
				$optionSet = '';
				if (strpos($xmlOptions,',') !== false)
				{
					// mulitpal options
					$options = explode(',',$xmlOptions);
					foreach ($options as $option)
					{
						// return both value and text
						if (ComponentbuilderHelper::checkString($optionSet))
						{
							// no add to option set
							$optionSet .= "\n".$option;
						}
						else 
						{
							// no add to option set
							$optionSet .= $option;
						}
					}
				}
				else
				{
					// return both value and text
					if (ComponentbuilderHelper::checkString($optionSet))
					{
						// no add to option set
						$optionSet .= "\n".$xmlOptions;
					}
					else 
					{
						// no add to option set
						$optionSet .= $xmlOptions;
					}
				}				
				// return found field options
				return $optionSet;
			}
			elseif (ComponentbuilderHelper::typeField($result->name,'text'))
			{
				return "keywords=\"\"\nlength=\"\"";
			}
			elseif (ComponentbuilderHelper::typeField($result->name,'dynamic'))
			{
				return 'dynamic_list';
			}
			elseif (ComponentbuilderHelper::typeField($result->name))
			{
				return 'match field type not supported. Select another!';
			}
			else
			{
				return 'dynamic_list';
			}
			
		}
		return false;
	}
    
	public function getTableColumns($tableName)
	{
        	// get the columns
		$columns = $this->_db->getTableColumns("#__".$tableName);
		if (ComponentbuilderHelper::checkArray($columns))
		{
        	// build the return string
			$tableColumns = array();
			foreach ($columns as $column => $type)
			{
				$tableColumns[] = $column . ' => ' . $column;
			}
			return implode("\n",$tableColumns);
		}
		return false;
	}

	protected $linkedKeys = array(
			'field' => array(
				array('table' => 'component_config', 'tables' => 'components_config', 'fields' => array('addconfig' => 'field', 'joomla_component' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT', 'linked_name' => 'system_name'),
				array('table' => 'admin_fields', 'tables' => 'admins_fields', 'fields' => array('addfields' => 'field', 'admin_view' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_ADMIN_VIEW', 'linked_name' => 'system_name'),
				array('table' => 'field', 'tables' => 'fields', 'fields' => array('xml' => 'fields', 'name' => 'NAME', 'fieldtype' => 'TYPE'), 'linked' => 'COM_COMPONENTBUILDER_FIELD', 'type_name' => 'name')
			),
			'admin_view' => array(
				array('table' => 'component_admin_views', 'tables' => 'components_admin_views', 'fields' => array('addadmin_views' => 'adminview', 'joomla_component' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT', 'linked_name' => 'system_name')
			),
			'custom_admin_view' => array(
				array('table' => 'component_custom_admin_views', 'tables' => 'components_custom_admin_views', 'fields' => array('addcustom_admin_views' => 'customadminview', 'joomla_component' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT', 'linked_name' => 'system_name')
			),
			'site_view' => array(
				array('table' => 'component_site_views', 'tables' => 'components_site_views', 'fields' => array('addsite_views' => 'siteview', 'joomla_component' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT', 'linked_name' => 'system_name')
			),
			'library' => array(
				array('table' => 'template', 'tables' => 'templates', 'fields' => array('libraries' => 'ARRAY', 'name' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_TEMPLATE'),
				array('table' => 'layout', 'tables' => 'layouts', 'fields' => array('libraries' => 'ARRAY', 'name' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_LAYOUT'),
				array('table' => 'site_view', 'tables' => 'site_views', 'fields' => array('libraries' => 'ARRAY', 'system_name' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_SITE_VIEW'),
				array('table' => 'custom_admin_view', 'tables' => 'custom_admin_views', 'fields' => array('libraries' => 'ARRAY', 'system_name' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW')
			),
			'dynamic_get' => array(
				array('table' => 'site_view', 'tables' => 'site_views', 'fields' => array('custom_get' => 'ARRAY', 'main_get' => 'INT', 'system_name' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_SITE_VIEW'),
				array('table' => 'custom_admin_view', 'tables' => 'custom_admin_views', 'fields' => array('custom_get' => 'ARRAY', 'main_get' => 'INT', 'system_name' => 'NAME'), 'linked' => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW')
			)
		);

	/**
	 * Get Linked
	 * 
	 * @param   int       $type    The display return type
	 *
	 * @return    string  The display return type on success
	 * 
	 */
	public function getLinked($type)
	{
		// get the view name & id
		$values = $this->getViewID();
		// check if item is set
		if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
		{
			// check if we have any linked to config
			if (isset($this->linkedKeys[$values['a_view']]))
			{
				// make sure the ref is set
				$this->ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'];
				// get the linked to
				if ($linked = $this->getLinkedTo($values['a_view'], $values['a_id']))
				{
					// just return it for now a table
					$table =  '<div class="control-group"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
					$table .=  '<caption>'.JText::sprintf('COM_COMPONENTBUILDER_PLACES_ACROSS_JCB_WHERE_THIS_S_IS_LINKED', ComponentbuilderHelper::safeString($values['a_view'], 'w')).'</caption>';
					$table .=  '<thead><tr><th>'.JText::_('COM_COMPONENTBUILDER_TYPE_NAME').'</th></tr></thead>';
					$table .=  '<tbody><tr><td>' .implode('</td></tr><tr><td>', $linked) . '</td></tr></tbody></table></div>';
					return $table;
				}
			}
		}
		// if not found but has session view name
		if (strlen($values['a_view']))
		{
			return '<div class="control-group"><div class="alert alert-info"><h4>' . JText::sprintf('COM_COMPONENTBUILDER_S_NOT_LINKED', ComponentbuilderHelper::safeString($values['a_view'], 'Ww')) . '</h4><p>' . JText::sprintf('COM_COMPONENTBUILDER_THIS_BSB_IS_NOT_LINKED_TO_ANY_OTHER_AREAS_OF_JCB_AT_THIS_TIME', $values['a_view']) . '</p></div></div>';
		}
		// no view or id found in session, or view not allowed to access area
		return '<div class="control-group"><div class="alert alert-error"><h4>' . JText::_('COM_COMPONENTBUILDER_ERROR') . '</h4><p>' . JText::_('COM_COMPONENTBUILDER_THERE_WAS_A_PROBLEM_BNO_VIEW_OR_ID_FOUND_IN_SESSION_OR_VIEW_NOT_ALLOWED_TO_ACCESS_AREAB_WE_COULD_NOT_LOAD_ANY_LINKED_TO_VALUES_PLEASE_INFORM_YOUR_SYSTEM_ADMINISTRATOR') . '</p></div></div>';
	}

	/**
	 * Get Linked to Items
	 * 
	 * @param   string   $view  View that is being searched for
	 * @param   int        $id     ID
	 *
	 * @return  array     Found items
	 * 
	 */
	protected function getLinkedTo($view, $id)
	{
		// reset bucket
		$linked = array();
		// start search
		foreach ($this->linkedKeys[$view] as $search)
		{
			// Create a new query object.
			$query = $this->_db->getQuery(true);
			// get all history values
			$selection = array_keys($search['fields']);
			$selection[] = 'id';
			$query->select($selection);
			$query->from('#__componentbuilder_' . $search['table']);
			$this->_db->setQuery($query);
			$this->_db->execute();
			if ($this->_db->getNumRows())
			{
				// load all items
				$items = $this->_db->loadObjectList();
				// search the items
				foreach ($items as $item)
				{
					$found = false;
					$type_name = null;
					foreach ($search['fields'] as $key => $target)
					{
						if ('NAME' === $target)
						{
							$linked_name = $item->{$key};
							$linked_nameTable = $key;
							continue;
						}
						elseif ('TYPE' === $target)
						{
							$type_name = $item->{$key};
							$type_nameTable = $key;
							continue;
						}
						elseif (!$found)
						{
							if ('INT' === $target)
							{
								// check if ID match
								if ($item->{$key} == $id)
								{
									$found = true;
								}
							}
							else
							{
								// check if we have a json
								if (ComponentbuilderHelper::checkJson($item->{$key}))
								{
									$item->{$key} = json_decode($item->{$key}, true);
								}
								// if array
								if (ComponentbuilderHelper::checkArray($item->{$key}))
								{
									if ('ARRAY' === $target)
									{
										// check if ID match
										foreach ($item->{$key} as $_id)
										{
											if ($_id == $id)
											{
												$found = true;
											}
										}
									}
									else
									{
										foreach ($item->{$key} as $row)
										{
											if (isset($row[$target]) && $row[$target] == $id)
											{
												$found = true;
											}
										}
									}
								}
								// if string (fields)
								if (!$found &&  'xml' === $key && ComponentbuilderHelper::checkString($item->{$key})
									&& strpos($item->{$key}, $target.'="') !== false)
								{
									// now get the fields between
									$_fields = ComponentbuilderHelper::getBetween($item->{$key},  $target.'="', '"');
									// check the result
									if (ComponentbuilderHelper::checkString($_fields))
									{
										// get the ids of all the fields linked here
										$_fields = array_map('trim', (array) explode(',', $_fields));
										// check the result
										if (ComponentbuilderHelper::checkArray($_fields))
										{
											foreach ($_fields as $_field)
											{
												if ($_field == $id)
												{
													$found = true;
												}
											}
										}
									}
								}
							}
						}
					}
					// check if found
					if ($found)
					{
						// build the name
						$edit = true;
						if (is_numeric($linked_name) && isset($search['linked_name']))
						{
							if (!$linked_name =  ComponentbuilderHelper::getVar($linked_nameTable, (int) $linked_name, 'id', $search['linked_name']))
							{
								$linked_name = JText::_('COM_COMPONENTBUILDER_NO_FOUND');
								$edit = false;
							}
						}
						// build the local type
						if (is_numeric($type_name) && isset($search['type_name']))
						{
							if (!$type_name =  ComponentbuilderHelper::getVar($type_nameTable, (int) $type_name, 'id', $search['type_name']))
							{
								$type_name = '';
							}
							else
							{
								$type_name = ' (' . $type_name . ') ';
							}
						}
						elseif (ComponentbuilderHelper::checkString($type_name) || is_numeric($type_name))
						{
							$type_name = ' (' . $type_name . ') ';
						}
						// set edit link
						$link = ($edit) ? $this->addEditLink($item->id, $search['table'], $search['tables']) : '';
						// build the linked
						$linked[] = JText::_($search['linked']) . $type_name . ' - ' . $linked_name . ' ' . $link;
					}
				}
			}
		}
		// check if we found any
		if (ComponentbuilderHelper::checkArray($linked))
		{
			return $linked;
		}
		return false;
	}

	// Used in template
	public function getTemplateDetails($id)
	{
		// set table
		$table = false;
		// Get a db connection.
		$db = JFactory::getDbo();		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.alias','a.template','b.name')));
		$query->from($db->quoteName('#__componentbuilder_template', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_dynamic_get', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.dynamic_get') . ')');
		$query->where($db->quoteName('a.id') . ' != '.(int) $id);
		$query->where($db->quoteName('a.published') . ' = 1');		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{ 
			$results = $db->loadObjectList();
			$templateString = array();
			foreach ($results as $result)
			{
				$templateString[] = "<td><b>".$result->name."</b></td><td><code>&lt;?php echo \$this->loadTemplate('".ComponentbuilderHelper::safeString($result->alias)."'); ?&gt;</code></td>";
			}
			// build the table
			$table = '<h2>'.JText::_('COM_COMPONENTBUILDER_TEMPLATE_CODE_SNIPPETS').'</h2><div class="uk-scrollable-box"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
			$table .= '<caption>'.JText::_('COM_COMPONENTBUILDER_TO_ADD_SIMPLY_COPY_AND_PAST_THE_SNIPPET_INTO_YOUR_CODE').'</caption>';
			$table .= '<thead><tr><th>'.JText::_('COM_COMPONENTBUILDER_NAME_OF_DYNAMICGET').'</th><th>'.JText::_('COM_COMPONENTBUILDER_SNIPPET').'</th></thead>';
			$table .= '<tbody><tr>'.implode("</tr><tr>",$templateString)."</tr></tbody></table></div>";
		}
		return $table;
	}

	// Used in layout
	public function getLayoutDetails($id)
	{
		// set table
		$table = false;
		// Get a db connection.
		$db = JFactory::getDbo();		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.alias','a.layout','b.getcustom','b.gettype','b.name')));
		$query->from($db->quoteName('#__componentbuilder_layout', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_dynamic_get', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.dynamic_get') . ')');
		$query->where($db->quoteName('a.id') . ' != '.(int) $id);
		$query->where($db->quoteName('a.published') . ' = 1');		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{ 
			$results = $db->loadObjectList();
			$layoutString = array();
			foreach ($results as $result)
			{
				switch ($result->gettype)
				{
					case 1:
					// single
					$layoutString[] = "<td><b>".$result->name."</b></td><td><code>&lt;?php echo JLayoutHelper::render('".ComponentbuilderHelper::safeString($result->alias)."', \$this->item); ?&gt;</code></td>";
					break;
					case 2:
					// list
					$layoutString[] = "<td><b>".$result->name."</b></td><td><code>&lt;?php echo JLayoutHelper::render('".ComponentbuilderHelper::safeString($result->alias)."', \$this->items); ?&gt;</code></td>";
					break;
					case 3:
					case 4:
					// custom
					$result->getcustom = ComponentbuilderHelper::safeString($result->getcustom);
					if (substr($result->getcustom, 0, strlen('get')) == 'get')
					{
						$varName = substr($result->getcustom, strlen('get'));
					}
					else
					{
						$varName = $result->getcustom;
					}
					$layoutString[] = "<td><b>".$result->name."</b></td><td><code>&lt;?php echo JLayoutHelper::render('".ComponentbuilderHelper::safeString($result->alias)."', \$this->".$varName."); ?&gt;</code></td>";
					break;
				}
			}
			// build the table
			$table = '<h2>'.JText::_('COM_COMPONENTBUILDER_LAYOUT_CODE_SNIPPETS').'</h2><div class="uk-scrollable-box"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
			$table .= '<caption>'.JText::_('COM_COMPONENTBUILDER_TO_ADD_SIMPLY_COPY_AND_PAST_THE_SNIPPET_INTO_YOUR_CODE').'</caption>';
			$table .= '<thead><tr><th>'.JText::_('COM_COMPONENTBUILDER_NAME_OF_DYNAMICGET').'</th><th>'.JText::_('COM_COMPONENTBUILDER_SNIPPET').'</th></thead>';
			$table .= '<tbody><tr>'.implode("</tr><tr>",$layoutString)."</tr></tbody></table></div>";
		}
		return $table;
	}

	// Used in dynamic_get
	public function getViewTableColumns($admin_view, $as, $type)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.addfields', 'b.name_single')));
		$query->from($db->quoteName('#__componentbuilder_admin_fields', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_admin_view', 'b') . ' ON (' . $db->quoteName('a.admin_view') . ' = ' . $db->quoteName('b.id') . ')');
		$query->where($db->quoteName('b.published') . ' = 1');
		$query->where($db->quoteName('a.admin_view') . ' = '. (int) $admin_view);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$result = $db->loadObject();
			$description = '';
			$tableName = '';
			if (1 == $type)
			{
				$tableName = ComponentbuilderHelper::safeString($result->name_single).'_';
			}
			$addfields = json_decode($result->addfields,true);
			if (ComponentbuilderHelper::checkArray($addfields))
			{
				$fields = array();
				// get data
				foreach ($addfields as $nr => $value)
				{
					$tmp = $this->getFieldData((int) $value['field']);
					if (ComponentbuilderHelper::checkArray($tmp))
					{
						$field[$nr] = $tmp;
					}
					// insure it is set to alias if needed
					if (isset($value['alias']) && $value['alias'] == 1)
					{
						$field[$nr]['name'] = 'alias';
					}
				}
				// add the basic defaults
				$fields[] = $as.".id AS ".$tableName."id";
				$fields[] = $as.".asset_id AS ".$tableName."asset_id";
				// load data
				foreach ($field as $n => $f)
				{
					if (ComponentbuilderHelper::checkArray($f))
					{
						$fields[] = $as.".".$f['name']." AS ".$tableName.$f['name'];
					}
				}
				// add the basic defaults
				$fields[] = $as.".published AS ".$tableName."published";
				$fields[] = $as.".created_by AS ".$tableName."created_by";
				$fields[] = $as.".modified_by AS ".$tableName."modified_by";
				$fields[] = $as.".created AS ".$tableName."created";
				$fields[] = $as.".modified AS ".$tableName."modified";
				$fields[] = $as.".version AS ".$tableName."version";
				$fields[] = $as.".hits AS ".$tableName."hits";
				if (0)
				{
					$fields[] = $as.".access AS ".$tableName."access";
				}
				$fields[] = $as.".ordering AS ".$tableName."ordering";
				$viewFields = $description.implode("\n",$fields);
			}
			return $viewFields;
		}
		return false;
	}

	protected function getFieldData($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		
		// Order it by the ordering field.
		$query->select($db->quoteName(array('a.name','a.xml')));
		$query->select($db->quoteName(array('c.name'),array('type_name')));
		$query->from('#__componentbuilder_field AS a');
		$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 'c') . ' ON (' . $db->quoteName('a.fieldtype') . ' = ' . $db->quoteName('c.id') . ')');
		$query->where($db->quoteName('a.id') . ' = '. $db->quote($id));
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$field = $db->loadObject();
			// load the values form params
			$field->xml = json_decode($field->xml);
			$field->type_name = ComponentbuilderHelper::safeString($field->type_name);
			$load = true;
			// if category then name must be catid (only one per view)
			if ($field->type_name == 'category')
			{
				$name = 'catid';
				
			}
			// if tag is set then enable all tag options for this view (only one per view)
			elseif ($field->type_name == 'tag')
			{
				$name = 'tags';
			}
			// don't add spacers or notes
			elseif ($field->type_name == 'spacer' || $field->type_name == 'note')
			{
				// make sure the name is unique
				return false;
			}
			else
			{
				$name = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field->xml,'name="','"'));
			}
			
			// use field core name only if not found in xml
			if (!ComponentbuilderHelper::checkString($name))
			{
				$name = ComponentbuilderHelper::safeString($field->name);;
			}
			return array('name' => $name, 'type' => $field->type_name);
		}
		return false;
	}
    
	public function getDbTableColumns($tableName, $as, $type)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
        	// get the columns
		$columns = $db->getTableColumns("#__".$tableName);
		// set the type (multi or single)
		$unique = ''; 
		if (1 == $type)
		{
			$unique = ComponentbuilderHelper::safeString($tableName).'_';
		}
		if (ComponentbuilderHelper::checkArray($columns))
		{
        		// build the return string
			$tableColumns = array();
			foreach ($columns as $column => $typeCast)
			{
				$tableColumns[] =  $as.".".$column . ' AS ' . $unique . $column;
			}
			return implode("\n",$tableColumns);
		}
		return false;
	}

	public function getDynamicValues($id, $view)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('getcustom', 'gettype', 'main_source', 'view_selection', 'db_selection', 'join_view_table', 'join_db_table', 'addcalculation', 'php_calculation')));
		$query->from($db->quoteName('#__componentbuilder_dynamic_get'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->where($db->quoteName('id') . ' = '. (int) $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$result = $db->loadObject();
			// reset buket
			$selections = array();
			$selectionsList = array();
			// get the main values (name)
			if ($result->main_source == 1)
			{
				$selections[] = explode("\n",$result->view_selection);
			}
			elseif ($result->main_source == 2) 
			{
				$selections[] = explode("\n",$result->db_selection);
			}
			elseif ($result->main_source == 3)
			{
				return '<br /><br /><h2>Custom get source! You will need to transpose the variables manually.</h2>';
			}
			// get the joined values (name)
			$result->join_view_table = json_decode($result->join_view_table, true);
			if (!ComponentbuilderHelper::checkArray($result->join_view_table))
			{
				unset($result->join_view_table);
			}
			$result->join_db_table = json_decode($result->join_db_table, true);
			if (!ComponentbuilderHelper::checkArray($result->join_db_table))
			{
				unset($result->join_db_table);
			}
			// now load the joined values to the selection set
			if (isset($result->join_view_table) && ComponentbuilderHelper::checkArray($result->join_view_table))
			{
				foreach ($result->join_view_table as $join_view_table)
				{
					if ($join_view_table['row_type'] == '1')
					{
						$selections[] = explode("\n",$join_view_table['selection']);
					}
					elseif ($join_view_table['row_type'] == '2')
					{
						$names = $this->setListMethodName(array($join_view_table['on_field'],$join_view_table['join_field']),$join_view_table['view_table'],$join_view_table['as'],1);
						$selectionsList[implode('',$names)] = explode("\n",$join_view_table['selection']);
					}
				}
				unset($result->join_view_table);
			}
			if (isset($result->join_db_table) && ComponentbuilderHelper::checkArray($result->join_db_table))
			{
				foreach ($result->join_db_table as $join_db_table)
				{
					if ($join_db_table['row_type'] == '1')
					{
						$selections[] = explode("\n",$join_db_table['selection']);
					}
					elseif ($join_db_table['row_type'] == '2')
					{
						$names = $this->setListMethodName(array($join_db_table['on_field'],$join_db_table['join_field']),$join_db_table['db_table'],$join_db_table['as'],2);
						$selectionsList[implode('',$names)] = explode("\n",$join_db_table['selection']);
					}
				}
				unset($result->join_db_table);
			}
			// get the calculation result values (name)
			if ($result->addcalculation == 1)
			{
				$php_calculation = base64_decode($result->php_calculation);
				$phpSelections = ComponentbuilderHelper::getAllBetween($php_calculation,'cal__',' ');
				$selections[] = array_unique($phpSelections);
				unset($php_calculation);
				unset($phpSelections);
				unset($result->php_calculation);
			}
			// name the main var based on view
			if ('template' === $view || 'site_view' === $view || 'custom_admin_view' === $view)
			{
				switch ($result->gettype)
				{
					case 1:
					// single
					$buketName = 'this->item';
					break;
					case 2:
					// list
					$buketName = 'this->items';
					break;
					case 3:
					case 4:
					// custom
					$result->getcustom = ComponentbuilderHelper::safeString($result->getcustom);
					if (substr($result->getcustom, 0, strlen('get')) == 'get')
					{
						$varName = substr($result->getcustom, strlen('get'));
					}
					else
					{
						$varName = $result->getcustom;
					}
					$buketName = 'this->'.$varName;
					break;
				}
			}
			elseif ($view == 'layout')
			{
				$buketName = 'displayData';
			}
			// now build the return values
			if (ComponentbuilderHelper::checkArray($selections))
			{
				$buket = array();
				switch ($result->gettype)
				{
					case 1:
					case 3:
					// single
					$ur = '&lt;?php echo $'.$buketName;
					$cf = '; ?&gt;';
					break;
					case 2:
					case 4:
					// list
					$ur = '&lt;?php echo $item';
					$cf = '; ?&gt;';
					$buket[] = '<code>&lt;?php foreach ($'.$buketName.' as $item): ?&gt;</code><br />';
					break;
				}
				foreach ($selections as $selection)
				{
					if (ComponentbuilderHelper::checkArray($selection))
					{
						foreach ($selection as $value)
						{
							if (strpos($value,'AS') !== false)
							{
								list($table,$key) = explode('AS',$value);
								$buket[] = '<code>'.$ur.'->'.trim($key).$cf.'</code>';
							}
							else
							{
								$buket[] = '<code>'.$ur.'->'.trim($value).$cf.'</code>';
							}
						}
					}
				}
				if (ComponentbuilderHelper::checkArray($selectionsList))
				{
					$buket[] = '<hr />';
					foreach ($selectionsList as $name => $selectionList)
					{
						if (ComponentbuilderHelper::checkArray($selectionList))
						{
							$ur = '&lt;?php echo $'.$name;
							$cf = '; ?&gt;';
							$buket[] = '<code>&lt;?php foreach ($item->'.$name.' as $'.$name.'): ?&gt;</code><br />';
							foreach ($selectionList as $value)
							{
								if (strpos($value,'AS') !== false)
								{
									list($table,$key) = explode('AS',$value);
									$buket[] = '<code>'.$ur.'->'.trim($key).$cf.'</code>';
								}
								else
								{
									$buket[] = '<code>'.$ur.'->'.trim($value).$cf.'</code>';
								}
							}
							$buket[] = '<br /><code>&lt;?php endforeach; ?&gt;</code><hr />';
						}
					}
				}
				switch ($result->gettype)
				{
					case 2:
					case 4:
					// list
					$buket[] = '<br /><code>&lt;?php endforeach; ?&gt;</code>';
					break;
				}
				return implode('&nbsp;',$buket);
			}			
		}
		return false;
	}
	
	protected function setListMethodName($names, $table, $as, $type)
	{
		$methodNames = array();
		if (ComponentbuilderHelper::checkArray($names))
		{
			foreach ($names as $nr => $name)
			{
				if (ComponentbuilderHelper::checkString($name))
				{
					if (strpos($name,'.') !== false)
					{
						list($dump,$var) = explode('.',$name);
					}
					else
					{
						$var = $name;
					}
					if ($nr > 0)
					{
						$methodNames[] = ComponentbuilderHelper::safeString($var,'F');
					}
					else
					{
						$methodNames[] = ComponentbuilderHelper::safeString($var);
					}
				}
			}
		}
		switch ($type)
		{
			// set view name
			case 1:
			$methodNames[] = ComponentbuilderHelper::safeString($this->getViewName($table),'F');
			break;
			// set db name
			case 2:
			$methodNames[] = ComponentbuilderHelper::safeString($table,'F');
			break;
			
		}
		// make sure there is uniqe method names
		$methodNames[] = ComponentbuilderHelper::safeString($as,'U');
		return $methodNames;
	}
	
	protected function getViewName($id)
	{
		// Get the view name
		if ($name = ComponentbuilderHelper::getVar('admin_view', (int) $id, 'id', 'name_single'))
		{
			return $name;
		}
		return '';
	}

	// Used in custom_code
	public function checkFunctionName($name, $id)
	{
		$nameArray = (array) $this->splitAtUpperCase($name);
		$name = ComponentbuilderHelper::safeString(implode(' ', $nameArray), 'cA');
		if ($found = ComponentbuilderHelper::getVar('custom_code', $name, 'function_name', 'id'))
		{
			if ((int) $id !== (int) $found)
			{
				return array (
					'message' => JText::_('COM_COMPONENTBUILDER_SORRY_THIS_FUNCTION_NAME_IS_ALREADY_IN_USE'),
					'status' => 'danger');
			}
		}
		return array (
			'name' => $name,
			'message' => JText::_('COM_COMPONENTBUILDER_GREAT_THIS_FUNCTION_NAME_WILL_WORK'),
			'status' => 'success');
	}

	protected function splitAtUpperCase($string)
	{
		return preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY);
	}

	public function usedin($functioName, $id, $targeting)
	{
		// get the table being targeted
		if ($target = $this->getCodeSearchKeys($targeting, 'query'))
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select($db->quoteName($target['select']))
				->from($db->quoteName('#__componentbuilder_' . $target['table'], 'a'));
			if (strpos($target['name'], '->') !== false && strpos($target['name'], ':') !== false && strpos($target['name'], '.') !== false)
			{
				// joomla_component->id:joomla_component.system_name (example)
				$targetJoin = explode('->', $target['name']);
				// get keys
				$targetKeys = explode(':', $targetJoin[1]);
				// get table.name
				$table_name = explode('.', $targetKeys[1]);
				// select the correct name
				$query->select($db->quoteName(array('c.'.$table_name[1]), array($targetJoin[0])));
				// add some special fetch
				$query->join('LEFT', $db->quoteName('#__componentbuilder_' . $table_name[0], 'c') . ' ON (' . $db->quoteName('a.'.$targetJoin[0]) . ' = ' . $db->quoteName('c.'.$targetKeys[0]) . ')');
				// set the correct name
				$target['name'] = $targetJoin[0];
			}
			$db->setQuery($query);
			$db->execute();
			if ($db->loadRowList())
			{
				$bucket = array();
				$hugeDataSet = $db->loadAssocList();
				foreach ($hugeDataSet as $data)
				{
					foreach ($data as $key => $value)
					{
						if ('id' !== $key && $target['name'] !== $key)
						{
							if (!isset($target['not_base64'][$key]))
							{
								$value = base64_decode($value);
							}
							// check if place holder set
							if (strpos($value, '[CUSTOMC' . 'ODE=' . (string) $functioName . ']') !== false || strpos($value, '[CUSTOMC' . 'ODE=' . (int) $id . ']') !== false ||
							strpos($value, '[CUSTOMC' . 'ODE=' . (string) $functioName . '+') !== false || strpos($value, '[CUSTOMC' . 'ODE=' . (int) $id . '+') !== false)
							{
								// found it so add to bucket
								if (!isset($bucket[$data['id']]))
								{
									$bucket[$data['id']] = array();
									$bucket[$data['id']]['name'] = $data[$target['name']];
									$bucket[$data['id']]['fields'] = array();
								}
								$bucket[$data['id']]['fields'][] = $key;
							}
						}
					}
				}
				// check if any values found
				if (ComponentbuilderHelper::checkArray($bucket))
				{
					$usedin = array();
					foreach ($bucket as $editId => $values)
					{
						$usedin[] = '<a href="index.php?option=com_componentbuilder&ref=custom_code&refid=' . (int) $id . '&view=' . $target['view'] . '&task=' . $target['table'] . '.edit&id=' . (int) $editId . '">' . $values['name'] . '</a> (' . implode(', ', $values['fields']) . ')';
					}
					$html = '<ul><li>' . implode('</li><li>', $usedin) . '</li></ul>';
					return array('in' => $html, 'id' => $targeting);
				}
			}
		}
		return false;
	}

	/**
	* Get the keys of the values to search custom code in
	*
	*  @param   string    $targe  The table targeted
	*  @param   string    $type   The type of get
	* 
	*  @return  array      The query options
	* 
	*/
	protected function getCodeSearchKeys($target, $type = null)
	{
		// set the template if type is query
		if ('query' === $type)
		{
			$tables = array(
				'a' => 'joomla_component',
				'b' => 'admin_view',
				'c' => 'custom_admin_view',
				'd' => 'site_view',
				'e' => 'field',
				'f' => 'dynamic_get',
				'g' => 'template',
				'h' => 'layout',
				'i' => 'component_dashboard',
				'j' => 'library',
			);
			// check if we have a match
			if (isset($tables[$target]))
			{
				$target = $tables[$target];
			}
		}
		// start target arrays
		$targets = array();
		// #__componentbuilder_joomla_component
		$targets['joomla_component'] = array();
		$targets['joomla_component']['search'] = array('id', 'system_name', 'php_preflight_install','php_postflight_install',
			'php_preflight_update','php_postflight_update','php_method_uninstall',
			'php_helper_admin','php_admin_event','php_helper_both','php_helper_site',
			'php_site_event','javascript');
		$targets['joomla_component']['view'] = 'joomla_components';
		$targets['joomla_component']['not_base64'] = array();
		$targets['joomla_component']['name'] = 'system_name';

		// #__componentbuilder_component_dashboard
		$targets['component_dashboard'] = array();
		$targets['component_dashboard']['search'] = array('id', 'joomla_component', 'php_dashboard_methods','dashboard_tab');
		$targets['component_dashboard']['view'] = 'components_dashboard';
		$targets['component_dashboard']['not_base64'] = array('dashboard_tab' => 'json');
		$targets['component_dashboard']['name'] = 'joomla_component->id:joomla_component.system_name';

		// #__componentbuilder_admin_view
		$targets['admin_view'] = array();
		$targets['admin_view']['search'] = array('id', 'system_name', 'javascript_view_file','javascript_view_footer',
			'javascript_views_file','javascript_views_footer','html_import_view',
			'php_after_delete','php_after_publish','php_ajaxmethod','php_allowedit','php_batchcopy',
			'php_batchmove','php_before_delete','php_before_publish','php_before_save','php_controller',
			'php_controller_list','php_document','php_getitem','php_getitems','php_getitems_after_all',
			'php_getlistquery','php_import','php_import_display','php_import_ext','php_import_headers',
			'php_import_save','php_import_setdata','php_model','php_model_list','php_postsavehook','php_save');
		$targets['admin_view']['view'] = 'admin_views';
		$targets['admin_view']['not_base64'] = array();
		$targets['admin_view']['name'] = 'system_name';

		// #__componentbuilder_custom_admin_view
		$targets['custom_admin_view'] = array();
		$targets['custom_admin_view']['search'] = array('id', 'system_name', 'default','php_view','php_jview','php_jview_display','php_document',
			'js_document','css_document','css','php_ajaxmethod','php_model','php_controller');
		$targets['custom_admin_view']['view'] = 'custom_admin_views';
		$targets['custom_admin_view']['not_base64'] = array();
		$targets['custom_admin_view']['name'] = 'system_name';

		// #__componentbuilder_site_view
		$targets['site_view'] = array();
		$targets['site_view']['search'] = array('id', 'system_name', 'default','php_view','php_jview','php_jview_display','php_document',
			'js_document','css_document','css','php_ajaxmethod','php_model','php_controller');
		$targets['site_view']['view'] = 'site_views';
		$targets['site_view']['not_base64'] = array();
		$targets['site_view']['name'] = 'system_name';

		// #__componentbuilder_field
		$targets['field'] = array();
		$targets['field']['search'] = array('id', 'name', 'xml','javascript_view_footer','javascript_views_footer');
		$targets['field']['view'] = 'fields';
		$targets['field']['not_base64'] = array('xml' => 'json');
		$targets['field']['name'] = 'name';

		// #__componentbuilder_dynamic_get
		$targets['dynamic_get'] = array();
		$targets['dynamic_get']['search'] = array('id', 'name', 'php_before_getitem','php_after_getitem','php_before_getitems','php_after_getitems',
			'php_getlistquery');
		$targets['dynamic_get']['view'] = 'dynamic_gets';
		$targets['dynamic_get']['not_base64'] = array();
		$targets['dynamic_get']['name'] = 'name';

		// #__componentbuilder_template
		$targets['template'] = array();
		$targets['template']['search'] = array('id', 'name', 'php_view','template');
		$targets['template']['view'] = 'templates';
		$targets['template']['not_base64'] = array();
		$targets['template']['name'] = 'name';

		// #__componentbuilder_layout
		$targets['layout'] = array();
		$targets['layout']['search'] = array('id', 'name', 'php_view','layout');
		$targets['layout']['view'] = 'layouts';
		$targets['layout']['not_base64'] = array();
		$targets['layout']['name'] = 'name';

		// #__componentbuilder_library
		$targets['library'] = array();
		$targets['library']['view'] = 'libraries';
		$targets['library']['search'] = array('id', 'name', 'php_setdocument');
		$targets['library']['view'] = 'libraries';
		$targets['library']['not_base64'] = array();
		$targets['library']['name'] = 'name';

		// return result ready for a.query
		if ('query' === $type && isset($targets[$target]))
		{
			// add the .a to the selection array
			$targets[$target]['select'] = array_map( function($select) { return 'a.'.$select; }, $targets[$target]['search']);
			// also set the table
			$targets[$target]['table'] = $target;
			// remove search
			unset($targets[$target]['search']);
			// return
			return $targets[$target];
		}
		// return the query string to search
		elseif (isset($targets[$target]))
		{
			// remove name and id
			return $targets[$target];
		}
		return false;
	}

	// Used in validation_rule
	public function getExistingValidationRuleCode($name)
	{
		// make sure we have all the exiting rule names
		if ($names = ComponentbuilderHelper::getExistingValidationRuleNames())
		{
			// check that this is a valid rule file
			if (ComponentbuilderHelper::checkArray($names) && in_array($name, $names))
			{
				// get the full path to rule file
				$path = JPATH_LIBRARIES . '/src/Form/Rule/'.$name.'Rule.php';
				// get all the code
				if ($code = ComponentbuilderHelper::getFileContents($path))
				{
					// remove the class details and the ending }
					$codeArray = (array) explode("FormRule\n{\n", $code);
					if (isset($codeArray[1]))
					{
						return array('values' => rtrim(rtrim(rtrim($codeArray[1]),'}')));
					}
				}
			}
		}
		return false;
	}

	public function checkRuleName($name, $id)
	{
		$name = ComponentbuilderHelper::safeString($name);
		if ($found = ComponentbuilderHelper::getVar('validation_rule', $name, 'name', 'id'))
		{
			if ((int) $id !== (int) $found)
			{
				return array (
					'message' => JText::sprintf('COM_COMPONENTBUILDER_SORRY_THIS_VALIDATION_RULE_NAME_S_ALREADY_EXIST_IN_YOUR_SYSTEM', $name),
					'status' => 'danger',
					'timeout' => 6000);
			}
		}
		// now check the existing once
		if ($names = ComponentbuilderHelper::getExistingValidationRuleNames(true))
		{
			if (in_array($name, $names))
			{
				return array (
					'message' => JText::sprintf('COM_COMPONENTBUILDER_SORRY_THIS_VALIDATION_RULE_NAME_S_ALREADY_EXIST_AS_PART_OF_THE_JOOMLA_CORE_NO_NEED_TO_CREATE_IT_IF_YOU_ARE_ADAPTING_IT_GIVE_IT_YOUR_OWN_UNIQUE_NAME', $name),
					'status' => 'danger',
					'timeout' => 10000);
			}
		}
		return array (
			'name' => $name,
			'message' => JText::sprintf('COM_COMPONENTBUILDER_GREAT_THIS_VALIDATION_RULE_NAME_S_WILL_WORK', $name),
			'status' => 'success',
			'timeout' => 5000);
	}

	public function getValidationRulesTable($id)
	{
		// get all the validation rules
		if ($rules = $this->getValidationRules())
		{
			// build table
			$table =  '<div class="control-group"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
			$table .=  '<caption>'.JText::sprintf('COM_COMPONENTBUILDER_THE_AVAILABLE_VALIDATION_RULES_FOR_THE_VALIDATE_ATTRIBUTE_ARE').'</caption>';
			$table .=  '<thead><tr><th class="uk-text-right">'.JText::_('COM_COMPONENTBUILDER_VALIDATE').'</th><th>'.JText::_('COM_COMPONENTBUILDER_DESCRIPTION').'</th></tr></thead>';
			$table .=  '<tbody>';
			foreach ($rules as $name => $decs)
			{
				// just load the values
				$decs = (ComponentbuilderHelper::checkString($decs) && !is_numeric($decs)) ? $decs : '';
				$table .=  '<tr><td class="uk-text-right"><code>'.$name.'</code></td><td>'. $decs. '</td></tr>';
			}
			return $table.'</tbody></table></div>';
		}
		return false;
	}

	public function getValidationRules()
	{
		// custom rule names
		$names = array();
		// make sure we have all the exiting rule names
		if (!$exitingNames = ComponentbuilderHelper::getExistingValidationRuleNames(true))
		{
			// stop (something is wrong)
			return false;
		}
		// convert names to keys
		$exitingNames = array_flip($exitingNames);
		// load the descriptions (taken from https://docs.joomla.org/Server-side_form_validation)
		$exitingNames["boolean"] = JText::_("COM_COMPONENTBUILDER_ACCEPTS_ONLY_THE_VALUES_ZERO_ONE_TRUE_OR_FALSE_CASEINSENSITIVE");
		$exitingNames["color"] = JText::_("COM_COMPONENTBUILDER_ACCEPTS_ONLY_EMPTY_VALUES_CONVERTED_TO_ZERO_AND_STRINGS_IN_THE_FORM_RGB_OR_RRGGBB_WHERE_R_G_AND_B_ARE_HEX_VALUES");
		$exitingNames["email"] =  JText::_("COM_COMPONENTBUILDER_ACCEPTS_AN_EMAIL_ADDRESS_SATISFIES_A_BASIC_SYNTAX_CHECK_IN_THE_PATTERN_OF_QUOTXYZZQUOT_WITH_NO_INVALID_CHARACTERS");
		$exitingNames["equals"] = JText::sprintf("COM_COMPONENTBUILDER_REQUIRES_THE_VALUE_TO_BE_THE_SAME_AS_THAT_HELD_IN_THE_FIELD_NAMED_QUOTFIELDQUOT_EGS", '<br /><code>&lt;input<br />&nbsp;&nbsp;type="text"<br />&nbsp;&nbsp;name="email_check"<br />&nbsp;&nbsp;validate="equals"<br />&nbsp;&nbsp;field="email"<br />/&gt;</code>');
		$exitingNames["options"] = JText::_("COM_COMPONENTBUILDER_REQUIRES_THE_VALUE_ENTERED_BE_ONE_OF_THE_OPTIONS_IN_AN_ELEMENT_OF_TYPEQUOTLISTQUOT_THAT_IS_THAT_THE_ELEMENT_IS_A_SELECT_LIST");
		$exitingNames["tel"] = JText::_("COM_COMPONENTBUILDER_REQUIRES_THE_VALUE_TO_BE_A_TELEPHONE_NUMBER_COMPLYING_WITH_THE_STANDARDS_OF_NANPA_ITUT_TRECEONE_HUNDRED_AND_SIXTY_FOUR_OR_IETF_RFCFOUR_THOUSAND_NINE_HUNDRED_AND_THIRTY_THREE");
		$exitingNames["url"] = JText::sprintf("COM_COMPONENTBUILDER_VALIDATES_THAT_THE_VALUE_IS_A_URL_WITH_A_VALID_SCHEME_WHICH_CAN_BE_RESTRICTED_BY_THE_OPTIONAL_COMMASEPARATED_FIELD_SCHEME_AND_PASSES_A_BASIC_SYNTAX_CHECK_EGS", '<br /><code>&lt;input<br />&nbsp;&nbsp;type="text"<br />&nbsp;&nbsp;name="link"<br />&nbsp;&nbsp;validate="url"<br />&nbsp;&nbsp;scheme="http,https,mailto"<br />/&gt;</code>');
		$exitingNames["username"] = JText::_("COM_COMPONENTBUILDER_VALIDATES_THAT_THE_VALUE_DOES_NOT_APPEAR_AS_A_USERNAME_ON_THE_SYSTEM_THAT_IS_THAT_IT_IS_A_VALID_NEW_USERNAME_DOES_NOT_SYNTAX_CHECK_IT_AS_A_VALID_NAME");
		// now get the custom created rules
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.name','a.short_description')));
		$query->from($db->quoteName('#__componentbuilder_validation_rule','a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$names = $db->loadAssocList('name', 'short_description');
		}
		// merge the arrays
		$rules = ComponentbuilderHelper::mergeArrays(array($exitingNames, $names));
		// sort the array
		 ksort($rules);
		// return the validation rules
		return $rules;
	}

	// Used in field
	public function getFieldOptions($id)
	{
		if ($field = ComponentbuilderHelper::getFieldOptions($id, 'id'))
		{
			// return found field options
			return $field;
		}
		return false;
	}

	// Used in get_snippets

	public function getSnippets($libraries)
	{
		if (ComponentbuilderHelper::checkJson($libraries))
		{
			$libraries = json_decode($libraries, true);
		}
		// check if we have an array
		if (ComponentbuilderHelper::checkArray($libraries))
		{
			// insure we only have int values
			if ($libraries = $this->checkLibraries($libraries))
			{
				// Get a db connection.
				$db = JFactory::getDbo();
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->select($db->quoteName( array('a.id') ));
				$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));
				$query->where($db->quoteName('a.published') . ' = 1');
				// check for country and region
				$query->where($db->quoteName('a.library') . ' IN ('. implode(',',$libraries) .')');
				$db->setQuery($query);
				$db->execute();
				if ($db->getNumRows())
				{
					return $db->loadColumn();
				}
			}
		}
		return false;
	}

	protected function checkLibraries($libraries)
	{
		$bucket = array();
		$libraries = array_map( function($id) use (&$bucket) { 
			// now get bundled libraries
			$type = ComponentbuilderHelper::getVar('library', (int) $id, 'id', 'type');
			if (2 == $type && $bundled = ComponentbuilderHelper::getVar('library', (int) $id, 'id', 'libraries'))
			{
				// make sure we have an array if it was json
				if (ComponentbuilderHelper::checkJson($bundled))
				{
					$bundled = json_decode($bundled, true);
				}
				// load in the values if we have an array
				if (ComponentbuilderHelper::checkArray($bundled))
				{
					foreach ($bundled as $lib)
					{
						$bucket[$lib] = $lib;
					}
				}
				elseif (is_numeric($bundled))
				{
					$bucket[(int) $bundled] = (int) $bundled;
				}
			}
			else
			{
				return (int) $id;
			}
		}, $libraries);
		// check if we have any bundled libraries
		if (ComponentbuilderHelper::checkArray($bucket))
		{
			foreach ($bucket as $lib)
			{
				$libraries[] = (int) $lib;
			}
		}
		// check that we have libraries
		if (ComponentbuilderHelper::checkArray($libraries))
		{
			$libraries = array_values(array_unique(array_filter($libraries, function($id){return is_int($id);})));
			// check if we have any libraries remaining
			if (ComponentbuilderHelper::checkArray($libraries))
			{
				return $libraries;
			}
		}
		return false;
	}
	public function getSnippetDetails($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.name', 'a.heading', 'a.usage', 'a.description', 'b.name', 'a.snippet', 'a.url', 'c.name'), array('name', 'heading', 'usage', 'description', 'type', 'snippet', 'url', 'library')));
		$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));
		// From the componentbuilder_snippet_type table.
		$query->join('LEFT', $db->quoteName('#__componentbuilder_snippet_type', 'b') . ' ON (' . $db->quoteName('a.type') . ' = ' . $db->quoteName('b.id') . ')');
		// From the componentbuilder_library table.
		$query->join('LEFT', $db->quoteName('#__componentbuilder_library', 'c') . ' ON (' . $db->quoteName('a.library') . ' = ' . $db->quoteName('c.id') . ')');
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$snippet = $db->loadObject();
			$snippet->snippet = base64_decode($snippet->snippet);
			// return found snippet settings
			return $snippet;
		}
		return false;
	}

	public function setSnippetGithub($path, $status)
	{
		// get user
		$user = JFactory::getUser();
		$access = $user->authorise('snippet.access', 'com_componentbuilder');
		if ($access)
		{
			// secure path
			$path = ComponentbuilderHelper::safeString(str_replace('.json','',$path), 'filename', '', false).'.json';
			// set url
			$url = ComponentbuilderHelper::$snippetPath.rawurlencode(basename($path));
			// get the snippets
			$snippet = ComponentbuilderHelper::getFileContents($url);
			if (ComponentbuilderHelper::checkJson($snippet))
			{
				return $this->saveSnippet(json_decode($snippet, true), $status, $user);
			}
			return array('message' => JText::_('COM_COMPONENTBUILDER_ERROR_THE_PATH_HAS_A_MISMATCH_AND_COULD_THEREFORE_NOT_RETRIEVE_THE_SNIPPET_FROM_GITHUB'), 'status' => 'danger');
		}
		return array('message' => JText::_('COM_COMPONENTBUILDER_ERROR_YOU_DO_NOT_HAVE_ACCESS_TO_THE_SNIPPETS'), 'status' => 'danger');
	}

	protected function saveSnippet($item, $status, $user)
	{
		// set some defaults
		$todayDate = JFactory::getDate()->toSql();
		// get the type id
		$item['type'] = ($id = ComponentbuilderHelper::getVar('snippet_type', $item['type'], 'name', 'id')) ? $id : $this->createNew($item['type'], 'snippet_type', $user, $todayDate);
		// get the library id
		$item['library'] = ($id = ComponentbuilderHelper::getVar('library', $item['library'], 'name', 'id')) ? $id : $this->createNew($item['library'], 'library', $user, $todayDate);
		// remove type if zero
		if ($item['type'] == 0)
		{
			unset($item['type']);
		}
		// remove library if zero
		if ($item['library'] == 0)
		{
			unset($item['library']);
		}
		// get the snippet ID
		$item['id'] = $this->getSnippetId($item);
		if ($item['id'] == 0)
		{
			$canCreate = $user->authorise('snippet.create', 'com_componentbuilder');
			if ('new' === $status && !$canCreate)
			{
				return array('message' => JText::_('COM_COMPONENTBUILDER_ERROR_YOU_DO_NOT_HAVE_PERMISSION_TO_CREATE_THE_SNIPPET'), 'status' => 'danger');
			}
		}
		// get the snippet model
		$model = ComponentbuilderHelper::getModel('snippet', JPATH_COMPONENT_ADMINISTRATOR);
		// save the snippet
		if ($model->save($item))
		{
			if ($item['id'] == 0)
			{
				// get the saved item
				$updatedItem = $model->getItem();
				$item['id']= $updatedItem->get('id');
			}
			// we have to force modified date since the model does not allow you
			if ($this->forchDateFix($item))
			{
				return array('message' => JText::_('COM_COMPONENTBUILDER_SUCCESS_THE_SNIPPET_WAS_SAVED'), 'status' => 'success');
			}
			// return error
			return array('message' => JText::_('COM_COMPONENTBUILDER_SUCCESS_THE_SNIPPET_WAS_SAVED_BUT_THE_MODIFIED_DATE_COULD_NOT_BE_ADJUSTED_BR_BR_BTHIS_MEANS_THE_SNIPPETS_WILL_CONTINUE_TO_APPEAR_OUT_OF_DATEB'), 'status' => 'warning');
		}
		// return error
		return array('message' => JText::_('COM_COMPONENTBUILDER_ERROR_THE_SNIPPET_IS_FAULTY_AND_COULD_NOT_BE_SAVED'), 'status' => 'danger');
	}

	protected function forchDateFix($item)
	{
		$object = new stdClass();
		$object->id = (int) $item['id'];
		$object->created = $item['created'];
		$object->modified = $item['modified'];
		// force update
		return JFactory::getDbo()->updateObject('#__componentbuilder_snippet', $object, 'id');
	}

	protected function getSnippetId($item)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id')));
		$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));
		$query->where($db->quoteName('a.name') . ' = ' . (string) $db->quote($item['name']));
		if (is_numeric($item['type']))
		{
			$query->where($db->quoteName('a.type') . ' = ' . (int) $item['type']);
		}
		if (is_numeric($item['library']))
		{
			$query->where($db->quoteName('a.library') . ' = ' . (int) $item['library']);
		}
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			return $db->loadResult();
		}
		return 0;
	}

	protected function createNew($name, $type, $user, $todayDate)
	{
		// verify that we can continue
		if (ComponentbuilderHelper::getActions($type)->get('core.create'))
		{
			// get the snippet model
			$model = ComponentbuilderHelper::getModel($type, JPATH_COMPONENT_ADMINISTRATOR);
			// build array to save
			$item['id'] = 0;
			$item['name'] = $name;
			$item['published'] = 1;
			$item['version'] = 1;
			$item['created'] = $todayDate;
			$item['created_by'] = $user->id;
			// save the new
			$model->save($item);
			// get the saved item
			$item = $model->getItem();
			return $item->get('id');
		}
		return 0;
	}
}
