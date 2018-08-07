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
