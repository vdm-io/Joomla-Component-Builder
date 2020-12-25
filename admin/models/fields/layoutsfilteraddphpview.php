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
 * Layoutsfilteraddphpview Form Field class for the Componentbuilder component
 */
class JFormFieldLayoutsfilteraddphpview extends JFormFieldList
{
	/**
	 * The layoutsfilteraddphpview field type.
	 *
	 * @var		string
	 */
	public $type = 'layoutsfilteraddphpview';

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
		$query->select($db->quoteName('add_php_view'));
		$query->from($db->quoteName('#__componentbuilder_layout'));
		$query->order($db->quoteName('add_php_view') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_ADD_PHP_VIEW') . ' -');

		if ($results)
		{
			// get layoutsmodel
			$model = ComponentbuilderHelper::getModel('layouts');
			$results = array_unique($results);
			foreach ($results as $add_php_view)
			{
				// Translate the add_php_view selection
				$text = $model->selectionTranslation($add_php_view,'add_php_view');
				// Now add the add_php_view and its text to the options array
				$_filter[] = JHtml::_('select.option', $add_php_view, JText::_($text));
			}
		}
		return $_filter;
	}
}
