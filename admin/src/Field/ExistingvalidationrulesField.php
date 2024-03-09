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
 * Existingvalidationrules Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class ExistingvalidationrulesField extends ListField
{
	/**
	 * The existingvalidationrules field type.
	 *
	 * @var        string
	 */
	public $type = 'Existingvalidationrules';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// get the existing validation rules names
		if ($items = ComponentbuilderHelper::getExistingValidationRuleNames())
		{
			// load the items
			$options = array(Html::_('select.option', '', 'Select an option'));
			foreach($items as $item)
			{
				$options[] = Html::_('select.option', $item, ComponentbuilderHelper::safeString($item, 'Ww'));
			}
			return $options;
		}
		return array(Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_NO_VALIDATION_RULES_FOUND')));
	}
}
