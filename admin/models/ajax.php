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

	@version		2.4.6
	@build			28th May, 2017
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
		$path_filename = ComponentbuilderHelper::getFilePath('user', 'notice', JFactory::getUser()->username, $fileType = '.md', JPATH_COMPONENT_ADMINISTRATOR);
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
		$path_filename = ComponentbuilderHelper::getFilePath('user', 'notice', JFactory::getUser()->username, $fileType = '.md', JPATH_COMPONENT_ADMINISTRATOR);
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

	// Used in admin_view
	public static function getImportScripts($type)
	{
		// get from global helper
		return ComponentbuilderHelper::getImportScripts($type);
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
	
	public function getDynamicValues($id,$view)
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
			$join_view_table = json_decode($result->join_view_table,true);
			unset($result->join_view_table);
			if (ComponentbuilderHelper::checkArray($join_view_table))
			{
				foreach ($join_view_table as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$result->join_view_table[$nr][$option] = $value;
					}
				}
			}
			unset($join_view_table);
			$join_db_table = json_decode($result->join_db_table,true);
			unset($result->join_db_table);
			if (ComponentbuilderHelper::checkArray($join_db_table))
			{
				foreach ($join_db_table as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$result->join_db_table[$nr][$option] = $value;
					}
				}
			}
			unset($join_db_table);
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
			// get the calculation reult values (name)
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
			if ($view == 'template')
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

	public function getDynamicFormDetails($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.name','a.name_code','a.filterbuilder_map')));
		$query->from($db->quoteName('#__componentbuilder_dynamic_form', 'a'));
		$query->where($db->quoteName('a.id') . ' != '.(int) $id);
		$query->where($db->quoteName('a.published') . ' = 1');
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{ 
			$results = $db->loadObjectList();
			$string = array('<h3>Dynamic Form Links</h3><div class="row-fluid form-horizontal-desktop">');
			foreach ($results as $result)
			{
				$dynamicIds = array();
				$result->filterbuilder_map = base64_decode($result->filterbuilder_map);
				if (ComponentbuilderHelper::checkString($result->filterbuilder_map) && strpos($result->filterbuilder_map, PHP_EOL) !== false)
				{
					$filters = explode(PHP_EOL, $result->filterbuilder_map);
					if (ComponentbuilderHelper::checkArray($filters))
					{
						foreach ($filters as $filter)
						{
							if (strpos($filter, 'Id') !== false || strpos($filter, 'id') !== false)
							{
								list($idkey, $dump) = explode('=>', $filter);
								$dynamicIds[] = "&".trim($idkey)."=&lt;?php echo \$displayData->".trim($idkey)."; ?&gt;";
							}
						}
					}
				}
				$string[] = "<div>dynamicForm: <b>".$result->name."</b><br /><code>&lt;a href=\"index.php?option=com_&#91;&#91;&#91;component&#93;&#93;&#93;&task=form." . $result->name_code . implode('',$dynamicIds) ."&ref=compiler\"&gt;" . $result->name . "&lt;/a&gt;</code></div>";
			}
			$string[] = "</div><hr />";
			return implode("\n",$string);
		}
		return false;
	}
	
	protected function setListMethodName($names,$table,$as,$type)
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
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('name_single')));
		$query->from($db->quoteName('#__componentbuilder_admin_view'));
		$query->where($db->quoteName('id') . ' = '. (int) $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			return $db->loadResult();
		}
		return '';
	}

	// Used in dynamic_get
	public function getViewTableColumns($id,$as,$type)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('addfields','name_single')));
		$query->from($db->quoteName('#__componentbuilder_admin_view'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->where($db->quoteName('id') . ' = '. $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$result = $db->loadObject();
			$description = '';
			if (1 == $type)
			{
				$tableName = ComponentbuilderHelper::safeString($result->name_single).'_';
			}
			else
			{
				$tableName = '';
			}
			$addfields = json_decode($result->addfields,true);
			if (ComponentbuilderHelper::checkArray($addfields))
			{
				$fields = array();
				// get data
				foreach ($addfields as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						if ($option == 'field')
						{
							$value = $this->getFieldData((int) $value);
							if (ComponentbuilderHelper::checkArray($value))
							{
								$field[$nr] = $value;
							}
						}
						elseif ($option == 'alias')
						{
							if ($value == 1)
							{
								$name[$nr] = 'alias';
							}
							else
							{
								$name[$nr] = '';
							}
						}
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
						if (ComponentbuilderHelper::checkString($name[$n]))
						{
							$f['name'] = $name[$n];
						}
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
    
	public function getDbTableColumns($tableName,$as,$type)
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
				$tableColumns[] =  $as.".".$column . ' AS ' . $column;
			}
			return implode("\n",$tableColumns);
		}
		return false;
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
			'php_site_event','php_dashboard_methods','dashboard_tab');
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

	// Used in language_translation
	protected $functionArray = array(
				'translation' => 'checkString',
				'language' => 'getLanguageName');
	
	protected function checkString($header, $value)
	{
		return $value;
	}
	
	protected function getLanguageName($header, $value)
	{
		if ($name = ComponentbuilderHelper::getVar($header, $value, 'langtag', 'name'))
		{
			return $name . ' (' . $value . ')';
		}
		return $value;
	}

	protected function setAutoLangZero()
	{
		// set the headers
		$headers = array(
			'translation' => JText::_('COM_COMPONENTBUILDER_TRANSLATION'),
			'language' => JText::_('COM_COMPONENTBUILDER_LANGUAGE')
		);
		// loop the array
		foreach ($headers as $key => $lang)
		{
			$this->setLanguage($key,$lang);
		}
	}
			
	protected $languageArray = array();

	protected function setLanguage($key,$lang)
	{
		$this->languageArray[$key] = $lang;
	}

	public function getLanguage()
	{
		// return the language string that were set
		return $this->languageArray;
	}
	
	protected function autoLoader()
	{
		$functions = range(0,10);
		foreach ($functions as $function)
		{
			$function = 'setAutoLang'.ComponentbuilderHelper::safeString($function, 'f');
			if (method_exists($this, $function))
			{
				$this->{$function}();
			}
		}
		foreach ($functions as $function)
		{
			$function = 'setAutoFunc'.ComponentbuilderHelper::safeString($function, 'f');
			if (method_exists($this, $function))
			{
				$this->{$function}();
			}
		}
	}

	public function getBuildTable($idName, $oject)
	{
		if (ComponentbuilderHelper::checkJson($oject) && ComponentbuilderHelper::checkString($idName))
		{
			$array = json_decode($oject, true);
			if (ComponentbuilderHelper::checkArray($array))
			{ 
				// make sure we run the autoloader to insure all is set
				$this->autoLoader();
				// set the target headers
				$targetHeaders 	= $this->getLanguage();
				// start table build
				$table 		= '<table id="table_'.$idName.'" class="uk-table" style="margin: 5px 0 20px;"><thead><tr>';
				$rows		= array();				
				foreach ($array as $header => $values)
				{
					if (ComponentbuilderHelper::checkArray($values))
					{
						$targetHeader = (isset($targetHeaders[$header])) ? $targetHeaders[$header] : ComponentbuilderHelper::safeString($header, 'W');
						$table .= '<th style="padding: 10px; text-align: center; border: 1px solid rgb(221, 221, 221);" scope="col">'.$targetHeader.'</th>';

						foreach ($values as $nr => $value)
						{
							// set the value for the row
							$this->setRows($nr, $this->setValue($header, $value), $rows);
						}
					}
				}
				// close header start body
				$table .= '</tr></thead><tbody>';
				// add rows to table
				if (ComponentbuilderHelper::checkArray($rows))
				{
					foreach ($rows as $row)
					{
						$table .= '<tr>'.$row.'</tr>';
					}
				}
				// close the body and table
				$table .= '</tbody></table>';
				// return the table
				return $table;
			}
		}
		return false;
	}

	protected function setValue($header, $value)
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
		// make total stand out
		if ('total' == $header)
		{
			$value = '<b>'.$value.'</b>';
		}
		return $value;
	}

	protected function setRows($nr, $value, &$rows)
	{
		// build rows
		if (!isset($rows[$nr]))
		{
			$rows[$nr] = '<td style="padding: 10px; text-align: center; border: 1px solid rgb(221, 221, 221);">'.$value.'</td>';
		}
		else
		{
			$rows[$nr] .= '<td style="padding: 10px; text-align: center; border: 1px solid rgb(221, 221, 221);">'.$value.'</td>';
		}
	}			
			
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
				'language' => true);

	public function getButton($type)
	{
		if (isset($this->buttonArray[$type]))
		{
			$user = JFactory::getUser();
			// only add if user allowed to create
			if ($user->authorise($type.'.create', 'com_componentbuilder'))
			{
				// get the input from url
				$jinput = JFactory::getApplication()->input;
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
							<a class="btn btn-success vdm-button-new" onclick="UIkit.modal.confirm(\''.JText::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \'index.php?option=com_componentbuilder&amp;view='.$type.'&amp;layout=edit'.$ref.'\' })" href="javascript:void(0)" >
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
}
