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

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Targetfields Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class TargetfieldsField extends ListField
{
	/**
	 * The targetfields field type.
	 *
	 * @var        string
	 */
	public $type = 'Targetfields';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// load the db opbject
		$db = Factory::getDBO();		
		// get the input from url
		$jinput = Factory::getApplication()->input;
		// get the id
		$ID = $jinput->getInt('id', 0);
		// rest the fields guids
		$fieldGuids = [];

		// if this is an actual admin view then we are done
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the admin view GUID
			$adminView = GetHelper::var('admin_fields_conditions', (int) $ID, 'id', 'admin_view');
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

		if (GuidHelper::valid($adminView))
		{
			// get all the fields linked to the admin view
			if ($addFields = GetHelper::var('admin_fields',  $adminView, 'admin_view', 'addfields'))
			{
				if (JsonHelper::check($addFields))
				{
					$addFields = json_decode($addFields, true);
					if (ArrayHelper::check($addFields))
					{
						foreach($addFields as $addField)
						{
							if (isset($addField['field']))
							{
								$fieldGuids[] = (string) $addField['field'];
							}
						}
					}
				}
			}
		}
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.guid','a.name','t.name'),array('guid','name','type')));
		$query->from($db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 't') . ' ON (' . $db->quoteName('a.fieldtype') . ' = ' . $db->quoteName('t.guid') . ')');
		$query->where($db->quoteName('a.published') . ' >= 1');
		// filter by fields linked
		if (ArrayHelper::check($fieldGuids))
		{
			// only load these fields
			$query->where($db->quoteName('a.guid') . ' IN ("' . implode('","', $fieldGuids) . '")');
		}
		$query->order('a.name ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			foreach($items as $item)
			{
				$options[] = Html::_('select.option', $item->guid, $item->name . ' [' . $item->type . ']');
			}
		}
		
		return $options;
	}
}
