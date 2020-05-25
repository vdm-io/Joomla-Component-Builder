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

use Joomla\Utilities\ArrayHelper;

/**
 * ###SViews### Controller
 */
class ###Component###Controller###SViews### extends JControllerAdmin
{
	protected $text_prefix = 'COM_###COMPONENT###_###SVIEWS###';
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = '###SView###', $prefix = '###Component###Model', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

        public function dashboard()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_###component###', false));
		return;
	}###CUSTOM_ADMIN_CUSTOM_BUTTONS_CONTROLLER###
}
