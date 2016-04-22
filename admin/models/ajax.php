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

	@version		2.1.3
	@build			22nd April, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		ajax.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
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

	// Used in admin_view
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
				$string[] = "<div>dynamicForm: <b>".$result->name."</b><br /><code>&lt;a href=\"index.php?option=com_&#91;&#91;&#91;component&#93;&#93;&#93;&task=form." . $result->name_code . implode('',$dynamicIds) ."&ref=[[[sview]]]\"&gt;" . $result->name . "&lt;/a&gt;</code></div>";
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

	protected function splitAtUpperCase($s) {
       		return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
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

	// Used in field
	public function getFieldOptions($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('properties', 'short_description', 'description')));
		$query->from($db->quoteName('#__componentbuilder_fieldtype'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->where($db->quoteName('id') . ' = '. $id);
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$result = $db->loadObject();
			$properties = json_decode($result->properties,true);
			$pointer = 0;
			$field = array('values' => "<field ", 'values_description' => '<ul>', 'short_description' => $result->short_description, 'description' => $result->description);
			foreach ($properties['name'] as $line)
			{
				$field['values_description'] .= '<li><b>'.$properties['name'][$pointer].'</b> '.$properties['description'][$pointer].'</li>';
				$field['values'] .= "\n\t".$properties['name'][$pointer].'="'.$properties['example'][$pointer].'" ';
				$pointer++;
			}
			$field['values'] .= "\n/>";
			$field['values_description'] .= '</ul>';
			// return found field options
			return $field;
		}
		return false;
	}
}
