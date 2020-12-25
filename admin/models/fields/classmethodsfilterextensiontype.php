<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2021 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Classmethodsfilterextensiontype Form Field class for the Componentbuilder component
 */
class JFormFieldClassmethodsfilterextensiontype extends JFormFieldList
{
	/**
	 * The classmethodsfilterextensiontype field type.
	 *
	 * @var		string
	 */
	public $type = 'classmethodsfilterextensiontype';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('extension_type'));
		$query->from($db->quoteName('#__componentbuilder_class_method'));
		$query->order($db->quoteName('extension_type') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_EXTENSION_TYPE') . ' -');

		if ($results)
		{
			// get class_methodsmodel
			$model = ComponentbuilderHelper::getModel('class_methods');
			$results = array_unique($results);
			foreach ($results as $extension_type)
			{
				// Translate the extension_type selection
				$text = $model->selectionTranslation($extension_type,'extension_type');
				// Now add the extension_type and its text to the options array
				$_filter[] = JHtml::_('select.option', $extension_type, JText::_($text));
			}
		}
		return $_filter;
	}
}
