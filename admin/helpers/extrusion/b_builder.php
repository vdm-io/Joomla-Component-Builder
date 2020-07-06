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

	@version			1.0.0
	@created		26th December, 2016
	@package		Component Builder
	@subpackage		builder.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Builder class
 */
class Builder extends Mapping
{
	/**
	 *	Some default fields
	 */
	public		$user;
	public		$today;
	public		$db;
	public		$views = array();
	public		$admin_fields = array();
	protected	$fields = array();
	protected	$title = array();
	protected	$description = array();
	protected	$alias = array();
	protected	$list = array();
	
	/**
	 *	Field that should not be used in name, alias, disc, and list view
	 *	(TODO) We may need to set this dynamicly
	 */
	protected	$avoidList	= array('not_required');
	
	/***
	 *	Constructor
	 */
	public function __construct(&$data)
	{
		// first we run the perent constructor
		if (parent::__construct($data))
		{
			// always reset the building values if found
			$data['buildcomp'] = 0;
			$data['buildcompsql'] = '';
			// set some globals
			$this->db = JFactory::getDbo();
			$this->user = JFactory::getUser();
			$this->today = JFactory::getDate()->toSql();

			// no start the building of the views and fields
			if ($this->setBuild())
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 *	The building function
	 *	To build the views and fields that are needed
	 */
	protected function setBuild()
	{
		foreach ($this->map as $view => $fields)
		{
			// set this field with all its needed data
			foreach ($fields as $field)
			{
				$this->setField($view, $field);
			}
			// set this view with all its needed data
			$this->setView($view);
		}
		return true;
	}
	
	/**
	 *	The building function for views
	 */
	protected function setView(&$name)
	{
		// set the view object
		$object = new stdClass();
		$object->system_name = ComponentbuilderHelper::safeString($name, 'W') . ' (dynamic build)';
		$object->name_single = $name;
		$object->name_list = $name. 's';
		$object->short_description = $name. ' view (dynamic build)';
		$object->type = 1;
		$object->description = $name. ' view (dynamic build)';
		$object->add_fadein = 1;
		$object->add_sql = (isset($this->addSql[$name])) ? $this->addSql[$name]: 0;
		$object->source = (isset($this->source[$name])) ? $this->source[$name]: 0;
		$object->sql = (isset($this->sql[$name])) ? base64_encode($this->sql[$name]): '';
		$object->addpermissions = '{"action":["view.edit","view.edit.own","view.edit.state","view.create","view.delete","view.access"],"implementation":["3","3","3","3","3","3"]}';
		$object->created = $this->today;
		$object->created_by = $this->user->id;
		$object->published = 1;
		// add to data base
		if ($this->db->insertObject('#__componentbuilder_admin_view', $object))
		{
			// make sure the access of asset is set
			$id = $this->db->insertid();
			ComponentbuilderHelper::setAsset($id, 'admin_view');
			// load the views
			$this->views[] = $id;
			// load the admin view fields
			return $this->addFields($name, $id);
		}
		return false;
	}
	
	/**
	 *	Add the fields to the view
	 */
	protected function addFields(&$view, &$view_id)
	{
		if (isset($this->fields[$view]))
		{
			// set some defaults
			$addField = array ();
			$fixLink = (isset($this->title[$view])) ? 0 : 1;
			// build the field data... hmmm
			foreach ($this->fields[$view] as $nr => $id)
			{
				$alignment = 1;
				if ($nr % 2 == 0)
				{
					$alignment = 2;
				}
				// some defaults
				$isTitle = (isset($this->title[$view]) && $this->title[$view] == $id) ? 1 : 0;
				$isAlias = (isset($this->alias[$view]) && $this->alias[$view] == $id) ? 1 : 0;
				$isList = ($key = array_search($id, $this->list[$view])) ? 1 : 0;
				$isLink = ($isTitle) ? 1 : (($isList && $fixLink) ? 1 : 0);
				if ($isLink)
				{
					$fixLink = 0;
				}
				// load the field values
				$addField['addfields'.$nr]['field'] = $id;
				$addField['addfields'.$nr]['list'] = $isList;
				$addField['addfields'.$nr]['order_list'] = ($key) ? $key : 0;
				$addField['addfields'.$nr]['title'] = $isTitle;
				$addField['addfields'.$nr]['alias'] = $isAlias;
				$addField['addfields'.$nr]['sort'] = $isList;
				$addField['addfields'.$nr]['search'] = $isList;
				$addField['addfields'.$nr]['filter'] = $isList;
				$addField['addfields'.$nr]['link'] = $isLink;
				$addField['addfields'.$nr]['tab'] = 1;
				$addField['addfields'.$nr]['alignment'] = ($isTitle || $isAlias) ? 4 : $alignment;
				$addField['addfields'.$nr]['order_edit'] = $nr;
				$addField['addfields'.$nr]['permission'] = 0;
			}
			
			// set the field object
			$object = new stdClass();
			$object->admin_view = $view_id;
			$object->addfields = json_encode($addField, JSON_FORCE_OBJECT);
			$object->created = $this->today;
			$object->created_by = $this->user->id;
			$object->published = 1;
			// add to data base
			return $this->db->insertObject('#__componentbuilder_admin_fields', $object);
		}
		return false;
	}
	
	/**
	 *	The building function for fields
	 */
	protected function setField(&$view, &$field)
	{
		if ($fieldType = $this->getFieldType($field['fieldType']))
		{
			// set the field object
			$object = new stdClass();
			$object->name = $field['label'] . ' (dynamic build)';
			$object->fieldtype = $fieldType;
			$object->datatype = $field['dataType'];
			$object->indexes = $field['key'];
			$object->null_switch = $field['null'];
			$object->datalenght = $field['size'];
			$object->datalenght_other = $field['sizeOther'];
			$object->datadefault = $field['default'];
			$object->datadefault_other = $field['defaultOther'];
			$object->created = $this->today;
			$object->created_by = $this->user->id;
			$object->published = 1;
			$object->store = 0;
			$object->xml = $this->setFieldXML($field, $fieldType);
			// add to data base
			if ($this->db->insertObject('#__componentbuilder_field', $object))
			{
				// make sure the access of asset is set
				$id = $this->db->insertid();
				ComponentbuilderHelper::setAsset($id, 'field');
				// check if any field for this field was already set, if not set array
				if (!isset($this->fields[$view]))
				{
					$this->fields[$view] = array();
				}
				// load the field
				$this->fields[$view][] = $id;
				
				if (!isset($this->list[$view]))
				{
					$this->list[$view] = array();
				}
				// insure that some fields are avoided
				if (!in_array($field['name'], $this->avoidList))
				{
					// set the name/title field if found
					if (!isset($this->title[$view]) && (stripos($field['name'], 'name') !== false || stripos($field['name'], 'title') !== false))
					{
						$this->title[$view] = $id;
						$this->list[$view][] = $id;
					}
					// set the alias field if found
					elseif (!isset($this->alias[$id]) && stripos($field['name'], 'alias') !== false)
					{
						$this->alias[$view] = $id;
					}
					// set the alias field if found
					elseif (!isset($this->description[$id]) && stripos($field['name'], 'desc') !== false)
					{
						$this->description[$view] = $id;
						$this->list[$view][] = $id;
					}
					elseif ('Text' == $field['fieldType'] && count($this->list[$view]) < 5)
					{
						$this->list[$view][] = $id;
					}
				}
				return true;
			}
		}
		return false;
	}
	
	/**
	 *	get the field type id from system
	 */
	protected function getFieldType($fieldName)
	{
		// load the field settings
		return ComponentbuilderHelper::getVar('fieldtype', $fieldName, 'name', 'id');
	}
	
	/**
	 *	The building function for field xml
	 */
	protected function setFieldXML(&$field, $fieldId)
	{
		// load the field settings
		$settings = array();
		$settings['name'] = $field['name'];
		$settings['description'] = 'The '.strtolower($field['label']) . ' is set here.';
		$settings['message'] = "Error! Please add some ".strtolower($field['label'])." here.";
		$settings['label'] = $field['label'];
		$settings['default'] = ($field['default'] == 'Other') ? $field['defaultOther'] : $field['default'];
		$settings['hint'] = $field['label'] .' Here!';
		// okay set the xml field values
		if ($fieldOptions = ComponentbuilderHelper::getFieldTypeProperties($fieldId, 'id', $settings))
		{
			return json_encode($fieldOptions['values']);
		}
		return '';
	}
}
