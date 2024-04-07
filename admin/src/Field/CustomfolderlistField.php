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
namespace VDM\Component\Componentbuilder\Administrator\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Customfolderlist Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class CustomfolderlistField extends ListField
{
	/**
	 * The customfolderlist field type.
	 *
	 * @var        string
	 */
	public $type = 'Customfolderlist';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// get custom folder folder
		$localfolder = ComponentHelper::getParams('com_componentbuilder')->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
		// set the default
		$options[] = Html::_('select.option', '', Text::sprintf('COM_COMPONENTBUILDER_PLEASE_ADD_FOLDERS_TO_S',$localfolder));
		// setup the folder if it does not exist
		if (!\JFolder::exists($localfolder))
		{
			\JFolder::create($localfolder);
		}
		// now check if there are files in the folder
		if ($folders = \JFolder::folders($localfolder))
		{
			$options = [];
			foreach ($folders as $folder)
			{
				$options[] = Html::_('select.option', $folder, $folder);
			}
		}
		return $options;
	}
}
