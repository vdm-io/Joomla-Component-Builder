<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * ###Component### Ajax Controller
 */
class ###Component###ControllerAjax extends JControllerLegacy
{
	public function __construct($config)
	{
		parent::__construct($config);
		// make sure all json stuff are set
		JFactory::getDocument()->setMimeEncoding( 'application/json' );
		JResponse::setHeader('Content-Disposition','attachment;filename="getajax.json"');
		JResponse::setHeader("Access-Control-Allow-Origin", "*");
		// load the tasks
		$this->registerTask('fieldRequired', 'ajax');
	}

	public function ajax()
	{
		$user = JFactory::getUser();
		$jinput = JFactory::getApplication()->input;
		// Check Token!
		$token = JSession::getFormToken();
		$call_token = $jinput->get('token', 0, 'ALNUM');
		if($user->id != 0 && $token == $call_token)
		{
			$task = $this->getTask();
			switch($task){
				case 'fieldRequired':
					try
					{
						$name = $jinput->get('name', NULL, 'WORD');
						$form = $jinput->get('form', NULL, 'WORD');
						$status = $jinput->get('status', NULL, 'INT');
						
						if (###Component###Helper::checkString($name) && ###Component###Helper::checkString($form))
						{
							$result = $this->getModel('ajax')->setFieldRequired($name,$form,$status);
						}
						else
						{
							$result = false;
						}
						if($callback = $jinput->get('callback', null, 'CMD'))
						{
							echo $callback . "(".json_encode($result).");";
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
