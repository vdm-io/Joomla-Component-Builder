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

###IMPORT_CUSTOM_CONTROLLER_HEADER###

/**
 * ###Component### ###View### Base Controller
 */
class ###Component###Controller###View### extends BaseController
{
	/**
	 * Import an spreadsheet.
	 *
	 * @return  void
	 */
	public function import()
	{
		// Check for request forgeries
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		$model = $this->getModel('###View###');
		if ($model->import())
		{
			$cache = Factory::getCache('mod_menu');
			$cache->clean();
			// TODO: Reset the users acl here as well to kill off any missing bits
		}

		$app = Factory::getApplication();
		$redirect_url = $app->getUserState('com_###component###.redirect_url');
		if (empty($redirect_url))
		{
			$redirect_url = Route::_('index.php?option=com_###component###&view=###view###', false);
		}
		else
		{
			// wipe out the user state when we're going to redirect
			$app->setUserState('com_###component###.redirect_url', '');
			$app->setUserState('com_###component###.message', '');
			$app->setUserState('com_###component###.extension_message', '');
		}
		$this->setRedirect($redirect_url);
	}
}
