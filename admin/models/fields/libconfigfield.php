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
 * Libconfigfield Form Field class for the Componentbuilder component
 */
class JFormFieldLibconfigfield extends JFormFieldList
{
	/**
	 * The libconfigfield field type.
	 *
	 * @var		string
	 */
	public $type = 'libconfigfield';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// load the db opbject
		$db = JFactory::getDBO();		
		// get the input from url
		$jinput = JFactory::getApplication()->input;
		// get the id
		$ID = $jinput->getInt('id', 0);
		// rest the fields ids
		$fieldIds = array();
		if (is_numeric($ID) && $ID >= 1)
		{
			// get all the fields linked to the library config
			if ($addconfig = ComponentbuilderHelper::getVar('library_config', (int) $ID, 'library', 'addconfig'))
			{
				if (ComponentbuilderHelper::checkJson($addconfig))
				{
					$addconfig = json_decode($addconfig, true);
					if (ComponentbuilderHelper::checkArray($addconfig))
					{
						foreach($addconfig as $field)
						{
							if (isset($field['field']))
							{
								$fieldIds[] = (int) $field['field'];
							}
						}
					}
				}
			}
		}
		// check if we have ids, since we should not show any fields that are not part of this config
		if (ComponentbuilderHelper::checkArray($fieldIds))
		{
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('a.id','a.name'),array('id','name')));
			$query->from($db->quoteName('#__componentbuilder_field', 'a'));
			$query->where($db->quoteName('a.published') . ' >= 1');
			// only load these fields
			$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $fieldIds) . ')');
			$query->order('a.name ASC');
			$db->setQuery((string)$query);
			$items = $db->loadObjectList();
			$options = array();
			if ($items)
			{
				$options[] = JHtml::_('select.option', '', 'Select an option');
				foreach($items as $item)
				{
					$options[] = JHtml::_('select.option', $item->id, $item->name);
				}
				return $options;
			}
		}
		return array(JHtml::_('select.option', '', 'No config fields linked'));
	}
}
