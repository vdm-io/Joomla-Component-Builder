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

	@version		2.5.6
	@build			6th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		ajax.json.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controller');

/**
 * Componentbuilder Ajax Controller
 */
class ComponentbuilderControllerAjax extends JControllerLegacy
{
	public function __construct($config)
	{
		parent::__construct($config);
		// make sure all json stuff are set
		JFactory::getDocument()->setMimeEncoding( 'application/json' );
		JResponse::setHeader('Content-Disposition','attachment;filename="getajax.json"');
		JResponse::setHeader("Access-Control-Allow-Origin", "*");
		// load the tasks 
		$this->registerTask('isNew', 'ajax');
		$this->registerTask('isRead', 'ajax');
		$this->registerTask('getComponentDetails', 'ajax');
		$this->registerTask('getCronPath', 'ajax');
		$this->registerTask('tableColumns', 'ajax');
		$this->registerTask('fieldSelectOptions', 'ajax');
		$this->registerTask('getImportScripts', 'ajax');
		$this->registerTask('templateDetails', 'ajax');
		$this->registerTask('getLayoutDetails', 'ajax');
		$this->registerTask('dbTableColumns', 'ajax');
		$this->registerTask('viewTableColumns', 'ajax');
		$this->registerTask('getDynamicValues', 'ajax');
		$this->registerTask('checkFunctionName', 'ajax');
		$this->registerTask('usedin', 'ajax');
		$this->registerTask('snippetDetails', 'ajax');
		$this->registerTask('fieldOptions', 'ajax');
		$this->registerTask('getButton', 'ajax');
	}

	public function ajax()
	{
		$user 		= JFactory::getUser();
		$jinput 	= JFactory::getApplication()->input;
		// Check Token!
		$token 		= JSession::getFormToken();
		$call_token	= $jinput->get('token', 0, 'ALNUM');
		if($token == $call_token)
                {
			$task = $this->getTask();
			switch($task)
                        {
				case 'isNew':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$noticeValue = $jinput->get('notice', NULL, 'STRING');
						if($noticeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->isNew($noticeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'isRead':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$noticeValue = $jinput->get('notice', NULL, 'STRING');
						if($noticeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->isRead($noticeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getComponentDetails':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getComponentDetails($idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getCronPath':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$getTypeValue = $jinput->get('getType', NULL, 'WORD');
						if($getTypeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getCronPath($getTypeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'tableColumns':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$tableValue = $jinput->get('table', NULL, 'WORD');
						if($tableValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getTableColumns($tableValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'fieldSelectOptions':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getFieldSelectOptions($idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getImportScripts':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$typeValue = $jinput->get('type', NULL, 'WORD');
						if($typeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getImportScripts($typeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'templateDetails':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', null, 'INT');
						if($idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getTemplateDetails($idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getLayoutDetails':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getLayoutDetails($idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'dbTableColumns':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$nameValue = $jinput->get('name', NULL, 'WORD');
						$asValue = $jinput->get('as', NULL, 'WORD');
						$typeValue = $jinput->get('type', NULL, 'INT');
						if($nameValue && $asValue && $typeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getDbTableColumns($nameValue, $asValue, $typeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'viewTableColumns':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						$asValue = $jinput->get('as', NULL, 'WORD');
						$typeValue = $jinput->get('type', NULL, 'INT');
						if($idValue && $asValue && $typeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getViewTableColumns($idValue, $asValue, $typeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getDynamicValues':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						$viewValue = $jinput->get('view', NULL, 'WORD');
						if($idValue && $viewValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getDynamicValues($idValue, $viewValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'checkFunctionName':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$functioNameValue = $jinput->get('functioName', NULL, 'STRING');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($functioNameValue && $idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->checkFunctionName($functioNameValue, $idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'usedin':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$functioNameValue = $jinput->get('functioName', NULL, 'WORD');
						$idValue = $jinput->get('id', NULL, 'INT');
						$targetValue = $jinput->get('target', NULL, 'WORD');
						if($functioNameValue && $idValue && $targetValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->usedin($functioNameValue, $idValue, $targetValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'snippetDetails':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getSnippetDetails($idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'fieldOptions':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getFieldOptions($idValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getButton':
					try
					{
						$returnRaw = $jinput->get('raw', false, 'BOOLEAN');
						$typeValue = $jinput->get('type', NULL, 'WORD');
						if($typeValue && $user->id != 0)
						{
							$result = $this->getModel('ajax')->getButton($typeValue);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($result);
						}
						else
						{
							echo "(".json_encode($result).");";
						}
					}
					catch(Exception $e)
					{
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback."(".json_encode($e).");";
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
			}
		}
                else
                {
			if($callback = $jinput->get('callback', null, 'CMD'))
                        {
				echo $callback."(".json_encode(false).");";
			}
                        else
                        {
				echo "(".json_encode(false).");";
			}
		}
	}
}
