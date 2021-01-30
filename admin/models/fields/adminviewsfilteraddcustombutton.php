<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Adminviewsfilteraddcustombutton Form Field class for the Componentbuilder component
 */
class JFormFieldAdminviewsfilteraddcustombutton extends JFormFieldList
{
	/**
	 * The adminviewsfilteraddcustombutton field type.
	 *
	 * @var		string
	 */
	public $type = 'adminviewsfilteraddcustombutton';

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
		$query->select($db->quoteName('add_custom_button'));
		$query->from($db->quoteName('#__componentbuilder_admin_view'));
		$query->order($db->quoteName('add_custom_button') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_ADD_CUSTOM_BUTTONS') . ' -');

		if ($results)
		{
			// get admin_viewsmodel
			$model = ComponentbuilderHelper::getModel('admin_views');
			$results = array_unique($results);
			foreach ($results as $add_custom_button)
			{
				// Translate the add_custom_button selection
				$text = $model->selectionTranslation($add_custom_button,'add_custom_button');
				// Now add the add_custom_button and its text to the options array
				$_filter[] = JHtml::_('select.option', $add_custom_button, JText::_($text));
			}
		}
		return $_filter;
	}
}
