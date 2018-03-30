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
	@subpackage		filebehaviour.php
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
 * Filebehaviour Form Field class for the Componentbuilder component
 */
class JFormFieldFilebehaviour extends JFormFieldList
{
	/**
	 * The filebehaviour field type.
	 *
	 * @var		string
	 */
	public $type = 'filebehaviour';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	public function getOptions()
	{
		// get the input from url
		$jinput = JFactory::getApplication()->input;
		// get the library id
		$libID = $jinput->getInt('id', 0);
		$options[] = JHtml::_('select.option', '1', JText::_('COM_COMPONENTBUILDER_ALWAYS_ADD'));
		// add build in option for some libraries
		$buildin = array(3 => 'Uikit v3', 4 => 'Uikit v2', 5 => 'FooTable v2', 6 => 'FooTable v3');
		if (isset($buildin[$libID]))
		{
			$options[] = JHtml::_('select.option', '4', JText::_('COM_COMPONENTBUILDER_BUILDIN'));
		}
		$options[] = JHtml::_('select.option', '2', JText::_('COM_COMPONENTBUILDER_CONDITIONS'));
		$options[] = JHtml::_('select.option', '3', JText::_('COM_COMPONENTBUILDER_CUSTOM_SCRIPT'));
		$options[] = JHtml::_('select.option', '0', JText::_('COM_COMPONENTBUILDER_DO_NOT_ADD'));
		return $options;
	}
}
