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
 * Powersfilterapproved Form Field class for the Componentbuilder component
 */
class JFormFieldPowersfilterapproved extends JFormFieldList
{
	/**
	 * The powersfilterapproved field type.
	 *
	 * @var        string
	 */
	public $type = 'powersfilterapproved';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return    array    An array of Html options.
	 */
	protected function getOptions()
	{
		// Get a db connection.
		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('approved'));
		$query->from($db->quoteName('#__componentbuilder_power'));
		$query->order($db->quoteName('approved') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$_results = $db->loadColumn();
		$_filter = [];
		$_filter[] = Html::_('select.option', '', '- ' . Text::_('COM_COMPONENTBUILDER_FILTER_SELECT_SUPER_POWER') . ' -');

		if ($_results)
		{
			// get powersmodel
			$_model = ComponentbuilderHelper::getModel('powers');
			$_results = array_unique($_results);
			foreach ($_results as $approved)
			{
				// Translate the approved selection
				$_text = $_model->selectionTranslation($approved,'approved');
				// Now add the approved and its text to the options array
				$_filter[] = Html::_('select.option', $approved, Text::_($_text));
			}
		}
		return $_filter;
	}
}
