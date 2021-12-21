<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
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
 * Classpropertiesfiltervisibility Form Field class for the Componentbuilder component
 */
class JFormFieldClasspropertiesfiltervisibility extends JFormFieldList
{
	/**
	 * The classpropertiesfiltervisibility field type.
	 *
	 * @var		string
	 */
	public $type = 'classpropertiesfiltervisibility';

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
		$query->from($db->quoteName('#__componentbuilder_class_property'));
		$query->order($db->quoteName('visibility') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_COMPONENTBUILDER_FILTER_SELECT_VISIBILITY') . ' -');

		if ($results)
		{
			// get class_propertiesmodel
			$model = ComponentbuilderHelper::getModel('class_properties');
			$results = array_unique($results);
			foreach ($results as $visibility)
			{
				// Translate the visibility selection
				$text = $model->selectionTranslation($visibility,'visibility');
				// Now add the visibility and its text to the options array
				$_filter[] = JHtml::_('select.option', $visibility, JText::_($text));
			}
		}
		return $_filter;
	}
}
