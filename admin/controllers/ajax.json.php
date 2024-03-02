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

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Session\Session;
use Joomla\Utilities\ArrayHelper;

/**
 * Componentbuilder Ajax Base Controller
 */
class ComponentbuilderControllerAjax extends BaseController
{
	public function __construct($config)
	{
		parent::__construct($config);
		// make sure all json stuff are set
		Factory::getDocument()->setMimeEncoding( 'application/json' );
		// get the application
		$app = Factory::getApplication();
		$app->setHeader('Content-Disposition','attachment;filename="getajax.json"');
		$app->setHeader('Access-Control-Allow-Origin', '*');
		// load the tasks 
		$this->registerTask('isNew', 'ajax');
		$this->registerTask('isRead', 'ajax');
		$this->registerTask('getComponentDetails', 'ajax');
		$this->registerTask('getCronPath', 'ajax');
		$this->registerTask('getWiki', 'ajax');
		$this->registerTask('getVersion', 'ajax');
		$this->registerTask('getJCBpackageInfo', 'ajax');
		$this->registerTask('getCrowdinDetails', 'ajax');
		$this->registerTask('getModuleCode', 'ajax');
		$this->registerTask('getClassCode', 'ajax');
		$this->registerTask('getClassCodeIds', 'ajax');
		$this->registerTask('getClassHeaderCode', 'ajax');
		$this->registerTask('tableColumns', 'ajax');
		$this->registerTask('fieldSelectOptions', 'ajax');
		$this->registerTask('getDynamicScripts', 'ajax');
		$this->registerTask('getButton', 'ajax');
		$this->registerTask('getButtonID', 'ajax');
		$this->registerTask('getAjaxDisplay', 'ajax');
		$this->registerTask('getLinked', 'ajax');
		$this->registerTask('checkAliasField', 'ajax');
		$this->registerTask('checkCategoryField', 'ajax');
		$this->registerTask('templateDetails', 'ajax');
		$this->registerTask('getLayoutDetails', 'ajax');
		$this->registerTask('dbTableColumns', 'ajax');
		$this->registerTask('viewTableColumns', 'ajax');
		$this->registerTask('getDynamicValues', 'ajax');
		$this->registerTask('checkFunctionName', 'ajax');
		$this->registerTask('usedin', 'ajax');
		$this->registerTask('getEditCustomCodeButtons', 'ajax');
		$this->registerTask('placedin', 'ajax');
		$this->registerTask('checkPlaceholderName', 'ajax');
		$this->registerTask('getExistingValidationRuleCode', 'ajax');
		$this->registerTask('getValidationRulesTable', 'ajax');
		$this->registerTask('checkRuleName', 'ajax');
		$this->registerTask('fieldTypeProperties', 'ajax');
		$this->registerTask('getFieldPropertyDesc', 'ajax');
		$this->registerTask('getCodeGlueOptions', 'ajax');
		$this->registerTask('doSearch', 'ajax');
		$this->registerTask('replaceAll', 'ajax');
		$this->registerTask('getSearchValue', 'ajax');
		$this->registerTask('getReplaceValue', 'ajax');
		$this->registerTask('setValue', 'ajax');
		$this->registerTask('snippetDetails', 'ajax');
		$this->registerTask('setSnippetGithub', 'ajax');
		$this->registerTask('getSnippets', 'ajax');
	}

