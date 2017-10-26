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

	@version		2.5.9
	@build			26th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		ajax.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
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
				'admin_fields' => 'admins_fields',
				'admin_fields_conditions' => 'admins_fields_conditions',
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
			
	public function getButton($type)
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
				// build the button
				$button = '<div class="control-group">
							<div class="control-label">
								<label>' . ucwords($type) . '</label>
							</div>
							<div class="controls">	
								<a class="btn btn-success vdm-button-new" onclick="UIkit.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \'index.php?option=com_componentbuilder&amp;view='.$type.'&amp;layout=edit'.$ref.'\' })" href="javascript:void(0)" >
								<span class="icon-new icon-white"></span> 
									' . JText::_('COM_COMPONENTBUILDER_NEW') . '
								</a>
							</div>
						</div>';
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
				// check if new item
				$ref = '';
				if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
				{
					// only load referal if not new item.
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
						$button[] = '<div class="control-group">';
						$button[] = '<div class="control-label">';
						$button[] = '<label>' . ComponentbuilderHelper::safeString($type, 'Ww') . '</label>';
						$button[] = '</div>';
						$button[] = '<div class="controls">';
					}
					$button[] = '<a class="btn btn-success vdm-button-new" onclick="UIkit.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \''.$editThis.$ref.'\' })" href="javascript:void(0)" >';
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
					return '<div class="control-group"><div class="alert alert-info">' . JText::sprintf('COM_COMPONENTBUILDER_BUTTON_TO_CREATE_S_WILL_SHOW_ONCE_S_IS_SAVED_FOR_THE_FIRST_TIME', ComponentbuilderHelper::safeString($type, 'w'), ComponentbuilderHelper::safeString($values['a_view'], 'w')) . '</div></div>';
				}
			}
		}
		return '';
	}			

	public static function getImportScripts($type)
	{
		// get from global helper
		return ComponentbuilderHelper::getImportScripts($type);
	}

	protected $functionArray = array(
				// Admin View
				'field' => 'setFieldsNames',
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
				'target_field' => 'setFieldsNames',
				'target_behavior' => 'setTargetBehavior',
				'target_relation' => 'setTargetRelation',
				'match_field' => 'setFieldsNames',
				'match_behavior' => 'setMatchBehavior',
				'match_options' => 'setMatchOptions',
				// Joomla Component
				'menu' => 'setYesNo',
				'metadata' => 'setYesNo',
				'default_view' => 'setYesNo',
				'access' => 'setYesNo',
				'mainmenu' => 'setYesNo',
				'dashboard_list' => 'setYesNo',
				'submenu' => 'setYesNo',
				'dashboard_add' => 'setYesNo',
				'checkin' => 'setYesNo',
				'history' => 'setYesNo',
				'port' => 'setYesNo',
				'edit_create_site_view' => 'setYesNo',
				'customadminview' => 'setCustomadminviewNames',
				'adminviews' => 'setAdminviewNames',
				'adminview' => 'setAdminviewNames',
				'siteview' => 'setSiteviewNames',
				'icomoon' => 'setIcoMoon',
				'before' => 'setAdminviewNames');
			
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
					$head[$header] = '<th>' . ComponentbuilderHelper::safeString($header, 'Ww');
				}
			}
			// build the rows
			$rows = array();
			if (ComponentbuilderHelper::checkArray($data) && ComponentbuilderHelper::checkArray($head))
			{
				foreach ($data as $nr => $values)
				{
					foreach ($head as $key => $t)
					{
						// set the value for the row
						if (isset($values[$key]))
						{
							$this->setSubformRows($nr, $this->setSubformValue($key, $values[$key]), $rows);
						}
						else
						{
							$this->setSubformRows($nr, $this->setSubformValue($key, ''), $rows);
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
		$table[] = "\t\t\t\t\t\t". implode("", $head);
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

	protected function setSubformRows($nr, $value, &$rows)
	{
		// build rows
		if (!isset($rows[$nr]))
		{
			$rows[$nr] = '<td>'.$value.'</td>';
		}
		else
		{
			$rows[$nr] .= '<td>'.$value.'</td>';
		}
	}			

	protected $ref;
	protected $fieldsArray = array(
				'admin_fields' => 'addfields',
				'admin_fields_conditions' => 'addconditions',
				'component_admin_views' =>  'addadmin_views',
				'component_site_views' =>  'addsite_views',
				'component_custom_admin_views' =>  'addcustom_admin_views');

	public function getAjaxDisplay($type)
	{
		if (isset($this->fieldsArray[$type]))
		{
			// set type name
			$typeName = ComponentbuilderHelper::safeString($type, 'w');
			// get the view name & id
			$values = $this->getViewID();
			// check if we are in the correct view.
			if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']) && ($values['a_view'] === 'admin_view' || $values['a_view'] === 'joomla_component'))
			{
				$this->ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'];
				// get the field data
				if ($fieldsData = ComponentbuilderHelper::getVar($type, (int) $values['a_id'], $values['a_view'], $this->fieldsArray[$type]))
				{
					// check repeatable conversion
					$this->checkRepeatableConversion($fieldsData, $type, $values['a_id'], $values['a_view']);
					// get the table
					$table = $this->getSubformTable($type, $fieldsData);
					// set notice of bad practice
					$notice = '';
					if ($values['a_view'] === 'admin_view' && isset($this->rowNumber) && $this->rowNumber > 50)
					{
						$notice = '<div class="alert alert-warning">' . JText::sprintf('COM_COMPONENTBUILDER_YOU_HAVE_S_S_ADDING_MORE_THEN_FIFTY_S_IS_CONSIDERED_BAD_PRACTICE_YOUR_S_PAGE_LOAD_IN_JCB_WILL_SLOWDOWN_YOU_SHOULD_CONSIDER_DECOUPLING_SOME_OF_THESE_S', $this->rowNumber, $typeName, $typeName, $typeName, $typeName) . '</div>';
					}
					elseif ($values['a_view'] === 'admin_view' && isset($this->rowNumber))
					{
						$notice = '<div class="alert alert-info">' . JText::sprintf('COM_COMPONENTBUILDER_YOU_HAVE_S_S_ADDING_MORE_THEN_FIFTY_S_IS_CONSIDERED_BAD_PRACTICE', $this->rowNumber, $typeName, $typeName) . '</div>';
					}
					// return table
					return $notice.$table;
				}
			}
			return '<div class="control-group"><div class="alert alert-info">' . JText::sprintf('COM_COMPONENTBUILDER_NO_S_HAVE_BEEN_LINKED_TO_THIS_VIEW_SOON_AS_THIS_IS_DONE_IT_WILL_BE_DISPLAYED_HERE', $typeName) . '</div></div>';
		}
		return '<div class="control-group"><div class="alert alert-error"><h4>' . JText::_('COM_COMPONENTBUILDER_TYPE_ERROR') . '</h4><p>' . JText::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_IF_THIS_CONTINUES_PLEASE_INFORM_YOUR_SYSTEM_ADMINISTRATOR_OF_A_TYPE_ERROR_IN_THE_FIELDS_DISPLAY_REQUEST') . '</p></div></div>';
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

	protected function checkRepeatableConversion(&$fieldsData, $type, $id, $linked_id_name)
	{
		if (ComponentbuilderHelper::checkJson($fieldsData))
		{
			$fieldsData = json_decode($fieldsData, true);
			if (isset($fieldsData[$this->conversionCheck[$this->fieldsArray[$type]]]))
			{
				$bucket = array();
				foreach($fieldsData as $option => $values)
				{
					foreach($values as $nr => $value)
					{
						$bucket[$this->fieldsArray[$type].$nr][$option] = $value;
					}
				}
				$fieldsData = json_encode($bucket);
				// update the fields
				$objectUpdate = new stdClass();
				$objectUpdate->{$linked_id_name} = (int) $id;
				$objectUpdate->{$this->fieldsArray[$type]} = $fieldsData;
				JFactory::getDbo()->updateObject('#__componentbuilder_'.$type, $objectUpdate, 'admin_view');
			}
		}
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

	protected $customadminviewNames = array();

	protected function setCustomadminviewNames($header, $value)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($value))
		{
			foreach ($value as $view)
			{
				if (!isset($this->customadminviewNames[$view]))
				{
					if (!$this->customadminviewNames[$view] =  ComponentbuilderHelper::getVar('custom_admin_view', (int) $view, 'id', 'system_name'))
					{
						$this->customadminviewNames[$view] = JText::_('COM_COMPONENTBUILDER_NO_CUSTOM_ADMIN_VIEW_FOUND');
					}
				}
				$bucket[] = $this->customadminviewNames[$view] . $this->addEditLink($value, 'custom_admin_view', 'custom_admin_views');
			}
		}
		elseif (is_numeric($value))
		{
			if (!isset($this->customadminviewNames[$value]))
			{
				if (!$this->customadminviewNames[$value] =  ComponentbuilderHelper::getVar('custom_admin_view', (int) $value, 'id', 'system_name'))
				{
					$this->customadminviewNames[$value] = JText::_('COM_COMPONENTBUILDER_NO_CUSTOM_ADMIN_VIEW_FOUND');
				}
			}
			$bucket[] = $this->customadminviewNames[$value] . $this->addEditLink($value, 'custom_admin_view', 'custom_admin_views');
		}
		// return found fields
		if (ComponentbuilderHelper::checkArray($bucket))
		{
			return implode('<br />', $bucket);
		}
		return JText::_('COM_COMPONENTBUILDER_NO_CUSTOM_ADMIN_VIEW_FOUND');
	}

	protected $adminviewNames = array();

	protected function setAdminviewNames($header, $value)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($value))
		{
			foreach ($value as $view)
			{
				if (!isset($this->adminviewNames[$view]))
				{
					if (!$this->adminviewNames[$view] =  ComponentbuilderHelper::getVar('admin_view', (int) $view, 'id', 'system_name'))
					{
						$this->adminviewNames[$view] = JText::_('COM_COMPONENTBUILDER_NO_ADMIN_VIEW_FOUND');
					}
				}
				$bucket[] = $this->adminviewNames[$view] . $this->addEditLink($value, 'admin_view', 'admin_views');
			}
		}
		elseif (is_numeric($value))
		{
			if (!isset($this->adminviewNames[$value]))
			{
				if (!$this->adminviewNames[$value] =  ComponentbuilderHelper::getVar('admin_view', (int) $value, 'id', 'system_name'))
				{
					$this->adminviewNames[$value] = JText::_('COM_COMPONENTBUILDER_NO_ADMIN_VIEW_FOUND');
				}
			}
			$bucket[] = $this->adminviewNames[$value] . $this->addEditLink($value, 'admin_view', 'admin_views');
		}
		// return found fields
		if (ComponentbuilderHelper::checkArray($bucket))
		{
			return implode('<br />', $bucket);
		}
		return JText::_('COM_COMPONENTBUILDER_NO_ADMIN_VIEW_FOUND');
	}

	protected $siteviewNames = array();

	protected function setSiteviewNames($header, $value)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($value))
		{
			foreach ($value as $view)
			{
				if (!isset($this->siteviewNames[$view]))
				{
					if (!$this->siteviewNames[$view] =  ComponentbuilderHelper::getVar('site_view', (int) $view, 'id', 'system_name'))
					{
						$this->siteviewNames[$view] = JText::_('COM_COMPONENTBUILDER_NO_SITE_VIEW_FOUND');
					}
				}
				$bucket[] = $this->siteviewNames[$view] . $this->addEditLink($value, 'site_view', 'site_views');
			}
		}
		elseif (is_numeric($value))
		{
			if (!isset($this->siteviewNames[$value]))
			{
				if (!$this->siteviewNames[$value] =  ComponentbuilderHelper::getVar('site_view', (int) $value, 'id', 'system_name'))
				{
					$this->siteviewNames[$value] = JText::_('COM_COMPONENTBUILDER_NO_SITE_VIEW_FOUND');
				}
			}
			$bucket[] = $this->siteviewNames[$value] . $this->addEditLink($value, 'site_view', 'site_views');
		}
		// return found fields
		if (ComponentbuilderHelper::checkArray($bucket))
		{
			return implode('<br />', $bucket);
		}
		return JText::_('COM_COMPONENTBUILDER_NO_SITE_VIEW_FOUND');
	}

	protected $fieldNames = array();

	protected function setFieldsNames($header, $value)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($value))
		{
			foreach ($value as $field)
			{
				if (!isset($this->fieldNames[$field]))
				{
					if (!$this->fieldNames[$field] =  ComponentbuilderHelper::getVar('field', (int) $field, 'id', 'name'))
					{
						$this->fieldNames[$field] = JText::_('COM_COMPONENTBUILDER_NO_FIELD_FOUND');
					}
				}
				$bucket[] = $this->fieldNames[$field] . $this->addEditLink($field, 'field', 'fields');
			}
		}
		elseif (is_numeric($value))
		{
			if (!isset($this->fieldNames[$value]))
			{
				if (!$this->fieldNames[$value] =  ComponentbuilderHelper::getVar('field', (int) $value, 'id', 'name'))
				{
					$this->fieldNames[$value] = JText::_('COM_COMPONENTBUILDER_NO_FIELD_FOUND');
				}
			}
			$bucket[] = $this->fieldNames[$value] . $this->addEditLink($value, 'field', 'fields');
		}
		// return found fields
		if (ComponentbuilderHelper::checkArray($bucket))
		{
			return implode('<br />', $bucket);
		}
		return JText::_('COM_COMPONENTBUILDER_NO_FIELD_FOUND');
	}

	protected function addEditLink($id, $view, $views)
	{
		// can edit
		if ($this->canEdit($id))
		{
			$edit = "index.php?option=com_componentbuilder&view=".$views."&task=".$view.".edit&id=".$id.$this->ref;
			return ' <a onclick="UIkit.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \''.$edit.'\' })"  href="javascript:void(0)" class="uk-icon-pencil"></a>';
			
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
			return JText::_('COM_COMPONENTBUILDER_YES');
		}
		return JText::_('COM_COMPONENTBUILDER_NO');
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
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.xml', 'b.name')));
		$query->from($db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 'b') . ' ON (' . $db->quoteName('a.fieldtype') . ' = ' . $db->quoteName('b.id') . ')');
		$query->where($db->quoteName('a.published') . ' = 1');
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$result		= $db->loadObject();
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
		// Get a db connection.
		$db = JFactory::getDbo();
        	// get the columns
		$columns = $db->getTableColumns("#__".$tableName);
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

	// Used in template
	public function getTemplateDetails($id)
	{
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
			$templateString = array('<h3>Template Code Snippets</h3><div class="row-fluid form-horizontal-desktop">');
			foreach ($results as $result)
			{
				$templateString[] = "<div>dynamicGet: <b>".$result->name."</b><br /><code>&lt;?php echo \$this->loadTemplate('".ComponentbuilderHelper::safeString($result->alias)."'); ?&gt;</code></div>";
			}
			$templateString[] = "</div><hr />";
			return implode("\n",$templateString);
		}
		return false;
	}

	// Used in layout
	public function getLayoutDetails($id)
	{
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
			$layoutString = array('<h3>Layout Code Snippets</h3><div class="row-fluid form-horizontal-desktop">');
			foreach ($results as $result)
			{
				switch ($result->gettype)
				{
					case 1:
					// single
					$layoutString[] = "<div>dynamicGet: <b>".$result->name."</b><br /><code>&lt;?php echo JLayoutHelper::render('".ComponentbuilderHelper::safeString($result->alias)."', \$this->item); ?&gt;</code></div>";
					break;
					case 2:
					// list
					$layoutString[] = "<div>dynamicGet: <b>".$result->name."</b><br /><code>&lt;?php echo JLayoutHelper::render('".ComponentbuilderHelper::safeString($result->alias)."', \$this->items); ?&gt;</code></div>";
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
					$layoutString[] = "<div>dynamicGet: <b>".$result->name."</b><br /><code>&lt;?php echo JLayoutHelper::render('".ComponentbuilderHelper::safeString($result->alias)."', \$this->".$varName."); ?&gt;</code></div>";
					break;
				}
			}
			$layoutString[] = "</div><hr />";
			return implode("\n",$layoutString);
		}
		return false;
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
					if ($value['alias'] == 1)
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
			if ('template' === $view || 'site_view' === $view)
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
		if ($target = $this->getTableQueryOptions($targeting))
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)
				->select($db->quoteName($target['select']))
				->from($db->quoteName('#__componentbuilder_' . $target['table']));
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
	* Get the table query to search for function used in
	*
	*  @param   string    $targe  The table targeted
	* 
	*  @return  array      The query options
	* 
	*/
	protected function getTableQueryOptions($target)
	{
		$query = array();
		// #__componentbuilder_joomla_component as a
		$query['a'] = array();
		$query['a']['table'] = 'joomla_component';
		$query['a']['view'] = 'joomla_components';
		$query['a']['select'] = array('id', 'system_name', 'php_preflight_install','php_postflight_install',
			'php_preflight_update','php_postflight_update','php_method_uninstall',
			'php_helper_admin','php_admin_event','php_helper_both','php_helper_site',
			'php_site_event','php_dashboard_methods','dashboard_tab','javascript');
		$query['a']['not_base64'] = array('dashboard_tab' => 'json');
		$query['a']['name'] = 'system_name';

		// #__componentbuilder_admin_view as b
		$query['b'] = array();
		$query['b']['table'] = 'admin_view';
		$query['b']['view'] = 'admin_views';
		$query['b']['select'] = array('id', 'system_name', 'javascript_view_file','javascript_view_footer','javascript_views_file',
			'javascript_views_footer','php_getitem','php_save','php_postsavehook','php_getitems',
			'php_getitems_after_all','php_getlistquery','php_allowedit','php_before_delete',
			'php_after_delete','php_before_publish','php_after_publish','php_batchcopy',
			'php_batchmove','php_document','php_model','php_controller','php_import_display',
			'php_import','php_import_setdata','php_import_save','html_import_view','php_ajaxmethod');
		$query['b']['not_base64'] = array();
		$query['b']['name'] = 'system_name';

		// #__componentbuilder_custom_admin_view as c
		$query['c'] = array();
		$query['c']['table'] = 'custom_admin_view';
		$query['c']['view'] = 'custom_admin_views';
		$query['c']['select'] = array('id', 'system_name', 'default','php_view','php_jview','php_jview_display','php_document',
			'js_document','css_document','css','php_model','php_controller');
		$query['c']['not_base64'] = array();
		$query['c']['name'] = 'system_name';

		// #__componentbuilder_site_view as d
		$query['d'] = array();
		$query['d']['table'] = 'site_view';
		$query['d']['view'] = 'site_views';
		$query['d']['select'] = array('id', 'system_name', 'default','php_view','php_jview','php_jview_display','php_document',
			'js_document','css_document','css','php_ajaxmethod','php_model','php_controller');
		$query['d']['not_base64'] = array();
		$query['d']['name'] = 'system_name';

		// #__componentbuilder_field as e
		$query['e'] = array();
		$query['e']['table'] = 'field';
		$query['e']['view'] = 'fields';
		$query['e']['select'] = array('id', 'name', 'xml','javascript_view_footer','javascript_views_footer');
		$query['e']['not_base64'] = array('xml' => 'json');
		$query['e']['name'] = 'name';

		// #__componentbuilder_dynamic_get as f
		$query['f'] = array();
		$query['f']['table'] = 'dynamic_get';
		$query['f']['view'] = 'dynamic_gets';
		$query['f']['select'] = array('id', 'name', 'php_before_getitem','php_after_getitem','php_before_getitems','php_after_getitems',
			'php_getlistquery');
		$query['f']['not_base64'] = array();
		$query['f']['name'] = 'name';

		// #__componentbuilder_template as g
		$query['g'] = array();
		$query['g']['table'] = 'template';
		$query['g']['view'] = 'templates';
		$query['g']['select'] = array('id', 'name', 'php_view','template');
		$query['g']['not_base64'] = array();
		$query['g']['name'] = 'name';

		// #__componentbuilder_layout as h
		$query['h'] = array();
		$query['h']['table'] = 'layout';
		$query['h']['view'] = 'layouts';
		$query['h']['select'] = array('id', 'name', 'php_view','layout');
		$query['h']['not_base64'] = array();
		$query['h']['name'] = 'name';

		// return the query string to search
		if (isset($query[$target]))
		{
			return $query[$target];
		}
		return false;
	}

	// Used in snippet
	public function getSnippetDetails($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('name', 'heading', 'usage', 'description', 'type', 'snippet', 'url')));
		$query->from($db->quoteName('#__componentbuilder_snippet'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->where($db->quoteName('id') . ' = '. (int) $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$model = ComponentbuilderHelper::getModel('snippets');
			$snippet = $db->loadObject();
			$snippet->type = JText::_($model->selectionTranslation($snippet->type,'type'));
			$snippet->snippet = base64_decode($snippet->snippet);			
			// return found snippet settings
			return $snippet;
		}
		return false;
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
}
