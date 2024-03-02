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
 * Customadminviewsfilteraddphpajax Form Field class for the Componentbuilder component
 */
class JFormFieldCustomadminviewsfilteraddphpajax extends JFormFieldList
{
	/**
	 * The customadminviewsfilteraddphpajax field type.
	 *
	 * @var        string
	 */
	public $type = 'customadminviewsfilteraddphpajax';

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
		$query->select($db->quoteName('add_php_ajax'));
		$query->from($db->quoteName('#__componentbuilder_custom_admin_view'));
		$query->order($db->quoteName('add_php_ajax') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$_results = $db->loadColumn();
		$_filter = [];
		$_filter[] = Html::_('select.option', '', '- ' . Text::_('COM_COMPONENTBUILDER_FILTER_SELECT_ADD_PHP_AJAX') . ' -');

		if ($_results)
		{
			// get custom_admin_viewsmodel
			$_model = ComponentbuilderHelper::getModel('custom_admin_views');
			$_results = array_unique($_results);
			foreach ($_results as $add_php_ajax)
			{
				// Translate the add_php_ajax selection
				$_text = $_model->selectionTranslation($add_php_ajax,'add_php_ajax');
				// Now add the add_php_ajax and its text to the options array
				$_filter[] = Html::_('select.option', $add_php_ajax, Text::_($_text));
			}
		}
		return $_filter;
	}
}
