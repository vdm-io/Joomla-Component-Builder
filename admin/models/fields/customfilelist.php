<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Customfilelist Form Field class for the Componentbuilder component
 */
class JFormFieldCustomfilelist extends JFormFieldList
{
	/**
	 * The customfilelist field type.
	 *
	 * @var		string
	 */
	public $type = 'customfilelist';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// get custom folder files
		$localfolder = JComponentHelper::getParams('com_componentbuilder')->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
		// set the default
		$options[] = JHtml::_('select.option', '', JText::sprintf('COM_COMPONENTBUILDER_PLEASE_ADD_FILES_TO_S',$localfolder));
		// inport all needed classes
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		// setup the folder if it does not exist
		if (!JFolder::exists($localfolder))
		{
			JFolder::create($localfolder);
		}
		// now check if there are files in the folder
		if ($files = JFolder::files($localfolder))
		{
			$options = array();
			foreach ($files as $file)
			{
				$options[] = JHtml::_('select.option', $file, $file);
			}
		}
		return $options;
	}
}
