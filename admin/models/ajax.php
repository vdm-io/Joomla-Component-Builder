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

	@version		2.3.0
	@build			4th February, 2017
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

	// Used in component
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

	// Used in admin_view
	public function getImportScripts($type)
	{
		$script = array();
		if ('display' == $type)
		{
			// set the display script
			$script['display'][] = "\tprotected \$headerList;";
			$script['display'][] = "\tprotected \$hasPackage = false;";
			$script['display'][] = "\tprotected \$headers;";
			$script['display'][] = "\tprotected \$hasHeader = 0;";
			$script['display'][] = "\tprotected \$dataType;";
			$script['display'][] = "\n\tpublic function display(\$tpl = null)";
			$script['display'][] = "\t{";
			$script['display'][] = "\t\tif (\$this->getLayout() !== 'modal')";
			$script['display'][] = "\t\t{";
			$script['display'][] = "\t\t\t// Include helper submenu";
			$script['display'][] = "\t\t\t###-#-#-Component###Helper::addSubmenu('import');";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t// Check for errors.";
			$script['display'][] = "\t\tif (count(\$errors = \$this->get('Errors'))){";
			$script['display'][] = "\t\t\tJError::raiseError(500, implode('<br />', \$errors));";
			$script['display'][] = "\t\t\treturn false;";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t\$paths = new stdClass;";
			$script['display'][] = "\t\t\$paths->first = '';";
			$script['display'][] = "\t\t\$state = \$this->get('state');";
			$script['display'][] = "\n\t\t\$this->paths = &\$paths;";
			$script['display'][] = "\t\t\$this->state = &\$state;";
			$script['display'][] = "\t\t// get global action permissions";
			$script['display'][] = "\t\t\$this->canDo = ###-#-#-Component###Helper::getActions('import');";
			$script['display'][] = "\n\t\t// We don't need toolbar in the modal window.";
			$script['display'][] = "\t\tif (\$this->getLayout() !== 'modal')";
			$script['display'][] = "\t\t{";
			$script['display'][] = "\t\t\t\$this->addToolbar();";
			$script['display'][] = "\t\t\t\$this->sidebar = JHtmlSidebar::render();";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t// get the session object";
			$script['display'][] = "\t\t\$session = JFactory::getSession();";
			$script['display'][] = "\t\t// check if it has package";
			$script['display'][] = "\t\t\$this->hasPackage \t= \$session->get('hasPackage', false);";
			$script['display'][] = "\t\t\$this->dataType \t= \$session->get('dataType', false);";
			$script['display'][] = "\t\tif(\$this->hasPackage && \$this->dataType)";
			$script['display'][] = "\t\t{";
			$script['display'][] = "\t\t\t\$this->headerList \t= json_decode(\$session->get(\$this->dataType.'_VDM_IMPORTHEADERS', false),true);";
			$script['display'][] = "\t\t\t\$this->headers \t\t= ###-#-#-Component###Helper::getFileHeaders(\$this->dataType);";
			$script['display'][] = "\t\t\t// clear the data type";
			$script['display'][] = "\t\t\t\$session->clear('dataType');";
			$script['display'][] = "\t\t}";
			$script['display'][] = "\n\t\t// Display the template";
			$script['display'][] = "\t\tparent::display(\$tpl);";
			$script['display'][] = "\t}";
		}
		elseif ('setdata' == $type)
		{
			// set the setdata script
			$script['setdata'] = array();
			$script['setdata'][] = "\t/**";
			$script['setdata'][] = "\t* Set the data from the spreadsheet to the database";
			$script['setdata'][] = "\t*";
			$script['setdata'][] = "\t* @param string  \$package Paths to the uploaded package file";
			$script['setdata'][] = "\t*";
			$script['setdata'][] = "\t* @return  boolean false on failure";
			$script['setdata'][] = "\t*";
			$script['setdata'][] = "\t**/";
			$script['setdata'][] = "\tprotected function setData(\$package,\$table,\$target_headers)";
			$script['setdata'][] = "\t{";
			$script['setdata'][] = "\t\tif (###-#-#-Component###Helper::checkArray(\$target_headers))";
			$script['setdata'][] = "\t\t{";
			$script['setdata'][] = "\t\t\t// make sure the file is loaded\t\t";
			$script['setdata'][] = "\t\t\tJLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$script['setdata'][] = "\t\t\t\$jinput = JFactory::getApplication()->input;";
			$script['setdata'][] = "\t\t\tforeach(\$target_headers as \$header)";
			$script['setdata'][] = "\t\t\t{";
			$script['setdata'][] = "\t\t\t\t\$data['target_headers'][\$header] = \$jinput->getString(\$header, null);";
			$script['setdata'][] = "\t\t\t}";
			$script['setdata'][] = "\t\t\t// set the data";
			$script['setdata'][] = "\t\t\tif(isset(\$package['dir']))";
			$script['setdata'][] = "\t\t\t{";
			$script['setdata'][] = "\t\t\t\t\$inputFileType = PHPExcel_IOFactory::identify(\$package['dir']);";
			$script['setdata'][] = "\t\t\t\t\$excelReader = PHPExcel_IOFactory::createReader(\$inputFileType);";
			$script['setdata'][] = "\t\t\t\t\$excelReader->setReadDataOnly(true);";
			$script['setdata'][] = "\t\t\t\t\$excelObj = \$excelReader->load(\$package['dir']);";
			$script['setdata'][] = "\t\t\t\t\$data['array'] = \$excelObj->getActiveSheet()->toArray(null, true,true,true);";
			$script['setdata'][] = "\t\t\t\t\$excelObj->disconnectWorksheets();";
			$script['setdata'][] = "\t\t\t\tunset(\$excelObj);";
			$script['setdata'][] = "\t\t\t\treturn \$this->save(\$data,\$table);";
			$script['setdata'][] = "\t\t\t}";
			$script['setdata'][] = "\t\t}";
			$script['setdata'][] = "\t\treturn false;";
			$script['setdata'][] = "\t}";
		}
		elseif ('save' == $type)
		{
			$script['save'] = array();
			$script['save'][] = "\t/**";
			$script['save'][] = "\t* Save the data from the file to the database";
			$script['save'][] = "\t*";
			$script['save'][] = "\t* @param string  \$package Paths to the uploaded package file";
			$script['save'][] = "\t*";
			$script['save'][] = "\t* @return  boolean false on failure";
			$script['save'][] = "\t*";
			$script['save'][] = "\t**/";
			$script['save'][] = "\tprotected function save(\$data,\$table)";
			$script['save'][] = "\t{";
			$script['save'][] = "\t\t// import the data if there is any";
			$script['save'][] = "\t\tif(###-#-#-Component###Helper::checkArray(\$data['array']))";
			$script['save'][] = "\t\t{";
			$script['save'][] = "\t\t\t// get user object";
			$script['save'][] = "\t\t\t\$user  \t\t= JFactory::getUser();";
			$script['save'][] = "\t\t\t// remove header if it has headers";
			$script['save'][] = "\t\t\t\$id_key \t= \$data['target_headers']['id'];";
			$script['save'][] = "\t\t\t\$published_key \t= \$data['target_headers']['published'];";
			$script['save'][] = "\t\t\t\$ordering_key \t= \$data['target_headers']['ordering'];";
			$script['save'][] = "\t\t\t// get the first array set";
			$script['save'][] = "\t\t\t\$firstSet = reset(\$data['array']);";
			$script['save'][] = "";
			$script['save'][] = "\t\t\t// check if first array is a header array and remove if true";
			$script['save'][] = "\t\t\tif(\$firstSet[\$id_key] == 'id' || \$firstSet[\$published_key] == 'published' || \$firstSet[\$ordering_key] == 'ordering')";
			$script['save'][] = "\t\t\t{";
			$script['save'][] = "\t\t\t\tarray_shift(\$data['array']);";
			$script['save'][] = "\t\t\t}";
			$script['save'][] = "\t\t\t";
			$script['save'][] = "\t\t\t// make sure there is still values in array and that it was not only headers";
			$script['save'][] = "\t\t\tif(###-#-#-Component###Helper::checkArray(\$data['array']) && \$user->authorise(\$table.'.import', 'com_###-#-#-component###') && \$user->authorise('core.import', 'com_###-#-#-component###'))";
			$script['save'][] = "\t\t\t{";
			$script['save'][] = "\t\t\t\t// set target.";
			$script['save'][] = "\t\t\t\t\$target\t= array_flip(\$data['target_headers']);";
			$script['save'][] = "\t\t\t\t// Get a db connection.";
			$script['save'][] = "\t\t\t\t\$db = JFactory::getDbo();";
			$script['save'][] = "\t\t\t\t// set some defaults";
			$script['save'][] = "\t\t\t\t\$todayDate\t\t= JFactory::getDate()->toSql();";
			$script['save'][] = "\t\t\t\t// get global action permissions";
			$script['save'][] = "\t\t\t\t\$canDo\t\t\t= ###-#-#-Component###Helper::getActions(\$table);";
			$script['save'][] = "\t\t\t\t\$canEdit\t\t= \$canDo->get('core.edit');";
			$script['save'][] = "\t\t\t\t\$canState\t\t= \$canDo->get('core.edit.state');";
			$script['save'][] = "\t\t\t\t\$canCreate\t\t= \$canDo->get('core.create');";
			$script['save'][] = "\t\t\t\t\$hasAlias\t\t= \$this->getAliasesUsed(\$table);";
			$script['save'][] = "\t\t\t\t// prosses the data";
			$script['save'][] = "\t\t\t\tforeach(\$data['array'] as \$row)";
			$script['save'][] = "\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\$found = false;";
			$script['save'][] = "\t\t\t\t\tif (isset(\$row[\$id_key]) && is_numeric(\$row[\$id_key]) && \$row[\$id_key] > 0)";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t// raw items import & update!";
			$script['save'][] = "\t\t\t\t\t\t\$query = \$db->getQuery(true);";
			$script['save'][] = "\t\t\t\t\t\t\$query";
			$script['save'][] = "\t\t\t\t\t\t\t->select('version')";
			$script['save'][] = "\t\t\t\t\t\t\t->from(\$db->quoteName('#__###-#-#-component###_'.\$table))";
			$script['save'][] = "\t\t\t\t\t\t\t->where(\$db->quoteName('id') . ' = '. \$db->quote(\$row[\$id_key]));";
			$script['save'][] = "\t\t\t\t\t\t// Reset the query using our newly populated query object.";
			$script['save'][] = "\t\t\t\t\t\t\$db->setQuery(\$query);";
			$script['save'][] = "\t\t\t\t\t\t\$db->execute();";
			$script['save'][] = "\t\t\t\t\t\t\$found = \$db->getNumRows();";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t";
			$script['save'][] = "\t\t\t\t\tif(\$found && \$canEdit)";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t// update item";
			$script['save'][] = "\t\t\t\t\t\t\$id \t\t= \$row[\$id_key];";
			$script['save'][] = "\t\t\t\t\t\t\$version\t= \$db->loadResult();";
			$script['save'][] = "\t\t\t\t\t\t// reset all buckets";
			$script['save'][] = "\t\t\t\t\t\t\$query \t\t= \$db->getQuery(true);";
			$script['save'][] = "\t\t\t\t\t\t\$fields \t= array();";
			$script['save'][] = "\t\t\t\t\t\t// Fields to update.";
			$script['save'][] = "\t\t\t\t\t\tforeach(\$row as \$key => \$cell)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t// ignore column";
			$script['save'][] = "\t\t\t\t\t\t\tif ('IGNORE' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update modified";
			$script['save'][] = "\t\t\t\t\t\t\tif ('modified_by' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update modified";
			$script['save'][] = "\t\t\t\t\t\t\tif ('modified' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update version";
			$script['save'][] = "\t\t\t\t\t\t\tif ('version' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$cell = (int) \$version + 1;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// verify publish authority";
			$script['save'][] = "\t\t\t\t\t\t\tif ('published' == \$target[\$key] && !\$canState)";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// set to update array";
			$script['save'][] = "\t\t\t\t\t\t\tif(in_array(\$key, \$data['target_headers']) && is_numeric(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$fields[] = \$db->quoteName(\$target[\$key]) . ' = ' . \$cell;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_string(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$fields[] = \$db->quoteName(\$target[\$key]) . ' = ' . \$db->quote(\$cell);";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_null(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t// if import data is null then set empty";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$fields[] = \$db->quoteName(\$target[\$key]) . \" = ''\";";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t// load the defaults";
			$script['save'][] = "\t\t\t\t\t\t\$fields[]\t= \$db->quoteName('modified_by') . ' = ' . \$db->quote(\$user->id);";
			$script['save'][] = "\t\t\t\t\t\t\$fields[]\t= \$db->quoteName('modified') . ' = ' . \$db->quote(\$todayDate);";
			$script['save'][] = "\t\t\t\t\t\t// Conditions for which records should be updated.";
			$script['save'][] = "\t\t\t\t\t\t\$conditions = array(";
			$script['save'][] = "\t\t\t\t\t\t\t\$db->quoteName('id') . ' = ' . \$id";
			$script['save'][] = "\t\t\t\t\t\t);";
			$script['save'][] = "\t\t\t\t\t\t";
			$script['save'][] = "\t\t\t\t\t\t\$query->update(\$db->quoteName('#__###-#-#-component###_'.\$table))->set(\$fields)->where(\$conditions);";
			$script['save'][] = "\t\t\t\t\t\t\$db->setQuery(\$query);";
			$script['save'][] = "\t\t\t\t\t\t\$db->execute();";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\telseif (\$canCreate)";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t// insert item";
			$script['save'][] = "\t\t\t\t\t\t\$query = \$db->getQuery(true);";
			$script['save'][] = "\t\t\t\t\t\t// reset all buckets";
			$script['save'][] = "\t\t\t\t\t\t\$columns \t= array();";
			$script['save'][] = "\t\t\t\t\t\t\$values \t= array();";
			$script['save'][] = "\t\t\t\t\t\t\$version\t= false;";
			$script['save'][] = "\t\t\t\t\t\t// Insert columns. Insert values.";
			$script['save'][] = "\t\t\t\t\t\tforeach(\$row as \$key => \$cell)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t// ignore column";
			$script['save'][] = "\t\t\t\t\t\t\tif ('IGNORE' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// remove id";
			$script['save'][] = "\t\t\t\t\t\t\tif ('id' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update created";
			$script['save'][] = "\t\t\t\t\t\t\tif ('created_by' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update created";
			$script['save'][] = "\t\t\t\t\t\t\tif ('created' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\tcontinue;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// Make sure the alias is incremented";
			$script['save'][] = "\t\t\t\t\t\t\tif ('alias' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$cell = \$this->getAlias(\$cell,\$table);";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// update version";
			$script['save'][] = "\t\t\t\t\t\t\tif ('version' == \$target[\$key])";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$cell = 1;";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$version = true;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\t// set to insert array";
			$script['save'][] = "\t\t\t\t\t\t\tif(in_array(\$key, \$data['target_headers']) && is_numeric(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$columns[] \t= \$target[\$key];";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$values[] \t= \$cell;";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_string(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$columns[] \t= \$target[\$key];";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$values[] \t= \$db->quote(\$cell);";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t\telseif(in_array(\$key, \$data['target_headers']) && is_null(\$cell))";
			$script['save'][] = "\t\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\t// if import data is null then set empty";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$columns[] \t= \$target[\$key];";
			$script['save'][] = "\t\t\t\t\t\t\t\t\$values[] \t= \"''\";";
			$script['save'][] = "\t\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t// load the defaults";
			$script['save'][] = "\t\t\t\t\t\t\$columns[] \t= 'created_by';";
			$script['save'][] = "\t\t\t\t\t\t\$values[] \t= \$db->quote(\$user->id);";
			$script['save'][] = "\t\t\t\t\t\t\$columns[] \t= 'created';";
			$script['save'][] = "\t\t\t\t\t\t\$values[] \t= \$db->quote(\$todayDate);";
			$script['save'][] = "\t\t\t\t\t\tif (!\$version)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\$columns[] \t= 'version';";
			$script['save'][] = "\t\t\t\t\t\t\t\$values[] \t= 1;";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t\t// Prepare the insert query.";
			$script['save'][] = "\t\t\t\t\t\t\$query";
			$script['save'][] = "\t\t\t\t\t\t\t->insert(\$db->quoteName('#__###-#-#-component###_'.\$table))";
			$script['save'][] = "\t\t\t\t\t\t\t->columns(\$db->quoteName(\$columns))";
			$script['save'][] = "\t\t\t\t\t\t\t->values(implode(',', \$values));";
			$script['save'][] = "\t\t\t\t\t\t// Set the query using our newly populated query object and execute it.";
			$script['save'][] = "\t\t\t\t\t\t\$db->setQuery(\$query);";
			$script['save'][] = "\t\t\t\t\t\t\$done = \$db->execute();";
			$script['save'][] = "\t\t\t\t\t\tif (\$done)";
			$script['save'][] = "\t\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\t\t\$aId = \$db->insertid();";
			$script['save'][] = "\t\t\t\t\t\t\t// make sure the access of asset is set";
			$script['save'][] = "\t\t\t\t\t\t\t###-#-#-Component###Helper::setAsset(\$aId,\$table);";
			$script['save'][] = "\t\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t\telse";
			$script['save'][] = "\t\t\t\t\t{";
			$script['save'][] = "\t\t\t\t\t\treturn false;";
			$script['save'][] = "\t\t\t\t\t}";
			$script['save'][] = "\t\t\t\t}";
			$script['save'][] = "\t\t\t\treturn true;";
			$script['save'][] = "\t\t\t}";
			$script['save'][] = "\t\t}";
			$script['save'][] = "\t\treturn false;";
			$script['save'][] = "\t}";
		}
		elseif ('view' == $type)
		{
			$script['view'] = array();
			$script['view'][] = "<script type=\"text/javascript\">";
			$script['view'][] = "<?php if (\$this->hasPackage && ###-#-#-Component###Helper::checkArray(\$this->headerList)) : ?>";
			$script['view'][] = "\tJoomla.continueImport = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "\t\tvar error = false;";
			$script['view'][] = "\t\tvar therequired = [<?php \$i = 0; foreach(\$this->headerList as \$name => \$title) { echo (\$i != 0)? ', \"vdm_'.\$name.'\"':'\"vdm_'.\$name.'\"'; \$i++; } ?>];";
			$script['view'][] = "\t\tfor(i = 0; i < therequired.length; i++)";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tif(jQuery('#'+therequired[i]).val() == \"\" )";
			$script['view'][] = "\t\t\t{";
			$script['view'][] = "\t\t\t\terror = true;";
			$script['view'][] = "\t\t\t\tbreak;";
			$script['view'][] = "\t\t\t}";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\t// do field validation";
			$script['view'][] = "\t\tif (error)";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'continue';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "<?php else: ?>";
			$script['view'][] = "\tJoomla.submitbutton = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t// do field validation";
			$script['view'][] = "\t\tif (form.import_package.value == \"\")";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_PLEASE_SELECT_A_FILE', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'upload';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "";
			$script['view'][] = "\n\tJoomla.submitbutton3 = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t// do field validation";
			$script['view'][] = "\t\tif (form.import_directory.value == \"\"){";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'folder';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "";
			$script['view'][] = "\n\tJoomla.submitbutton4 = function()";
			$script['view'][] = "\t{";
			$script['view'][] = "\t\tvar form = document.getElementById('adminForm');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t// do field validation";
			$script['view'][] = "\t\tif (form.import_url.value == \"\" || form.import_url.value == \"http://\")";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\talert(\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_MSG_ENTER_A_URL', true); ?>\");";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t\telse";
			$script['view'][] = "\t\t{";
			$script['view'][] = "\t\t\tjQuery('#loading').css('display', 'block');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t\tform.gettype.value = 'url';";
			$script['view'][] = "\t\t\tform.submit();";
			$script['view'][] = "\t\t}";
			$script['view'][] = "\t};";
			$script['view'][] = "<?php endif; ?>";
			$script['view'][] = "";
			$script['view'][] = "\n// Add spindle-wheel for importations:";
			$script['view'][] = "jQuery(document).ready(function(\$) {";
			$script['view'][] = "\tvar outerDiv = \$('body');";
			$script['view'][] = "";
			$script['view'][] = "\n\t\$('<div id=\"loading\"></div>')";
			$script['view'][] = "\t\t.css(\"background\", \"rgba(255, 255, 255, .8) url('components/com_###-#-#-component###/assets/images/import.gif') 50% 15% no-repeat\")";
			$script['view'][] = "\t\t.css(\"top\", outerDiv.position().top - \$(window).scrollTop())";
			$script['view'][] = "\t\t.css(\"left\", outerDiv.position().left - \$(window).scrollLeft())";
			$script['view'][] = "\t\t.css(\"width\", outerDiv.width())";
			$script['view'][] = "\t\t.css(\"height\", outerDiv.height())";
			$script['view'][] = "\t\t.css(\"position\", \"fixed\")";
			$script['view'][] = "\t\t.css(\"opacity\", \"0.80\")";
			$script['view'][] = "\t\t.css(\"-ms-filter\", \"progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)\")";
			$script['view'][] = "\t\t.css(\"filter\", \"alpha(opacity = 80)\")";
			$script['view'][] = "\t\t.css(\"display\", \"none\")";
			$script['view'][] = "\t\t.appendTo(outerDiv);";
			$script['view'][] = "});";
			$script['view'][] = "";
			$script['view'][] = "\n</script>";
			$script['view'][] = "";
			$script['view'][] = "\n<div id=\"installer-import\" class=\"clearfix\">";
			$script['view'][] = "<form enctype=\"multipart/form-data\" action=\"<?php echo JRoute::_('index.php?option=com_###-#-#-component###&view=import_###-#-#-views###');?>\" method=\"post\" name=\"adminForm\" id=\"adminForm\" class=\"form-horizontal form-validate\">";
			$script['view'][] = "";
			$script['view'][] = "\n\t<?php if (!empty( \$this->sidebar)) : ?>";
			$script['view'][] = "\t\t<div id=\"j-sidebar-container\" class=\"span2\">";
			$script['view'][] = "\t\t\t<?php echo \$this->sidebar; ?>";
			$script['view'][] = "\t\t</div>";
			$script['view'][] = "\t\t<div id=\"j-main-container\" class=\"span10\">";
			$script['view'][] = "\t<?php else : ?>";
			$script['view'][] = "\t\t<div id=\"j-main-container\">";
			$script['view'][] = "\t<?php endif;?>";
			$script['view'][] = "";
			$script['view'][] = "\n\t<?php if (\$this->hasPackage && ###-#-#-Component###Helper::checkArray(\$this->headerList) && ###-#-#-Component###Helper::checkArray(\$this->headers)) : ?>";
			$script['view'][] = "\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_LINK_FILE_TO_TABLE_COLUMNS'); ?></legend>";
			$script['view'][] = "\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t<label class=\"control-label\" ><h4><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_TABLE_COLUMNS'); ?></h4></label>";
			$script['view'][] = "\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t<label class=\"control-label\" ><h4><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FILE_COLUMNS'); ?></h4></label>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t</div>";
			$script['view'][] = "\t\t\t<?php foreach(\$this->headerList as \$name => \$title): ?>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"<?php echo \$name; ?>\" class=\"control-label\" ><?php echo \$title; ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<select  name=\"<?php echo \$name; ?>\"  id=\"vdm_<?php echo \$name; ?>\" required class=\"required input_box\" >";
			$script['view'][] = "\t\t\t\t\t\t\t<option value=\"\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_PLEASE_SELECT_COLUMN'); ?></option>";
			$script['view'][] = "\t\t\t\t\t\t\t<option value=\"IGNORE\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_IGNORE_COLUMN'); ?></option>";
			$script['view'][] = "\t\t\t\t\t\t\t<?php foreach(\$this->headers as \$value => \$option): ?>";
			$script['view'][] = "\t\t\t\t\t\t\t\t<?php \$selected = (strtolower(\$option) ==  strtolower (\$title) || strtolower(\$option) == strtolower(\$name))? 'selected=\"selected\"':''; ?>";
			$script['view'][] = "\t\t\t\t\t\t\t\t<option value=\"<?php echo ###-#-#-Component###Helper::htmlEscape(\$value); ?>\" class=\"required\" <?php echo \$selected ?>><?php echo ###-#-#-Component###Helper::htmlEscape(\$option); ?></option>";
			$script['view'][] = "\t\t\t\t\t\t\t<?php endforeach; ?>";
			$script['view'][] = "\t\t\t\t\t\t</select>";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t<?php endforeach; ?>";
			$script['view'][] = "\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t<input class=\"btn btn-primary\" type=\"button\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_CONTINUE'); ?>\" onclick=\"Joomla.continueImport()\" />";
			$script['view'][] = "\t\t\t</div>";
			$script['view'][] = "\t\t</fieldset>";
			$script['view'][] = "\t\t<input type=\"hidden\" name=\"gettype\" value=\"continue\" />";
			$script['view'][] = "\t<?php else: ?>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'upload')); ?>";
			$script['view'][] = "\t\t";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'upload', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FROM_UPLOAD', true)); ?>";
			$script['view'][] = "\t\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPDATE_DATA'); ?></legend>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"import_package\" class=\"control-label\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_SELECT_FILE'); ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<input class=\"input_box\" id=\"import_package\" name=\"import_package\" type=\"file\" size=\"57\" />";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t\t<input class=\"btn btn-primary\" type=\"button\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPLOAD_BOTTON'); ?>\" onclick=\"Joomla.submitbutton()\" />&nbsp;&nbsp;&nbsp;<small><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FORMATS_ACCEPTED'); ?> (.csv .xls .ods)</small>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t</fieldset>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$script['view'][] = "\t\t";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'directory', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FROM_DIRECTORY', true)); ?>";
			$script['view'][] = "\t\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPDATE_DATA'); ?></legend>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"import_directory\" class=\"control-label\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_SELECT_FILE_DIRECTORY'); ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<input type=\"text\" id=\"import_directory\" name=\"import_directory\" class=\"span5 input_box\" size=\"70\" value=\"<?php echo \$this->state->get('import.directory'); ?>\" />";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t\t<input type=\"button\" class=\"btn btn-primary\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_GET_BOTTON'); ?>\" onclick=\"Joomla.submitbutton3()\" />&nbsp;&nbsp;&nbsp;<small><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FORMATS_ACCEPTED'); ?> (.csv .xls .ods)</small>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</fieldset>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$script['view'][] = "";
			$script['view'][] = "\n\t\t<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'url', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FROM_URL', true)); ?>";
			$script['view'][] = "\t\t\t<fieldset class=\"uploadform\">";
			$script['view'][] = "\t\t\t\t<legend><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UPDATE_DATA'); ?></legend>";
			$script['view'][] = "\t\t\t\t<div class=\"control-group\">";
			$script['view'][] = "\t\t\t\t\t<label for=\"import_url\" class=\"control-label\"><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_SELECT_FILE_URL'); ?></label>";
			$script['view'][] = "\t\t\t\t\t<div class=\"controls\">";
			$script['view'][] = "\t\t\t\t\t\t<input type=\"text\" id=\"import_url\" name=\"import_url\" class=\"span5 input_box\" size=\"70\" value=\"http://\" />";
			$script['view'][] = "\t\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t\t<div class=\"form-actions\">";
			$script['view'][] = "\t\t\t\t\t<input type=\"button\" class=\"btn btn-primary\" value=\"<?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_GET_BOTTON'); ?>\" onclick=\"Joomla.submitbutton4()\" />&nbsp;&nbsp;&nbsp;<small><?php echo JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_FORMATS_ACCEPTED'); ?> (.csv .xls .ods)</small>";
			$script['view'][] = "\t\t\t\t</div>";
			$script['view'][] = "\t\t\t</fieldset>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$script['view'][] = "\t\t<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$script['view'][] = "\t\t<input type=\"hidden\" name=\"gettype\" value=\"upload\" />";
			$script['view'][] = "\t<?php endif; ?>";
			$script['view'][] = "\t<input type=\"hidden\" name=\"task\" value=\"import_###-#-#-views###.import\" />";
			$script['view'][] = "\t<?php echo JHtml::_('form.token'); ?>";
			$script['view'][] = "</form>";
			$script['view'][] = "</div>";
		}
		elseif ('import' == $type)
		{
			$script['import'] = array();
			$script['import'][] = "\t/**";
			$script['import'][] = "\t * Import an spreadsheet from either folder, url or upload.";
			$script['import'][] = "\t *";
			$script['import'][] = "\t * @return  boolean result of import";
			$script['import'][] = "\t *";
			$script['import'][] = "\t */";
			$script['import'][] = "\tpublic function import()";
			$script['import'][] = "\t{";
			$script['import'][] = "\t\t\$this->setState('action', 'import');";
			$script['import'][] = "\t\t\$app \t\t= JFactory::getApplication();";
			$script['import'][] = "\t\t\$session \t= JFactory::getSession();";
			$script['import'][] = "\t\t\$package \t= null;";
			$script['import'][] = "\t\t\$continue\t= false;";
			$script['import'][] = "\t\t// get import type";
			$script['import'][] = "\t\t\$this->getType = \$app->input->getString('gettype', NULL);";
			$script['import'][] = "\t\t// get import type";
			$script['import'][] = "\t\t\$this->dataType\t= \$session->get('dataType_VDM_IMPORTINTO', NULL);";
			$script['import'][] = "\n\t\tif (\$package === null)";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\tswitch (\$this->getType)";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t\tcase 'folder':";
			$script['import'][] = "\t\t\t\t\t// Remember the 'Import from Directory' path.";
			$script['import'][] = "\t\t\t\t\t\$app->getUserStateFromRequest(\$this->_context . '.import_directory', 'import_directory');";
			$script['import'][] = "\t\t\t\t\t\$package = \$this->_getPackageFromFolder();";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tcase 'upload':";
			$script['import'][] = "\t\t\t\t\t\$package = \$this->_getPackageFromUpload();";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tcase 'url':";
			$script['import'][] = "\t\t\t\t\t\$package = \$this->_getPackageFromUrl();";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tcase 'continue':";
			$script['import'][] = "\t\t\t\t\t\$continue \t= true;";
			$script['import'][] = "\t\t\t\t\t\$package\t= \$session->get('package', null);";
			$script['import'][] = "\t\t\t\t\t\$package\t= json_decode(\$package, true);";
			$script['import'][] = "\t\t\t\t\t// clear session";
			$script['import'][] = "\t\t\t\t\t\$session->clear('package');";
			$script['import'][] = "\t\t\t\t\t\$session->clear('dataType');";
			$script['import'][] = "\t\t\t\t\t\$session->clear('hasPackage');";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\n\t\t\t\tdefault:";
			$script['import'][] = "\t\t\t\t\t\$app->setUserState('com_###-#-#-component###.message', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_NO_IMPORT_TYPE_FOUND'));";
			$script['import'][] = "\n\t\t\t\t\treturn false;";
			$script['import'][] = "\t\t\t\t\tbreak;";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\t// Was the package valid?";
			$script['import'][] = "\t\tif (!\$package || !\$package['type'])";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\tif (in_array(\$this->getType, array('upload', 'url')))";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t\t\$this->remove(\$package['packagename']);";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\n\t\t\t\$app->setUserState('com_###-#-#-component###.message', JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE'));";
			$script['import'][] = "\t\t\treturn false;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\t";
			$script['import'][] = "\t\t// first link data to table headers";
			$script['import'][] = "\t\tif(!\$continue){";
			$script['import'][] = "\t\t\t\$package\t= json_encode(\$package);";
			$script['import'][] = "\t\t\t\$session->set('package', \$package);";
			$script['import'][] = "\t\t\t\$session->set('dataType', \$this->dataType);";
			$script['import'][] = "\t\t\t\$session->set('hasPackage', true);";
			$script['import'][] = "\t\t\treturn true;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\t// set the data";
			$script['import'][] = "\t\t\$headerList = json_decode(\$session->get(\$this->dataType.'_VDM_IMPORTHEADERS', false), true);";
			$script['import'][] = "\t\tif (!\$this->setData(\$package,\$this->dataType,\$headerList))";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\t// There was an error importing the package";
			$script['import'][] = "\t\t\t\$msg = JTe-#-#-xt::_('COM_###-#-#-COMPONENT###_IMPORT_ERROR');";
			$script['import'][] = "\t\t\t\$back = \$session->get('backto_VDM_IMPORT', NULL);";
			$script['import'][] = "\t\t\tif (\$back)";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t\t\$app->setUserState('com_###-#-#-component###.redirect_url', 'index.php?option=com_###-#-#-component###&view='.\$back);";
			$script['import'][] = "\t\t\t\t\$session->clear('backto_VDM_IMPORT');";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\t\t\t\$result = false;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\t\telse";
			$script['import'][] = "\t\t{";
			$script['import'][] = "\t\t\t// Package imported sucessfully";
			$script['import'][] = "\t\t\t\$msg = JTe-#-#-xt::sprintf('COM_###-#-#-COMPONENT###_IMPORT_SUCCESS', \$package['packagename']);";
			$script['import'][] = "\t\t\t\$back = \$session->get('backto_VDM_IMPORT', NULL);";
			$script['import'][] = "\t\t\tif (\$back)";
			$script['import'][] = "\t\t\t{";
			$script['import'][] = "\t\t\t    \$app->setUserState('com_###-#-#-component###.redirect_url', 'index.php?option=com_###-#-#-component###&view='.\$back);";
			$script['import'][] = "\t\t\t    \$session->clear('backto_VDM_IMPORT');";
			$script['import'][] = "\t\t\t}";
			$script['import'][] = "\t\t\t\$result = true;";
			$script['import'][] = "\t\t}";
			$script['import'][] = "\n\t\t// Set some model state values";
			$script['import'][] = "\t\t\$app->enqueueMessage(\$msg);";
			$script['import'][] = "\n\t\t// remove file after import";
			$script['import'][] = "\t\t\$this->remove(\$package['packagename']);";
			$script['import'][] = "\t\t\$session->clear(\$this->getType.'_VDM_IMPORTHEADERS');";
			$script['import'][] = "\t\treturn \$result;";
			$script['import'][] = "\t}";
		}
		// return the needed script
		if (isset($script[$type]))
		{
			return str_replace('-#-#-', '', implode("\n",$script[$type]));
		}
		return false;
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
		if ($field = ComponentbuilderHelper::getFieldOptions($id, 'id'))
		{
			// return found field options
			return $field;
		}
		return false;
	}
}
