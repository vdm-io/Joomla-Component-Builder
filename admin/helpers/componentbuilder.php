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

	@version		2.1.16
	@build			17th July, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		componentbuilder.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder component helper.
 */
abstract class ComponentbuilderHelper
{ 

	/*
	 * Compiler autoloader
	 */
	public static function autoLoader()
	{
		// load the compiler classes
		foreach (glob(JPATH_ADMINISTRATOR."/components/com_componentbuilder/helpers/compiler/*.php") as $compilerFile)
		{
			require_once $compilerFile;
		}
		// import the Joomla librarys
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.archive');
		jimport('joomla.application.component.modellist');
		jimport('joomla.application');
		// include class to minify js
		require_once JPATH_ADMINISTRATOR.'/components/com_componentbuilder/helpers/js.php';
	}

	 /**
	 *	indent HTML
	 */
	public static function indent($html)
	{
		// load the class
		require_once JPATH_ADMINISTRATOR.'/components/com_componentbuilder/helpers/indenter.php';
		// set new indenter
		$indenter = new Indenter();
		// return indented html
		return $indenter->indent($html);
	}

	public static function checkFileType($file, $sufix) {
		// now check if the file ends with the sufix
		return $sufix === "" || ($sufix == substr(strrchr($file, "."), -strlen($sufix)));
	}

	public static function imageInfo($path,$request = 'type')
	{
		// set image
		$image = JPATH_SITE.'/'.$path;
		// check if exists
		if (file_exists($image) && $result = @getimagesize($image))
		{
			// return type request
			switch ($request)
			{
				case 'width':
					return $result[0];
					break;
				case 'height':
					return $result[1];
					break;
				case 'type':
					$extensions = array(
						IMAGETYPE_GIF => "gif",
						IMAGETYPE_JPEG => "jpg",
						IMAGETYPE_PNG => "png",
						IMAGETYPE_SWF => "swf",
						IMAGETYPE_PSD => "psd",
						IMAGETYPE_BMP => "bmp",
						IMAGETYPE_TIFF_II => "tiff",
						IMAGETYPE_TIFF_MM => "tiff",
						IMAGETYPE_JPC => "jpc",
						IMAGETYPE_JP2 => "jp2",
						IMAGETYPE_JPX => "jpx",
						IMAGETYPE_JB2 => "jb2",
						IMAGETYPE_SWC => "swc",
						IMAGETYPE_IFF => "iff",
						IMAGETYPE_WBMP => "wbmp",
						IMAGETYPE_XBM => "xbm",
						IMAGETYPE_ICO => "ico"
					);
					return $extensions[$result[2]];
					break;
				case 'attr':
					return $result[3];
					break;
				case 'all':
				default:
					return $result;
					break;
			}
		}
		return false;
	}
	
