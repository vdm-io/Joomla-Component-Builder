<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Viewtabs Form Field class for the Componentbuilder component
 */
class JFormFieldViewtabs extends JFormFieldList
{
	/**
	 * The viewtabs field type.
	 *
	 * @var		string
	 */
	public $type = 'viewtabs';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	public function getOptions()
	{
		// get the input from url
		$jinput = JFactory::getApplication()->input;
		// get the view name & id
		$fieldsID = $jinput->getInt('id', 0);
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.addtabs'),array('id','addtabs')));
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_admin_fields', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.admin_view') . ')');
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->where($db->quoteName('b.id') . '  = ' . (int) $fieldsID);
		$query->order('a.addtabs ASC');
		$db->setQuery((string)$query);
		$item = $db->loadObject();
		$options = array();
		if (isset($item->addtabs) && strlen($item->addtabs) > 5)
		{
			$items = json_decode($item->addtabs, true);
			$nr = 1;
			foreach($items as $itemName)
			{
				$options[] = JHtml::_('select.option', $nr, $itemName['name']);
				$nr++;
			}
		}
		else
		{
			$options[] = JHtml::_('select.option', 1, JText::_('COM_COMPONENTBUILDER_DETAILS'));
		}
		// add the default publish tab as an option
		$options[] = JHtml::_('select.option', 15, JText::_('COM_COMPONENTBUILDER_PUBLISHING'));
		return $options;
	}
}
