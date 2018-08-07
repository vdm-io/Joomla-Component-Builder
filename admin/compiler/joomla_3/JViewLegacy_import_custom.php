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
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED###

/**
 * ###Component### ###View### View
 */
class ###Component###View###View### extends JViewLegacy
{###IMPORT_DISPLAY_METHOD_CUSTOM###

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_###COMPONENT###_IMPORT_TITLE'), 'upload');
		JHtmlSidebar::setAction('index.php?option=com_###component###&view=###view###');

		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_###component###');
		}

		// set help url for this view if found
		$help_url = ###Component###Helper::getHelpUrl('###view###');
		if (###Component###Helper::checkString($help_url))
		{
			   JToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $help_url);
		}
	}
}
