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

	@version		2.5.6
	@build			6th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controller');

/**
 * Componentbuilder Help Controller
 */
class ComponentbuilderControllerHelp extends JControllerLegacy
{
	public function __construct($config)
	{
		parent::__construct($config);
		// load the tasks
		$this->registerTask('getText', 'help');
	}

	public function help()
	{
		$user 		= JFactory::getUser();
		$jinput 	= JFactory::getApplication()->input;
		// Check Token!
		$token 		= JSession::getFormToken();
		$call_token	= $jinput->get('token', 0, 'ALNUM');
		if($token == $call_token){
			$task = $this->getTask();
			switch($task){
				case 'getText':
					try
					{
						$idValue = $jinput->get('id', 0, 'INT');
						if($idValue)
						{
							$result = $this->getHelpDocumentText($idValue);
						}
						else
						{
							$result = '';
						}
						echo $result;
                                                // stop execution gracefully
                                                jexit();
					}
					catch(Exception $e)
					{
                                                // stop execution gracefully
						jexit();
					}
				break;
			}
		}
                else
                {
                        // stop execution gracefully
			jexit();
		}
	}

        protected function getHelpDocumentText($id)
	{
		$db	= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(array('a.title','a.content'));
		$query->from('#__componentbuilder_help_document AS a');
		$query->where('a.id = '.(int) $id);
		$query->where('a.published = 1');
		$query->where('a.location = 2');
		$db->setQuery($query);
		$db->execute();
		if($db->getNumRows())
		{
			$text = array();
			$document = $db->loadObject();
			// fix image issue
			$images['src="images'] = 'src="'.JURI::root().'images';
			$images["src='images"] = "src='".JURI::root()."images";
			$images['src="/images'] = 'src="'.JURI::root().'images';
			$images["src='/images"] = "src='".JURI::root()."images";
			// set document template
			$text[] = "<!doctype html>";
			$text[] = '<html>';
			$text[] = "<head>";
			$text[] = '<meta charset="utf-8">';
			$text[] = "<title>".$document->title."</title>";
			$text[] = '<link type="text/css" href="'.JURI::root().'media/com_componentbuilder/uikit/css/uikit.gradient.min.css" rel="stylesheet"></link>';
			$text[] = '<script type="text/javascript" src="'.JURI::root().'media/com_componentbuilder/uikit/js/uikit.min.js"></script>';
			$text[] = "</head>";
			$text[] = '<body><br />';
			$text[] = '<div class="uk-container uk-container-center uk-grid-collapse">';
			$text[] = '<div class="uk-panel uk-width-1-1 uk-panel-box uk-panel-box-primary">';
			// build the help text
			$text[] = '<h1 class="uk-panel-title">'.$document->title."</h1>";
			$text[] = str_replace(array_keys($images),array_values($images),$document->content);
			// end template
			$text[] = '</div><br /><br />';
			$text[] = '</div>';
			$text[] = "</body>";
			$text[] = "</html>";

			return implode("\n",$text);
		}
		return false;
	}
}
