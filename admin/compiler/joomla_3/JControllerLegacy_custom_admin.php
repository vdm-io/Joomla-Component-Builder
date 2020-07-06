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
 * ###Component### ###SView### Controller
 */
class ###Component###Controller###SView### extends JControllerLegacy
{
	public function __construct($config)
	{
		parent::__construct($config);
	}

	public function dashboard()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_###component###', false));
		return;
	}###CUSTOM_ADMIN_CUSTOM_BUTTONS_CONTROLLER###
}
