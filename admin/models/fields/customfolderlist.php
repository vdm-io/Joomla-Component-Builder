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

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		customfolderlist.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Customfolderlist Form Field class for the Componentbuilder component
 */
class JFormFieldCustomfolderlist extends JFormFieldList
{
	/**
	 * The customfolderlist field type.
	 *
	 * @var		string
	 */
	public $type = 'customfolderlist';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	public function getOptions()
	{
		// get custom folder folder
		$localfolder = JComponentHelper::getParams('com_componentbuilder')->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
		// set the default
		$options[] = JHtml::_('select.option', '', JText::sprintf('COM_COMPONENTBUILDER_PLEASE_ADD_FOLDERS_TO_S',$localfolder));
		// import all needed classes
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		// setup the folder if it does not exist
		if (!JFolder::exists($localfolder))
		{
			JFolder::create($localfolder);
		}
		// now check if there are files in the folder
		if ($folders = JFolder::folders($localfolder))
		{
			$options = array();
			foreach ($folders as $folder)
			{
				$options[] = JHtml::_('select.option', $folder, $folder);
			}
		}
		return $options;
	}
}
