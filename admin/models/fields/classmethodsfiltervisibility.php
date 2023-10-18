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

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Classmethodsfiltervisibility Form Field class for the Componentbuilder component
 */
class JFormFieldClassmethodsfiltervisibility extends JFormFieldList
{
	/**
	 * The classmethodsfiltervisibility field type.
	 *
	 * @var		string
	 */
	public $type = 'classmethodsfiltervisibility';

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
		$query->select($db->quoteName('visibility'));
		$query->from($db->quoteName('#__componentbuilder_class_method'));
		$query->order($db->quoteName('visibility') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$_results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_VISIBILITY') . ' -');

		if ($_results)
		{
			// get class_methodsmodel
			$_model = ComponentbuilderHelper::getModel('class_methods');
			$_results = array_unique($_results);
			foreach ($_results as $visibility)
			{
				// Translate the visibility selection
				$_text = $_model->selectionTranslation($visibility,'visibility');
				// Now add the visibility and its text to the options array
				$_filter[] = JHtml::_('select.option', $visibility, JText::_($_text));
			}
		}
		return $_filter;
	}
}
