<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
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
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// get the input from url
		$jinput = JFactory::getApplication()->input;
		// get the view name & id
		$fieldsID = $jinput->getInt('id', 0);
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.addtabs'),array('id','addtabs')));
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
		if ($fieldsID > 0)
		{
			$viewName = $jinput->get('view', null, 'WORD');
			// only allow for fields and custom tabs
			if ('admin_fields' !== $viewName && 'admin_custom_tabs' !== $viewName)
			{
				return false;
			}
			$query->join('LEFT', $db->quoteName('#__componentbuilder_' . $viewName, 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.admin_view') . ')');
			$query->where($db->quoteName('b.id') . '  = ' . (int) $fieldsID);
		}
		else
		{
			// get the refs if found
			$ref = $jinput->get('ref', null, 'WORD');
			$refid = $jinput->getInt('refid', 0);
			if ('admin_view' === $ref && $refid > 0)
			{
				$query->where($db->quoteName('a.id') . ' = ' . (int) $refid);
			}
			else
			{
				// kry maar niks
				$query->where($db->quoteName('a.id') . ' = 0');
			}
		}
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.addtabs ASC');
		$db->setQuery((string)$query);
		$item = $db->loadObject();
		$options = array();
		if (isset($item->addtabs) && ComponentbuilderHelper::checkJson($item->addtabs))
		{
			$items = json_decode($item->addtabs, true);
			// check if the array has values
			if (ComponentbuilderHelper::checkArray($items))
			{
				$nr = 1;
				foreach($items as $itemName)
				{
					$options[] = JHtml::_('select.option', $nr, $itemName['name']);
					$nr++;
				}
			}
		}
		// check if any were loaded
		if (!ComponentbuilderHelper::checkArray($options))
		{
			$options[] = JHtml::_('select.option', 1, JText::_('COM_COMPONENTBUILDER_DETAILS'));
		}
		// add the default publish tab as an option
		$options[] = JHtml::_('select.option', 15, JText::_('COM_COMPONENTBUILDER_PUBLISHING'));
		return $options;
	}
}
