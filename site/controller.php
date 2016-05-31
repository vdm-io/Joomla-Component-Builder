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

	@version		2.1.10
	@build			31st May, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		controller.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Componentbuilder Component Controller
 */
class ComponentbuilderController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
        function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view		= $this->input->getCmd('view', '###SITE_DEFAULT_VIEW###');
		$isEdit		= $this->checkEditView($view);
		$layout		= $this->input->get('layout', null, 'WORD');
		$id		= $this->input->getInt('id');
		$cachable	= true;
		
		// Check for edit form.
                if($isEdit)
                {
			if ($layout == 'edit' && !$this->checkEditId('com_componentbuilder.edit.'.$view, $id))
			{
				// Somehow the person just went to the form - we don't allow that.
				$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
				$this->setMessage($this->getError(), 'error');
				// check if item was opend from other then its own list view
				$ref 	= $this->input->getCmd('ref', 0);
				$refid 	= $this->input->getInt('refid', 0);
				// set redirect
				if ($refid > 0 && ComponentbuilderHelper::checkString($ref))
				{
					// redirect to item of ref
					$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view='.(string)$ref.'&layout=edit&id='.(int)$refid, false));
				}
				elseif (ComponentbuilderHelper::checkString($ref))
				{

					// redirect to ref
					 $this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view='.(string)$ref, false));
				}
				else
				{
					// normal redirect back to the list default site view
					$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=###SITE_DEFAULT_VIEW###', false));
				}
				return false;
			}
                }

		return parent::display($cachable, $urlparams);
	}

	protected function checkEditView($view)
	{
                if (ComponentbuilderHelper::checkString($view))
                {
                        $views = array(

                                );
                        // check if this is a edit view
                        if (in_array($view,$views))
                        {
                                return true;
                        }
                }
		return false;
	}
}
