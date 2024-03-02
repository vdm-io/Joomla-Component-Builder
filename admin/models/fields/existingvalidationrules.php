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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Existingvalidationrules Form Field class for the Componentbuilder component
 */
class JFormFieldExistingvalidationrules extends JFormFieldList
{
	/**
	 * The existingvalidationrules field type.
	 *
	 * @var        string
	 */
	public $type = 'existingvalidationrules';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return    array    An array of Html options.
	 */
	protected function getOptions()
	{
		// get the existing validation rules names
		if ($items = ComponentbuilderHelper::getExistingValidationRuleNames())
		{
			// load the items
			$options = array(JHtml::_('select.option', '', 'Select an option'));
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item, ComponentbuilderHelper::safeString($item, 'Ww'));
			}
			return $options;
		}
		return array(JHtml::_('select.option', '', JText::_('COM_COMPONENTBUILDER_NO_VALIDATION_RULES_FOUND')));
	}
}
