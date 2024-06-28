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
 * Filebehaviour Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class FilebehaviourField extends ListField
{
	/**
	 * The filebehaviour field type.
	 *
	 * @var        string
	 */
	public $type = 'Filebehaviour';

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
		$libID = $jinput->getInt('id', 0);
		$options[] = Html::_('select.option', '1', Text::_('COM_COMPONENTBUILDER_ALWAYS_ADD'));
		// add build in option for some libraries
		$buildin = array(3 => 'Uikit v3', 4 => 'Uikit v2', 5 => 'FooTable v2', 6 => 'FooTable v3');
		if (isset($buildin[$libID]))
		{
			$options[] = Html::_('select.option', '4', Text::_('COM_COMPONENTBUILDER_BUILDIN'));
		}
		$options[] = Html::_('select.option', '2', Text::_('COM_COMPONENTBUILDER_CONDITIONS'));
		$options[] = Html::_('select.option', '3', Text::_('COM_COMPONENTBUILDER_CUSTOM_SCRIPT'));
		$options[] = Html::_('select.option', '0', Text::_('COM_COMPONENTBUILDER_DO_NOT_ADD'));
return $options;
	}
}
