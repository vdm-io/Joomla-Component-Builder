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
use VDM\Joomla\Utilities\StringHelper;
use Joomla\CMS\Filesystem\Folder;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Siteviewfolderlist Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class SiteviewfolderlistField extends ListField
{
	/**
	 * The siteviewfolderlist field type.
	 *
	 * @var        string
	 */
	public $type = 'Siteviewfolderlist';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// get custom folder files
		$localfolders = [];
		$localfolders[] = JPATH_SITE . '/components/com_componentbuilder/views';
		$localfolders[] = JPATH_SITE . '/components/com_componentbuilder/src/View';
		// set the default
		$options = [];
		// now check if there are files in the folder
		foreach ($localfolders as $localfolder)
		{
			if (is_dir($localfolder) && $folders = Folder::folders($localfolder))
			{
				if ($this->multiple === false)
				{
					$options[] = Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_SELECT_A_SITE_VIEW'));
				}
				foreach ($folders as $folder)
				{
					$options[] = Html::_('select.option', StringHelper::safe($folder), StringHelper::safe($folder, 'W'));
				}
			}
		}
		return $options;
	}
}
