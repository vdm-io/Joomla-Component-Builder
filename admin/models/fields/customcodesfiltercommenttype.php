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
 * Customcodesfiltercommenttype Form Field class for the Componentbuilder component
 */
class JFormFieldCustomcodesfiltercommenttype extends JFormFieldList
{
	/**
	 * The customcodesfiltercommenttype field type.
	 *
	 * @var		string
	 */
	public $type = 'customcodesfiltercommenttype';

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
		$query->select($db->quoteName('comment_type'));
		$query->from($db->quoteName('#__componentbuilder_custom_code'));
		$query->order($db->quoteName('comment_type') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_COMMENT_TYPE_USED_IN_PLACEHOLDER') . ' -');

		if ($results)
		{
			// get custom_codesmodel
			$model = ComponentbuilderHelper::getModel('custom_codes');
			$results = array_unique($results);
			foreach ($results as $comment_type)
			{
				// Translate the comment_type selection
				$text = $model->selectionTranslation($comment_type,'comment_type');
				// Now add the comment_type and its text to the options array
				$_filter[] = JHtml::_('select.option', $comment_type, JText::_($text));
			}
		}
		return $_filter;
	}
}