	public function ajax()
	{
		// get the user for later use
		$user         = Factory::getUser();
		// get the input values
		$jinput       = Factory::getApplication()->input;
		// check if we should return raw
		$returnRaw    = $jinput->get('raw', false, 'BOOLEAN');
		// return to a callback function
		$callback     = $jinput->get('callback', null, 'CMD');
		// Check Token!
		$token        = Session::getFormToken();
		$call_token   = $jinput->get('token', 0, 'ALNUM');
		if($jinput->get($token, 0, 'ALNUM') || $token === $call_token)
		{
			// get the task
			$task = $this->getTask();
			switch($task)
			{
				case 'isNew':
					try
					{
						$noticeValue = $jinput->get('notice', NULL, 'STRING');
						if($noticeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->isNew($noticeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$noticeValue = $jinput->get('notice', NULL, 'STRING');
						if($noticeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->isRead($noticeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getComponentDetails($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$getTypeValue = $jinput->get('getType', NULL, 'WORD');
						if($getTypeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getCronPath($getTypeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getWiki':
					try
					{
						$nameValue = $jinput->get('name', NULL, 'WORD');
						if($nameValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getWiki($nameValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getVersion':
					try
					{
						$versionValue = $jinput->get('version', NULL, 'INT');
						if($versionValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getVersion($versionValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getJCBpackageInfo':
					try
					{
						$packageValue = $jinput->get('package', NULL, 'BASE64');
						if($packageValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getJCBpackageInfo($packageValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getCrowdinDetails':
					try
					{
						$identifierValue = $jinput->get('identifier', NULL, 'CMD');
						$keyValue = $jinput->get('key', NULL, 'ALNUM');
						if($identifierValue && $user->id != 0 && $keyValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getCrowdinDetails($identifierValue, $keyValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getModuleCode':
					try
					{
						$dataValue = $jinput->get('data', NULL, 'STRING');
						if($dataValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getModuleCode($dataValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getClassCode':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						$typeValue = $jinput->get('type', NULL, 'WORD');
						if($idValue && $user->id != 0 && $typeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getClassCode($idValue, $typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getClassCodeIds':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						$typeValue = $jinput->get('type', NULL, 'WORD');
						$keyValue = $jinput->get('key', 1, 'INT');
						if($idValue && $user->id != 0 && $typeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getClassCodeIds($idValue, $typeValue, $keyValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getClassHeaderCode':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						$typeValue = $jinput->get('type', NULL, 'WORD');
						if($idValue && $user->id != 0 && $typeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getClassHeaderCode($idValue, $typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$tableValue = $jinput->get('table', NULL, 'WORD');
						if($tableValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getTableColumns($tableValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getFieldSelectOptions($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getDynamicScripts':
					try
					{
						$typeValue = $jinput->get('type', NULL, 'WORD');
						if($typeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getDynamicScripts($typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$typeValue = $jinput->get('type', NULL, 'WORD');
						$sizeValue = $jinput->get('size', NULL, 'INT');
						if($typeValue && $user->id != 0 && $sizeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getButton($typeValue, $sizeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getButtonID':
					try
					{
						$typeValue = $jinput->get('type', NULL, 'WORD');
						$sizeValue = $jinput->get('size', NULL, 'INT');
						if($typeValue && $user->id != 0 && $sizeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getButtonID($typeValue, $sizeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getAjaxDisplay':
					try
					{
						$typeValue = $jinput->get('type', NULL, 'WORD');
						if($typeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getAjaxDisplay($typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getLinked':
					try
					{
						$typeValue = $jinput->get('type', NULL, 'ALNUM');
						if($typeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getLinked($typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'checkAliasField':
					try
					{
						$typeValue = $jinput->get('type', NULL, 'ALNUM');
						if($typeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->checkAliasField($typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'checkCategoryField':
					try
					{
						$typeValue = $jinput->get('type', NULL, 'ALNUM');
						if($typeValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->checkCategoryField($typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', null, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getTemplateDetails($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getLayoutDetails($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$nameValue = $jinput->get('name', NULL, 'WORD');
						$asValue = $jinput->get('as', NULL, 'WORD');
						$typeValue = $jinput->get('type', NULL, 'INT');
						if($nameValue && $user->id != 0 && $asValue && $typeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getDbTableColumns($nameValue, $asValue, $typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', NULL, 'INT');
						$asValue = $jinput->get('as', NULL, 'WORD');
						$typeValue = $jinput->get('type', NULL, 'INT');
						if($idValue && $user->id != 0 && $asValue && $typeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getViewTableColumns($idValue, $asValue, $typeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', NULL, 'INT');
						$viewValue = $jinput->get('view', NULL, 'WORD');
						if($idValue && $user->id != 0 && $viewValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getDynamicValues($idValue, $viewValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$functioNameValue = $jinput->get('functioName', NULL, 'STRING');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($functioNameValue && $user->id != 0 && $idValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->checkFunctionName($functioNameValue, $idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$functioNameValue = $jinput->get('functioName', NULL, 'WORD');
						$idValue = $jinput->get('id', NULL, 'INT');
						$targetValue = $jinput->get('target', NULL, 'WORD');
						if($functioNameValue && $user->id != 0 && $idValue && $targetValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->usedin($functioNameValue, $idValue, $targetValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getEditCustomCodeButtons':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getEditCustomCodeButtons($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'placedin':
					try
					{
						$placeholderValue = $jinput->get('placeholder', NULL, 'WORD');
						$idValue = $jinput->get('id', NULL, 'INT');
						$targetValue = $jinput->get('target', NULL, 'WORD');
						if($placeholderValue && $user->id != 0 && $idValue && $targetValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->placedin($placeholderValue, $idValue, $targetValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'checkPlaceholderName':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						$placeholderNameValue = $jinput->get('placeholderName', NULL, 'STRING');
						if($idValue && $user->id != 0 && $placeholderNameValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->checkPlaceholderName($idValue, $placeholderNameValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getExistingValidationRuleCode':
					try
					{
						$nameValue = $jinput->get('name', NULL, 'WORD');
						if($nameValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getExistingValidationRuleCode($nameValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getValidationRulesTable':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getValidationRulesTable($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'checkRuleName':
					try
					{
						$nameValue = $jinput->get('name', NULL, 'STRING');
						$idValue = $jinput->get('id', NULL, 'INT');
						if($nameValue && $user->id != 0 && $idValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->checkRuleName($nameValue, $idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'fieldTypeProperties':
					try
					{
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getFieldTypeProperties($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getFieldPropertyDesc':
					try
					{
						$propertyValue = $jinput->get('property', NULL, 'WORD');
						$fieldtypeValue = $jinput->get('fieldtype', NULL, 'ALNUM');
						if($propertyValue && $user->id != 0 && $fieldtypeValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getFieldPropertyDesc($propertyValue, $fieldtypeValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getCodeGlueOptions':
					try
					{
						$listfieldValue = $jinput->get('listfield', NULL, 'INT');
						$joinfieldsValue = $jinput->get('joinfields', NULL, 'STRING');
						$typeValue = $jinput->get('type', NULL, 'INT');
						$areaValue = $jinput->get('area', NULL, 'INT');
						if($listfieldValue && $user->id != 0 && $joinfieldsValue && $typeValue && $areaValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getCodeGlueOptions($listfieldValue, $joinfieldsValue, $typeValue, $areaValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'doSearch':
					try
					{
						$table_nameValue = $jinput->get('table_name', NULL, 'WORD');
						$type_searchValue = $jinput->get('type_search', 1, 'INT');
						$search_valueValue = $jinput->get('search_value', NULL, 'RAW');
						$match_caseValue = $jinput->get('match_case', 0, 'INT');
						$whole_wordValue = $jinput->get('whole_word', 0, 'INT');
						$regex_searchValue = $jinput->get('regex_search', 0, 'INT');
						$component_idValue = $jinput->get('component_id', 0, 'INT');
						if($table_nameValue && $user->id != 0 && $type_searchValue && $search_valueValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->doSearch($table_nameValue, $type_searchValue, $search_valueValue, $match_caseValue, $whole_wordValue, $regex_searchValue, $component_idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'replaceAll':
					try
					{
						$table_nameValue = $jinput->get('table_name', NULL, 'WORD');
						$search_valueValue = $jinput->get('search_value', NULL, 'RAW');
						$replace_valueValue = $jinput->get('replace_value', NULL, 'RAW');
						$match_caseValue = $jinput->get('match_case', 0, 'INT');
						$whole_wordValue = $jinput->get('whole_word', 0, 'INT');
						$regex_searchValue = $jinput->get('regex_search', 0, 'INT');
						$component_idValue = $jinput->get('component_id', 0, 'INT');
						if($table_nameValue && $user->id != 0 && $search_valueValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->replaceAll($table_nameValue, $search_valueValue, $replace_valueValue, $match_caseValue, $whole_wordValue, $regex_searchValue, $component_idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getSearchValue':
					try
					{
						$field_nameValue = $jinput->get('field_name', NULL, 'WORD');
						$row_idValue = $jinput->get('row_id', NULL, 'INT');
						$table_nameValue = $jinput->get('table_name', NULL, 'WORD');
						$search_valueValue = $jinput->get('search_value', NULL, 'RAW');
						$replace_valueValue = $jinput->get('replace_value', NULL, 'RAW');
						$match_caseValue = $jinput->get('match_case', 0, 'INT');
						$whole_wordValue = $jinput->get('whole_word', 0, 'INT');
						$regex_searchValue = $jinput->get('regex_search', 0, 'INT');
						if($field_nameValue && $user->id != 0 && $row_idValue && $table_nameValue && $search_valueValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getSearchValue($field_nameValue, $row_idValue, $table_nameValue, $search_valueValue, $replace_valueValue, $match_caseValue, $whole_wordValue, $regex_searchValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getReplaceValue':
					try
					{
						$field_nameValue = $jinput->get('field_name', NULL, 'WORD');
						$row_idValue = $jinput->get('row_id', NULL, 'INT');
						$line_nrValue = $jinput->get('line_nr', 0, 'STRING');
						$table_nameValue = $jinput->get('table_name', NULL, 'WORD');
						$search_valueValue = $jinput->get('search_value', NULL, 'RAW');
						$replace_valueValue = $jinput->get('replace_value', NULL, 'RAW');
						$match_caseValue = $jinput->get('match_case', 0, 'INT');
						$whole_wordValue = $jinput->get('whole_word', 0, 'INT');
						$regex_searchValue = $jinput->get('regex_search', 0, 'INT');
						if($field_nameValue && $user->id != 0 && $row_idValue && $table_nameValue && $search_valueValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getReplaceValue($field_nameValue, $row_idValue, $line_nrValue, $table_nameValue, $search_valueValue, $replace_valueValue, $match_caseValue, $whole_wordValue, $regex_searchValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'setValue':
					try
					{
						$valueValue = $jinput->get('value', NULL, 'RAW');
						$row_idValue = $jinput->get('row_id', NULL, 'INT');
						$field_nameValue = $jinput->get('field_name', NULL, 'WORD');
						$table_nameValue = $jinput->get('table_name', NULL, 'WORD');
						if($valueValue && $user->id != 0 && $row_idValue && $field_nameValue && $table_nameValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->setValue($valueValue, $row_idValue, $field_nameValue, $table_nameValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
						$idValue = $jinput->get('id', NULL, 'INT');
						if($idValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getSnippetDetails($idValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'setSnippetGithub':
					try
					{
						$pathValue = $jinput->get('path', NULL, 'STRING');
						$statusValue = $jinput->get('status', NULL, 'WORD');
						if($pathValue && $user->id != 0 && $statusValue)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->setSnippetGithub($pathValue, $statusValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
						}
						else
						{
							echo "(".json_encode($e).");";
						}
					}
				break;
				case 'getSnippets':
					try
					{
						$librariesValue = $jinput->get('libraries', NULL, 'STRING');
						if($librariesValue && $user->id != 0)
						{
							$ajaxModule = $this->getModel('ajax');
							if ($ajaxModule)
							{
								$result = $ajaxModule->getSnippets($librariesValue);
							}
							else
							{
								$result = false;
							}
						}
						else
						{
							$result = false;
						}
						if($callback)
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
					catch(\Exception $e)
					{
						if($callback)
						{
							echo $callback."(".json_encode($e).");";
						}
						elseif($returnRaw)
						{
							echo json_encode($e);
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
			// return to a callback function
			if($callback)
			{
				echo $callback."(".json_encode(false).");";
			}
			elseif($returnRaw)
			{
				echo json_encode(false);
			}
			else
			{
				echo "(".json_encode(false).");";
			}
		}
	}
}
