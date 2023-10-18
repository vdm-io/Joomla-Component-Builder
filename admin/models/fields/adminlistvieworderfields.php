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
 * Adminlistvieworderfields Form Field class for the Componentbuilder component
 */
class JFormFieldAdminlistvieworderfields extends JFormFieldList
{
	/**
	 * The adminlistvieworderfields field type.
	 *
	 * @var		string
	 */
	public $type = 'adminlistvieworderfields';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// load the db object
		$db = JFactory::getDBO();		
		// get the input from url
		$jinput = JFactory::getApplication()->input;
		// get the id
		$adminView = $jinput->getInt('id', 0);
		// set the field trackers
		$fieldIds = array();
		$sortIds = array();
		// check if we have an admin view
		if (is_numeric($adminView) && $adminView >= 1)
		{
			// get all the fields linked to the admin view
			if ($addFields = ComponentbuilderHelper::getVar('admin_fields', (int) $adminView, 'admin_view', 'addfields'))
			{
				if (ComponentbuilderHelper::checkJson($addFields))
				{
					$addFields = json_decode($addFields, true);
					if (ComponentbuilderHelper::checkArray($addFields))
					{
						foreach($addFields as $addField)
						{
							// admin list view and ordering
							if (isset($addField['field']) && isset($addField['list']) && ($addField['list'] == 1 || $addField['list'] == 3)
								&& isset($addField['sort']) && $addField['sort'])
							{
								$fieldIds[(int) $addField['field']] = (int) $addField['field'];
							}
							// do track all fields set as sorted
							if (isset($addField['field']) && isset($addField['sort']) && $addField['sort'])
							{
								$sortIds[(int) $addField['field']] = (int) $addField['field'];
							}
						}
					}
				}
			}
			// get all the fields that are also having a relationship on the list view as sorted
			if ($addFields = ComponentbuilderHelper::getVar('admin_fields_relations', (int) $adminView, 'admin_view', 'addrelations'))
			{
				if (ComponentbuilderHelper::checkJson($addFields))
				{
					$addFields = json_decode($addFields, true);
					if (ComponentbuilderHelper::checkArray($addFields))
					{
						foreach($addFields as $addField)
						{
							// admin list view and ordering
							if (isset($addField['joinfields']) && ComponentbuilderHelper::checkArray($addField['joinfields']))
							{
								foreach($addField['joinfields'] as $joinfield)
								{
									if (isset($sortIds[$joinfield]))
									{
										$fieldIds[(int) $joinfield] = (int) $joinfield;
									}
								}
							}
						}
					}
				}
			}
			// filter by fields linked
			if (ComponentbuilderHelper::checkArray($fieldIds))
			{
				$query = $db->getQuery(true);
				$query->select($db->quoteName(array('a.id','a.name', 'a.xml', 'b.name'),array('id','name', 'xml', 'type')));
				$query->from($db->quoteName('#__componentbuilder_field', 'a'));
				$query->join('LEFT', '#__componentbuilder_fieldtype AS b ON b.id = a.fieldtype');
				$query->where($db->quoteName('a.published') . ' >= 1');
				// only load these fields
				$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $fieldIds) . ')');
				$query->order('a.name ASC');
				$db->setQuery((string)$query);
				$items = $db->loadObjectList();
				$options = array();
				if ($items)
				{
					$options[] = JHtml::_('select.option', '', JText::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_SELECT_AN_OPTION'));
					$options[] = JHtml::_('select.option', -1, JText::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_ID'). ' [ id - text ]');
					$options[] = JHtml::_('select.option', -2, JText::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_ORDERING'). ' [ ordering - number ]');
					$options[] = JHtml::_('select.option', -3, JText::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_STATUS'). ' [ published - list ]');
					foreach($items as $item)
					{
						// get the field name (TODO this could slow down the system so we will need to improve on this)
						if (isset($item->xml) && ComponentbuilderHelper::checkJson($item->xml))
						{
							$field_xml = json_decode($item->xml);
							$field_name = ComponentbuilderHelper::getBetween($field_xml,'name="','"');
							$field_name = ComponentbuilderHelper::safeFieldName($field_name);
							$options[] = JHtml::_('select.option', $item->id, $item->name . ' [ ' . $field_name . ' - ' . $item->type . ' ]');
						}
						else
						{
							$options[] = JHtml::_('select.option', $item->id, $item->name . ' [ empty - ' . $item->type . ' ]');
						}
					}
				}
				return $options;
			}
		}
		return false;
	}
}
