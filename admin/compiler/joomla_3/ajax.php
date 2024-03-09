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
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Component\ComponentHelper;

/**
 * ###Component### Ajax Model
 */
class ###Component###ModelAjax extends ListModel
{
	protected $app_params;

	public function __construct()
	{
		parent::__construct();
		// get params
		$this->app_params = ComponentHelper::getParams('com_###component###');
	}

	public function setFieldRequired($name,$form,$status)
	{
		// get the session
		$session = Factory::getSession();
		// get this forms set fields
		$fields = $session->get($form.'_requiredFieldFix');
		if(Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($fields))
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
		// load the remaining values to session
		if(Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($fields))
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
