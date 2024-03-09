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
 * Libraryfiles Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class LibraryfilesField extends ListField
{
	/**
	 * The libraryfiles field type.
	 *
	 * @var        string
	 */
	public $type = 'Libraryfiles';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// get the input from url
		$jinput = Factory::getApplication()->input;
		// get the library id
		$id = $jinput->getInt('id', 0);
		// get custom the files
		$files = ComponentbuilderHelper::getLibraryFiles($id);
		// set the default
		$options[] = Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_NO_FILES_LINKED'));
		// now check if there are files in the folder
		if (ComponentbuilderHelper::checkArray($files))
		{
			$options = array();
			foreach ($files as $file => $name)
			{
				$options[] = Html::_('select.option', $file, $name);
			}
		}
		return $options;
	}
}
