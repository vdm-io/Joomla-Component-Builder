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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * ###Component### Ajax Model
 */
class ###Component###ModelAjax extends JModelList
{
	protected $app_params;

	public function __construct()
	{		
		parent::__construct();		
		// get params
		$this->app_params = JComponentHelper::getParams('com_###component###');
	}

	public function setFieldRequired($name,$form,$status)
	{
		// get the session
		$session = JFactory::getSession();
		// get this forms set fields
		$fields = $session->get($form.'_requiredFieldFix');
		if(###Component###Helper::checkArray($fields))
		{
			if ($status == 1)
			{
				$fields[] = $name;
				$fields = array_unique($fields);
			}
			else
			{	
				// remove from array
				if(($key = array_search($name, $fields)) !== false)
				{
					unset($fields[$key]);
				}
			}
		}
		else
		{
			if ($status == 1)
			{
				$fields = array($name);
			}
		}
		// load the remaining values to seesion
		if(###Component###Helper::checkArray($fields))
		{
			$session->set($form.'_requiredFieldFix', $fields);
		}
		else
		{
			$session->clear($form.'_requiredFieldFix');
		}
		return true;
	}
}