	public static function getBetween($content,$start,$end)
	{
		$r = explode($start, $content);
		if (isset($r[1]))
		{
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}
	
	public static function getAllBetween($content,$start,$end)
	{
		$buket = array();
		for ($i = 0; ; $i++)
		{
			$found = self::getBetween($content,$start,$end);
			if (self::checkString($found))
			{
				$buket[] = $found;
				$remove = $start.$found.$end;
				$content = str_replace($remove,'',$content);
			}
			else
			{
				break;
			}
			// safety catch
			if ($i == 500)
			{
				break;
			}
		}
		return  array_unique($buket);
	}
	
	public static function typeField($type,$option = 'default')
	{
		// list of default fields
		// https://docs.joomla.org/Form_field
		$fields = array(
			'default' => array(
				'accesslevel','cachehandler','calendar','captcha','category','checkbox',
				'checkboxes','color','combo','componentlayout','contentlanguage','editor',
				'chromestyle','contenttype','databaseconnection','editors','email','file',
				'filelist','folderlist','groupedlist','hidden','file','headertag','helpsite',
				'imagelist','integer','language','list','media','menu','note','password',
				'plugins','range','radio','repeatable','rules','sessionhandler','spacer','sql','tag',
				'tel','menuitem','modulelayout','meter','moduleorder','moduleposition','moduletag',
				'templatestyle','text','textarea','timezone','url','user','usergroup'
			), 
			'text' => array(
				'calendar','color','editor','email','password','tel','text','textarea','url','number','range'
			), 
			'list' => array(
				'checkboxes','checkbox','list','radio'
			), 
			'dynamic' => array(
				'category','headertag','tag','rules','user','file','filelist','folderlist','imagelist','integer','timezone','media','meter'
			)
		);
		
		if (in_array($type,$fields[$option]))
		{
			return true;
		}
		return false;		
	}
	/**
	*	Load the Component xml manifest.
	**/
        public static function manifest()
	{
                $manifestUrl = JPATH_ADMINISTRATOR."/components/com_componentbuilder/componentbuilder.xml";
                return simplexml_load_file($manifestUrl);
	}

	/**
	*	Load the Contributors details.
	**/
	public static function getContributors()
	{
		// get params
		$params	= JComponentHelper::getParams('com_componentbuilder');
		// start contributors array
		$contributors = array();
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
				$contributors[$nr]['title']	= self::htmlEscape($params->get("titleContributor".$nr));
				$contributors[$nr]['name']	= $link_front.self::htmlEscape($params->get("nameContributor".$nr)).$link_back;
			}
		}
		return $contributors;
	}

	/**
	*	Load the Component Help URLs.
	**/
	public static function getHelpUrl($view)
	{
		$user	= JFactory::getUser();
		$groups = $user->get('groups');
		$db	= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(array('a.id','a.groups','a.target','a.type','a.article','a.url'));
		$query->from('#__componentbuilder_help_document AS a');
		$query->where('a.admin_view = '.$db->quote($view));
		$query->where('a.location = 1');
		$query->where('a.published = 1');
		$db->setQuery($query);
		$db->execute();
		if($db->getNumRows())
		{
			$helps = $db->loadObjectList();
			if (self::checkArray($helps))
			{
				foreach ($helps as $nr => $help)
				{
					if ($help->target == 1)
					{
						$targetgroups = json_decode($help->groups, true);
						if (!array_intersect($targetgroups, $groups))
						{
							// if user not in those target groups then remove the item
							unset($helps[$nr]);
							continue;
						}
					}
					// set the return type
					switch ($help->type)
					{
						// set joomla article
						case 1:
							return self::loadArticleLink($help->article);
						break;
						// set help text
						case 2:
							return self::loadHelpTextLink($help->id);
						break;
						// set Link
						case 3:
							return $help->url;
						break;
					}
				}
			}
		}
		return false;
	}

	/**
	*	Get the Article Link.
	**/
	protected static function loadArticleLink($id)
	{
		return JURI::root().'index.php?option=com_content&view=article&id='.$id.'&tmpl=component&layout=modal';
	}

	/**
	*	Get the Help Text Link.
	**/
	protected static function loadHelpTextLink($id)
	{
		$token = JSession::getFormToken();
		return 'index.php?option=com_componentbuilder&task=help.getText&id=' . (int) $id . '&token=' . $token;
	}

	/**
	*	Configure the Linkbar.
	**/
	public static function addSubmenu($submenu)
	{
                // load user for access menus
                $user = JFactory::getUser();
                // load the submenus to sidebar
                JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_DASHBOARD'), 'index.php?option=com_componentbuilder&view=componentbuilder', $submenu == 'componentbuilder');
		// Access control (compiler.submenu).
		if ($user->authorise('compiler.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_COMPILER'), 'index.php?option=com_componentbuilder&view=compiler', $submenu == 'compiler');
		}
		JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_COMPONENTS'), 'index.php?option=com_componentbuilder&view=components', $submenu == 'components');
		if ($user->authorise('admin_view.access', 'com_componentbuilder') && $user->authorise('admin_view.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_ADMIN_VIEWS'), 'index.php?option=com_componentbuilder&view=admin_views', $submenu == 'admin_views');
		}
		if ($user->authorise('custom_admin_view.access', 'com_componentbuilder') && $user->authorise('custom_admin_view.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_CUSTOM_ADMIN_VIEWS'), 'index.php?option=com_componentbuilder&view=custom_admin_views', $submenu == 'custom_admin_views');
		}
		if ($user->authorise('site_view.access', 'com_componentbuilder') && $user->authorise('site_view.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_SITE_VIEWS'), 'index.php?option=com_componentbuilder&view=site_views', $submenu == 'site_views');
		}
		if ($user->authorise('template.access', 'com_componentbuilder') && $user->authorise('template.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_TEMPLATES'), 'index.php?option=com_componentbuilder&view=templates', $submenu == 'templates');
		}
		if ($user->authorise('layout.access', 'com_componentbuilder') && $user->authorise('layout.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_LAYOUTS'), 'index.php?option=com_componentbuilder&view=layouts', $submenu == 'layouts');
		}
		if ($user->authorise('dynamic_get.access', 'com_componentbuilder') && $user->authorise('dynamic_get.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_DYNAMIC_GETS'), 'index.php?option=com_componentbuilder&view=dynamic_gets', $submenu == 'dynamic_gets');
		}
		if ($user->authorise('snippet.access', 'com_componentbuilder') && $user->authorise('snippet.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_SNIPPETS'), 'index.php?option=com_componentbuilder&view=snippets', $submenu == 'snippets');
		}
		if ($user->authorise('field.access', 'com_componentbuilder') && $user->authorise('field.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_FIELDS'), 'index.php?option=com_componentbuilder&view=fields', $submenu == 'fields');
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_FIELD_FIELD_CATEGORY'), 'index.php?option=com_categories&view=categories&extension=com_componentbuilder.fields', $submenu == 'categories.fields');
		}
		if ($user->authorise('fieldtype.access', 'com_componentbuilder') && $user->authorise('fieldtype.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_FIELDTYPES'), 'index.php?option=com_componentbuilder&view=fieldtypes', $submenu == 'fieldtypes');
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_FIELDTYPE_FIELDTYPE_CATEGORY'), 'index.php?option=com_categories&view=categories&extension=com_componentbuilder.fieldtypes', $submenu == 'categories.fieldtypes');
		}
		if ($user->authorise('help_document.access', 'com_componentbuilder') && $user->authorise('help_document.submenu', 'com_componentbuilder'))
		{
			JHtmlSidebar::addEntry(JText::_('COM_COMPONENTBUILDER_SUBMENU_HELP_DOCUMENTS'), 'index.php?option=com_componentbuilder&view=help_documents', $submenu == 'help_documents');
		}
	} 

	/**
	* 	UIKIT Component Classes
	**/
	public static $uk_components = array(
			'data-uk-grid' => array(
				'grid' ),
			'uk-accordion' => array(
				'accordion' ),
			'uk-autocomplete' => array(
				'autocomplete' ),
			'data-uk-datepicker' => array(
				'datepicker' ),
			'uk-form-password' => array(
				'form-password' ),
			'uk-form-select' => array(
				'form-select' ),
			'data-uk-htmleditor' => array(
				'htmleditor' ),
			'data-uk-lightbox' => array(
				'lightbox' ),
			'uk-nestable' => array(
				'nestable' ),
			'UIkit.notify' => array(
				'notify' ),
			'data-uk-parallax' => array(
				'parallax' ),
			'uk-search' => array(
				'search' ),
			'uk-slider' => array(
				'slider' ),
			'uk-slideset' => array(
				'slideset' ),
			'uk-slideshow' => array(
				'slideshow',
				'slideshow-fx' ),
			'uk-sortable' => array(
				'sortable' ),
			'data-uk-sticky' => array(
				'sticky' ),
			'data-uk-timepicker' => array(
				'timepicker' ),
			'data-uk-tooltip' => array(
				'tooltip' ),
			'uk-placeholder' => array(
				'placeholder' ),
			'uk-dotnav' => array(
				'dotnav' ),
			'uk-slidenav' => array(
				'slidenav' ),
			'uk-form' => array(
				'form-advanced' ),
			'uk-progress' => array(
				'progress' ),
			'upload-drop' => array(
				'upload', 'form-file' )
			);
	
	/**
	* 	Add UIKIT Components
	**/
	public static $uikit = false;

	/**
	* 	Get UIKIT Components
	**/
	public static function getUikitComp($content,$classes = array())
	{
		if (strpos($content,'class="uk-') !== false)
		{
			// reset
			$temp = array();
			foreach (self::$uk_components as $looking => $add)
			{
				if (strpos($content,$looking) !== false)
				{
					$temp[] = $looking;
				}
			}
			// make sure uikit is loaded to config
			if (strpos($content,'class="uk-') !== false)
			{
				self::$uikit = true;
			}
			// sorter
			if (self::checkArray($temp))
			{
				// merger
				if (self::checkArray($classes))
				{
					$newTemp = array_merge($temp,$classes);
					$temp = array_unique($newTemp);
				}
				return $temp;
			}
		}	
		if (self::checkArray($classes))
		{
			return $classes;
		}
		return false;
	} 

	/**
	 * Prepares the xml document
	 */
	public static function xls($rows,$fileName = null,$title = null,$subjectTab = null,$creator = 'Vast Development Method',$description = null,$category = null,$keywords = null,$modified = null)
	{
		// set the user
		$user = JFactory::getUser();
		
		// set fieldname if not set
		if (!$fileName)
		{
			$fileName = 'exported_'.JFactory::getDate()->format('jS_F_Y');
		}
		// set modiefied if not set
		if (!$modified)
		{
			$modified = $user->name;
		}
		// set title if not set
		if (!$title)
		{
			$title = 'Book1';
		}
		// set tab name if not set
		if (!$subjectTab)
		{
			$subjectTab = 'Sheet1';
		}
		
		// make sure the file is loaded		
		JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator($creator)
									 ->setCompany('Vast Development Method')
									 ->setLastModifiedBy($modified)
									 ->setTitle($title)
									 ->setSubject($subjectTab);
		if (!$description)
		{
			$objPHPExcel->getProperties()->setDescription($description);
		}
		if (!$keywords)
		{
			$objPHPExcel->getProperties()->setKeywords($keywords);
		}
		if (!$category)
		{
			$objPHPExcel->getProperties()->setCategory($category);
		}
		
		// Some styles
		$headerStyles = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '1171A3'),
				'size'  => 12,
				'name'  => 'Verdana'
		));
		$sideStyles = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '444444'),
				'size'  => 11,
				'name'  => 'Verdana'
		));
		$normalStyles = array(
			'font'  => array(
				'color' => array('rgb' => '444444'),
				'size'  => 11,
				'name'  => 'Verdana'
		));
		
		// Add some data
		if (self::checkArray($rows))
		{
			$i = 1;
			foreach ($rows as $array){
				$a = 'A';
				foreach ($array as $value){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($a.$i, $value);
					if ($i == 1){
						$objPHPExcel->getActiveSheet()->getColumnDimension($a)->setAutoSize(true);
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->applyFromArray($headerStyles);
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					} elseif ($a == 'A'){
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->applyFromArray($sideStyles);
					} else {
						$objPHPExcel->getActiveSheet()->getStyle($a.$i)->applyFromArray($normalStyles);
					}
					$a++;
				}
				$i++;
			}
		}
		else
		{
			return false;
		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($subjectTab);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client's web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		jexit();
	}
	
	/**
	* Get CSV Headers
	*/
	public static function getFileHeaders($dataType)
	{		
		// make sure these files are loaded		
		JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
		JLoader::import('ChunkReadFilter', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/PHPExcel/Reader');
		// get session object
		$session	= JFactory::getSession();
		$package	= $session->get('package', null);
		$package	= json_decode($package, true);
		// set the headers
		if(isset($package['dir']))
		{
			$chunkFilter = new PHPExcel_Reader_chunkReadFilter();
			// only load first three rows
			$chunkFilter->setRows(2,1);
			// identify the file type
			$inputFileType = PHPExcel_IOFactory::identify($package['dir']);
			// create the reader for this file type
			$excelReader = PHPExcel_IOFactory::createReader($inputFileType);
			// load the limiting filter
			$excelReader->setReadFilter($chunkFilter);
			$excelReader->setReadDataOnly(true);
			// load the rows (only first three)
			$excelObj = $excelReader->load($package['dir']);
			$headers = array();
			foreach ($excelObj->getActiveSheet()->getRowIterator() as $row)
			{
				if($row->getRowIndex() == 1)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					foreach ($cellIterator as $cell)
					{
						if (!is_null($cell))
						{
							$headers[$cell->getColumn()] = $cell->getValue();
						}
					}
					$excelObj->disconnectWorksheets();
					unset($excelObj);
					break;
				}
			}
			return $headers;
		}
		return false;
	}

	public static function getVar($table, $where = null, $whereString = 'user', $what = 'id', $operator = '=', $main = 'componentbuilder')
	{
		if(!$where)
		{
			$where = JFactory::getUser()->id;
		}
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array($what)));
		if (empty($table))
		{
			$query->from($db->quoteName('#__'.$main));
		}
		else
		{
			$query->from($db->quoteName('#__'.$main.'_'.$table));
		}
		if (is_numeric($where))
		{
			$query->where($db->quoteName($whereString) . ' '.$operator.' '.(int) $where);
		}
		elseif (is_string($where))
		{
			$query->where($db->quoteName($whereString) . ' '.$operator.' '. $db->quote((string)$where));
		}
		else
		{
			return false;
		}
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			return $db->loadResult();
		}
		return false;
	}

	public static function getVars($table, $where = null, $whereString = 'user', $what = 'id', $operator = 'IN', $main = 'componentbuilder', $unique = true)
	{
		if(!$where)
		{
			$where = JFactory::getUser()->id;
		}

		if (!self::checkArray($where) && $where > 0)
		{
			$where = array($where);
		}

		if (self::checkArray($where))
		{
			// Get a db connection.
			$db = JFactory::getDbo();
			// Create a new query object.
			$query = $db->getQuery(true);

			$query->select($db->quoteName(array($what)));
			$query->from($db->quoteName('#__'.$main.'_'.$table));
			$query->where($db->quoteName($whereString) . ' '.$operator.' (' . implode(',',$where) . ')');
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				if ($unique)
				{
					return array_unique($db->loadColumn());
				}
				return $db->loadColumn();
			}
		}
		return false;
	}

	public static function jsonToString($value, $sperator = ", ", $table = null)
	{
                // check if string is JSON
                $result = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE)
		{
			// is JSON
			if (self::checkArray($result))
			{
				if (self::checkString($table))
				{
					$names = array();
					foreach ($result as $val)
					{
						if ($name = self::getVar($table, $val, 'id', 'name'))
						{
							$names[] = $name;
						}
					}
					if (self::checkArray($names))
					{
						return (string) implode($sperator,$names);
					}	
				}
				return (string) implode($sperator,$result);
			}
                        return (string) json_decode($value);
                }
                return $value;
        }

	public static function isPublished($id,$type)
	{
		if ($type == 'raw')
                {
			$type = 'item';
		}
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('a.published'));
		$query->from('#__componentbuilder_'.$type.' AS a');
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
		$db = JFactory::getDBO();
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
	*	Get the actions permissions
	**/
        public static function getActions($view,&$record = null,$views = null)
	{
		jimport('joomla.access.access');

		$user	= JFactory::getUser();
		$result	= new JObject;
		$view	= self::safeString($view);
                if (self::checkString($views))
                {
			$views = self::safeString($views);
                }
		// get all actions from component
		$actions = JAccess::getActions('com_componentbuilder', 'component');
                // set acctions only set in component settiongs
                $componentActions = array('core.admin','core.manage','core.options','core.export');
		// loop the actions and set the permissions
		foreach ($actions as $action)
                {
			// set to use component default
			$fallback= true;
			if (self::checkObject($record) && isset($record->id) && $record->id > 0 && !in_array($action->name,$componentActions))
			{
				// The record has been set. Check the record permissions.
				$permission = $user->authorise($action->name, 'com_componentbuilder.'.$view.'.' . (int) $record->id);
				if (!$permission && !is_null($permission))
				{
					if ($action->name == 'core.edit' || $action->name == $view.'.edit')
					{
						if ($user->authorise('core.edit.own', 'com_componentbuilder.'.$view.'.' . (int) $record->id))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
						elseif ($user->authorise($view.'edit.own', 'com_componentbuilder.'.$view.'.' . (int) $record->id))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
						elseif ($user->authorise('core.edit.own', 'com_componentbuilder'))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
						elseif ($user->authorise($view.'edit.own', 'com_componentbuilder'))
						{
							// If the owner matches 'me' then allow.
							if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
							{
								$result->set($action->name, true);
								// set not to use component default
								$fallback= false;
							}
							else
							{
								$result->set($action->name, false);
								// set not to use component default
								$fallback= false;
							}
						}
					}
				}
				elseif (self::checkString($views) && isset($record->catid) && $record->catid > 0)
				{
                                        // make sure we use the core. action check for the categories
                                        if (strpos($action->name,$view) !== false && strpos($action->name,'core.') === false ) {
                                                $coreCheck		= explode('.',$action->name);
                                                $coreCheck[0]	= 'core';
                                                $categoryCheck	= implode('.',$coreCheck);
                                        }
                                        else
                                        {
                                                $categoryCheck = $action->name;
                                        }
                                        // The record has a category. Check the category permissions.
					$catpermission = $user->authorise($categoryCheck, 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid);
					if (!$catpermission && !is_null($catpermission))
					{
						if ($action->name == 'core.edit' || $action->name == $view.'.edit')
						{
							if ($user->authorise('core.edit.own', 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
							elseif ($user->authorise($view.'edit.own', 'com_componentbuilder.'.$views.'.category.' . (int) $record->catid))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
							elseif ($user->authorise('core.edit.own', 'com_componentbuilder'))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
							elseif ($user->authorise($view.'edit.own', 'com_componentbuilder'))
							{
								// If the owner matches 'me' then allow.
								if (isset($record->created_by) && $record->created_by > 0 && ($record->created_by == $user->id))
								{
									$result->set($action->name, true);
									// set not to use component default
									$fallback= false;
								}
								else
								{
									$result->set($action->name, false);
									// set not to use component default
									$fallback= false;
								}
							}
						}
					}
				}
			}
			// if allowed then fallback on component global settings
			if ($fallback)
			{
				$result->set($action->name, $user->authorise($action->name, 'com_componentbuilder'));
			}
		}
		return $result;
	}

	/**
	*	Get any component's model
	**/
	public static function getModel($name, $path = JPATH_COMPONENT_ADMINISTRATOR, $component = 'componentbuilder')
	{
		// load some joomla helpers
		JLoader::import('joomla.application.component.model');
		// load the model file
		JLoader::import( $name, $path . '/models' );
		// return instance
		return JModelLegacy::getInstance( $name, $component.'Model' );
	}
	
	/**
	*	Add to asset Table
	*/
	public static function setAsset($id,$table)
	{
		$parent = JTable::getInstance('Asset');
		$parent->loadByName('com_componentbuilder');
		
		$parentId = $parent->id;
		$name     = 'com_componentbuilder.'.$table.'.'.$id;
		$title    = '';

		$asset = JTable::getInstance('Asset');
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
			$rules = self::getDefaultAssetRules('com_componentbuilder',$table);
			if ($rules instanceof JAccessRules)
			{
				$asset->rules = (string) $rules;
			}

			if (!$asset->check() || !$asset->store())
			{
				JFactory::getApplication()->enqueueMessage($asset->getError(), 'warning');
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
				return JFactory::getDbo()->updateObject('#__componentbuilder_'.$table, $object, 'id');
			}
		}
		return false;
	}
	
	/**
	 *	Gets the default asset Rules for a component/view.
	 */
	protected static function getDefaultAssetRules($component,$view)
	{
		// Need to find the asset id by the name of the component.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName('id'))
			->from($db->quoteName('#__assets'))
			->where($db->quoteName('name') . ' = ' . $db->quote($component));
		$db->setQuery($query);
		$db->execute();
		if ($db->loadRowList())
		{
			// asset alread set so use saved rules
			$assetId = (int) $db->loadResult();
			$result =  JAccess::getAssetRules($assetId);
			if ($result instanceof JAccessRules)
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
					else
					{
						// clear the value since we inherit
						$rule = array();
					}
				}
				// check if there are any view values remaining
				if (count($_result))
				{
					$_result = json_encode($_result);
					$_result = array($_result);
					// Instantiate and return the JAccessRules object for the asset rules.
					$rules = new JAccessRules($_result);

					return $rules;
				}
				return $result;
			}
		}
		return JAccess::getAssetRules(0);
	}

	public static function renderBoolButton()
	{
		$args = func_get_args();

		// get the radio element
		$button = JFormHelper::loadFieldType('radio');

		// setup the properties
		$name	 	= self::htmlEscape($args[0]);
		$additional = isset($args[1]) ? (string) $args[1] : '';
		$value		= $args[2];
		$yes 	 	= isset($args[3]) ? self::htmlEscape($args[3]) : 'JYES';
		$no 	 	= isset($args[4]) ? self::htmlEscape($args[4]) : 'JNO';

		// prepare the xml
		$element = new SimpleXMLElement('<field name="'.$name.'" type="radio" class="btn-group"><option '.$additional.' value="0">'.$no.'</option><option '.$additional.' value="1">'.$yes.'</option></field>');

		// run
		$button->setup($element, $value);

		return $button->input;

	}
	
	public static function checkJson($string)
	{
		if (self::checkString($string))
		{
			json_decode($string);
			return (json_last_error() === JSON_ERROR_NONE);
		}
		return false;
	}

	public static function checkObject($object)
	{
		if (isset($object) && is_object($object) && count($object) > 0)
		{
			return true;
		}
		return false;
	}

	public static function checkArray($array)
	{
		if (isset($array) && is_array($array) && count($array) > 0)
		{
			return true;
		}
		return false;
	}

	public static function checkString($string)
	{
		if (isset($string) && is_string($string) && strlen($string) > 0)
		{
			return true;
		}
		return false;
	}

	public static function mergeArrays($arrays)
	{
		if(self::checkArray($arrays))
		{
			$arrayBuket = array();
			foreach ($arrays as $array)
			{
				if (self::checkArray($array))
				{
					$arrayBuket = array_merge($arrayBuket, $array);
				}
			}
			return $arrayBuket;
		}
		return false;
	}

	public static function sorten($string, $length = 40, $addTip = true)
	{
		if (self::checkString($string))
        {
			$initial = strlen($string);
			$words = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
			$words_count = count($words);

			$word_length = 0;
			$last_word = 0;
			for (; $last_word < $words_count; ++$last_word)
			{
				$word_length += strlen($words[$last_word]);
				if ($word_length > $length)
				{
					break;
				}
			}

			$newString	= implode(array_slice($words, 0, $last_word));
			$final	= strlen($newString);
			if ($initial != $final && $addTip)
			{
				$title = self::sorten($string, 400 , false);
				return '<span class="hasTip" title="'.$title.'" style="cursor:help">'.trim($newString).'...</span>';
			}
			elseif ($initial != $final && !$addTip)
			{
				return trim($newString).'...';
			}
		}
		return $string;
	}

	public static function safeString($string, $type = 'L', $spacer = '_')
	{
		// remove all numbers and replace with english text version (works well only up to a thousand)
                $string = self::replaceNumbers($string);

                if (self::checkString($string))
                {
                        // remove all other characters
                        $string = trim($string);
                        $string = preg_replace('/'.$spacer.'+/', ' ', $string);
                        $string = preg_replace('/\s+/', ' ', $string);
                        $string = preg_replace("/[^A-Za-z ]/", '', $string);
                        // return a string with all first letter of each word uppercase(no undersocre)
                        if ($type == 'W')
                                    {
                            return ucwords(strtolower($string));
                        }
                        elseif ($type == 'w')
                        {
                            return strtolower($string);
                        }
                        elseif ($type == 'Ww')
                        {
                            return ucfirst(strtolower($string));
                        }
                        elseif ($type == 'WW')
                        {
                            return strtoupper($string);
                        }
                        elseif ($type == 'U')
                        {
                                // replace white space with underscore
                                $string = preg_replace('/\s+/', $spacer, $string);
                                // return all upper
                                return strtoupper($string);
                        }
                        elseif ($type == 'F')
                        {
                                // replace white space with underscore
                                $string = preg_replace('/\s+/', $spacer, $string);
                                // return with first caracter to upper
                                return ucfirst(strtolower($string));
                        }
                        elseif ($type == 'L')
                        {
                                // replace white space with underscore
                                $string = preg_replace('/\s+/', $spacer, $string);
                                // default is to return lower
                                return strtolower($string);
                        }

                        // return string
                        return $string;
                }
                // not a string
                return '';
	}

        public static function htmlEscape($var, $charset = 'UTF-8', $sorten = false, $length = 40)
	{
		if (self::checkString($var))
		{
			$filter = new JFilterInput();
			$string = $filter->clean(html_entity_decode(htmlentities($var, ENT_COMPAT, $charset)), 'HTML');
			if ($sorten)
			{
                                return self::sorten($string,$length);
			}
			return $string;
                }
		else
		{
			return '';
                }
	}

	public static function replaceNumbers($string)
	{
		// set numbers array
		$numbers = array();
		// first get all numbers
		preg_match_all('!\d+!', $string, $numbers);
		// check if we have any numbers
		if (isset($numbers[0]) && self::checkArray($numbers[0]))
		{
			foreach ($numbers[0] as $number)
			{
				$searchReplace[$number] = self::numberToString((int)$number);
			}
			// now replace numbers in string
			$string = str_replace(array_keys($searchReplace), array_values($searchReplace),$string);
			// check if we missed any, strange if we did.
			return self::replaceNumbers($string);
		}
		// return the string with no numbers remaining.
		return $string;
	}
	
	/**
	*	Convert an integer into an English word string
	*	Thanks to Tom Nicholson <http://php.net/manual/en/function.strval.php#41988>
	*
	*	@input	an int
	*	@returns a string
	**/
	public static function numberToString($x)
	{
		$nwords = array( "zero", "one", "two", "three", "four", "five", "six", "seven",
			"eight", "nine", "ten", "eleven", "twelve", "thirteen",
			"fourteen", "fifteen", "sixteen", "seventeen", "eighteen",
			"nineteen", "twenty", 30 => "thirty", 40 => "forty",
			50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty",
			90 => "ninety" );

		if(!is_numeric($x))
		{
			$w = $x;
		}
		elseif(fmod($x, 1) != 0)
		{
			$w = $x;
		}
		else
		{
			if($x < 0)
			{
				$w = 'minus ';
				$x = -$x;
			}
			else
			{
				$w = '';
				// ... now $x is a non-negative integer.
			}

			if($x < 21)   // 0 to 20
			{
				$w .= $nwords[$x];
			}
			elseif($x < 100)  // 21 to 99
			{ 
				$w .= $nwords[10 * floor($x/10)];
				$r = fmod($x, 10);
				if($r > 0)
				{
					$w .= ' '. $nwords[$r];
				}
			}
			elseif($x < 1000)  // 100 to 999
			{
				$w .= $nwords[floor($x/100)] .' hundred';
				$r = fmod($x, 100);
				if($r > 0)
				{
					$w .= ' and '. self::numberToString($r);
				}
			}
			elseif($x < 1000000)  // 1000 to 999999
			{
				$w .= self::numberToString(floor($x/1000)) .' thousand';
				$r = fmod($x, 1000);
				if($r > 0)
				{
					$w .= ' ';
					if($r < 100)
					{
						$w .= 'and ';
					}
					$w .= self::numberToString($r);
				}
			} 
			else //  millions
			{    
				$w .= self::numberToString(floor($x/1000000)) .' million';
				$r = fmod($x, 1000000);
				if($r > 0)
				{
					$w .= ' ';
					if($r < 100)
					{
						$w .= 'and ';
					}
					$w .= self::numberToString($r);
				}
			}
		}
		return $w;
	}

	/**
	*	Random Key
	*
	*	@returns a string
	**/
	public static function randomkey($size)
	{
		$bag = "abcefghijknopqrstuwxyzABCDDEFGHIJKLLMMNOPQRSTUVVWXYZabcddefghijkllmmnopqrstuvvwxyzABCEFGHIJKNOPQRSTUWXYZ";
		$key = array();
		$bagsize = strlen($bag) - 1;
		for ($i = 0; $i < $size; $i++)
		{
			$get = rand(0, $bagsize);
			$key[] = $bag[$get];
		}
		return implode($key);
	}

	public static function getCryptKey($type)
	{
		if ('basic' == $type)
		{
			// Get the global params
			$params = JComponentHelper::getParams('com_componentbuilder', true);
			$basic_key = $params->get('basic_key', null);
			if ($basic_key)
			{
				return $basic_key;
			}
		}
		return false;
	}
}
