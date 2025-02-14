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
 * Componentadminviews Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class ComponentadminviewsField extends ListField
{
	/**
	 * The componentadminviews field type.
	 *
	 * @var        string
	 */
	public $type = 'Componentadminviews';

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

		// rest the fields guid's
		$viewGuids = array();
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the joomla component ID
			$joomlacomponent = GetHelper::var('component_mysql_tweaks', (int) $ID, 'id', 'joomla_component');
		}
		else
		{
			// get the admin view GUID
			$initDefaults = $jinput->get('init_defaults', null, 'STRING');
			if (!empty($initDefaults))
			{
				$initDefaults = json_decode(urldecode($initDefaults), true);
				$joomlacomponent = $initDefaults['joomla_component'] ?? null;
			}
		}

		// make sure we have the joomla component GUID
		if (GuidHelper::valid($joomlacomponent))
		{
			// get all the admin views linked to the joomla component
			if ($addAdminViews = GetHelper::var('component_admin_views', $joomlacomponent, 'joomla_component', 'addadmin_views'))
			{
				if (JsonHelper::check($addAdminViews))
				{
					$addAdminViews = json_decode($addAdminViews, true);
					if (ArrayHelper::check($addAdminViews))
					{
						foreach($addAdminViews as $addAdminView)
						{
							if (isset($addAdminView['adminview']))
							{
								$viewGuids[] = (string) $addAdminView['adminview'];
							}
						}
					}
				}
			}
		}

		$query = $db->getQuery(true);
		$query->select($db->quoteName(['a.guid','a.system_name'], ['guid','name']));
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		// filter by fields linked
		if (ArrayHelper::check($viewGuids))
		{
			// only load these fields
			$query->where($db->quoteName('a.guid') . ' IN ("' . implode('","', $viewGuids) . '")');
		}
		$query->order('a.system_name ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = Html::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				$options[] = Html::_('select.option', $item->guid, $item->name);
			}
		}

		return $options;
	}
}
