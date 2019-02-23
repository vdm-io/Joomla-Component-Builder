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
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
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
