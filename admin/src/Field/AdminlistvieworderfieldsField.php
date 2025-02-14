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
namespace VDM\Component\Componentbuilder\Administrator\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\String\FieldHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Adminlistvieworderfields Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class AdminlistvieworderfieldsField extends ListField
{
	/**
	 * The adminlistvieworderfields field type.
	 *
	 * @var        string
	 */
	public $type = 'Adminlistvieworderfields';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// load the db object
		$db = Factory::getDBO();		
		// get the input from url
		$jinput = Factory::getApplication()->input;
		// get the id
		$ID = $jinput->getInt('id', 0);
		$adminView = null;
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the admin view GUID
			$adminView = GetHelper::var('admin_view', (int) $ID, 'id', 'guid');
		}
		else
		{
			// get the admin view GUID
			$initDefaults = $jinput->get('init_defaults', null, 'STRING');
			if (!empty($initDefaults))
			{
				$initDefaults = json_decode(urldecode($initDefaults), true);
				$adminView = $initDefaults['admin_view'] ?? null;
			}
		}
		// set the field trackers
		$fieldGuids = [];
		$sortGuids = [];
		// check if we have an admin view
		if (GuidHelper::valid($adminView))
		{
			// get all the fields linked to the admin view
			if ($addFields = GetHelper::var('admin_fields', $adminView, 'admin_view', 'addfields'))
			{
				if (JsonHelper::check($addFields))
				{
					$addFields = json_decode($addFields, true);
					if (ArrayHelper::check($addFields))
					{
						foreach($addFields as $addField)
						{
							// admin list view and ordering
							if (isset($addField['field']) && isset($addField['list']) && ($addField['list'] == 1 || $addField['list'] == 3)
								&& isset($addField['sort']) && $addField['sort'])
							{
								$fieldGuids[$addField['field']] = $addField['field'];
							}
							// do track all fields set as sorted
							if (isset($addField['field']) && isset($addField['sort']) && $addField['sort'])
							{
								$sortGuids[$addField['field']] = $addField['field'];
							}
						}
					}
				}
			}
			// get all the fields that are also having a relationship on the list view as sorted
			if ($addRelations = GetHelper::var('admin_fields_relations',  $adminView, 'admin_view', 'addrelations'))
			{
				if (JsonHelper::check($addRelations))
				{
					$addRelations = json_decode($addRelations, true);
					if (ArrayHelper::check($addRelations))
					{
						foreach($addRelations as $relation)
						{
							// admin list view and ordering
							if (isset($relation['joinfields']) && ArrayHelper::check($relation['joinfields']))
							{
								foreach($relation['joinfields'] as $joinfield)
								{
									if (isset($sortGuids[$joinfield]))
									{
										$fieldGuids[$joinfield] = $joinfield;
									}
								}
							}
						}
					}
				}
			}
			// filter by fields linked
			if (ArrayHelper::check($fieldGuids))
			{
				$query = $db->getQuery(true);
				$query->select($db->quoteName(array('a.guid','a.name', 'a.xml', 'b.name'),array('guid','name', 'xml', 'type')));
				$query->from($db->quoteName('#__componentbuilder_field', 'a'));
				$query->join('LEFT', '#__componentbuilder_fieldtype AS b ON b.guid = a.fieldtype');
				$query->where($db->quoteName('a.published') . ' >= 1');
				// only load these fields
				$query->where($db->quoteName('a.guid') . ' IN ("' . implode('","', $fieldGuids) . '")');
				$query->order('a.name ASC');
				$db->setQuery((string)$query);
				$items = $db->loadObjectList();
				$options = [];
				if ($items)
				{
					$options[] = Html::_('select.option', '', Text::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_SELECT_AN_OPTION'));
					$options[] = Html::_('select.option', -1, Text::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_ID'). ' [ id - text ]');
					$options[] = Html::_('select.option', -2, Text::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_ORDERING'). ' [ ordering - number ]');
					$options[] = Html::_('select.option', -3, Text::_('PLG_CONTENT_COMPONENTBUILDERFIELDORDERINGTABS_STATUS'). ' [ published - list ]');
					foreach($items as $item)
					{
						// get the field name (TODO this could slow down the system so we will need to improve on this)
						if (isset($item->xml) && JsonHelper::check($item->xml))
						{
							$field_xml = json_decode($item->xml);
							$field_name = GetHelper::between($field_xml,'name="','"');
							$field_name = FieldHelper::safe($field_name);
							$options[] = Html::_('select.option', $item->guid, $item->name . ' [ ' . $field_name . ' - ' . $item->type . ' ]');
						}
						else
						{
							$options[] = Html::_('select.option', $item->guid, $item->name . ' [ empty - ' . $item->type . ' ]');
						}
					}
				}
				return $options;
			}
		}
		return false;
	}
}
