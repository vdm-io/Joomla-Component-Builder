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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Session\Session;

/**
 * ###Component### Ajax Controller
 */
class ###Component###ControllerAjax extends JControllerLegacy
{
	public function __construct($config)
	{
		parent::__construct($config);
		// make sure all json stuff are set
		Factory::getDocument()->setMimeEncoding( 'application/json' );
		Factory::getApplication()->setHeader('Content-Disposition','attachment;filename="getajax.json"');
		Factory::getApplication()->setHeader("Access-Control-Allow-Origin", "*");
		// load the tasks
		$this->registerTask('fieldRequired', 'ajax');
	}

	public function ajax()
	{
		$user       = Factory::getUser();
		$jinput     = Factory::getApplication()->input;
		// Check Token!
		$token      = Session::getFormToken();
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

						if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($name) && Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($form))
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
