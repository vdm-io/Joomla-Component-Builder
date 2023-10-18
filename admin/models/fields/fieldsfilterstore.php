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
 * Fieldsfilterstore Form Field class for the Componentbuilder component
 */
class JFormFieldFieldsfilterstore extends JFormFieldList
{
	/**
	 * The fieldsfilterstore field type.
	 *
	 * @var		string
	 */
	public $type = 'fieldsfilterstore';

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
		$query->select($db->quoteName('store'));
		$query->from($db->quoteName('#__componentbuilder_field'));
		$query->order($db->quoteName('store') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$_results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_MODELLING_METHOD') . ' -');

		if ($_results)
		{
			// get fieldsmodel
			$_model = ComponentbuilderHelper::getModel('fields');
			$_results = array_unique($_results);
			foreach ($_results as $store)
			{
				// Translate the store selection
				$_text = $_model->selectionTranslation($store,'store');
				// Now add the store and its text to the options array
				$_filter[] = JHtml::_('select.option', $store, JText::_($_text));
			}
		}
		return $_filter;
	}
}
