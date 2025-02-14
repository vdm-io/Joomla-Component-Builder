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
 * Viewtabs Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class ViewtabsField extends ListField
{
	/**
	 * The viewtabs field type.
	 *
	 * @var        string
	 */
	public $type = 'Viewtabs';

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
		$adminView = null;
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the view name
			$viewName = $jinput->get('view', null, 'WORD');
			// get the admin view GUID
			$adminView = GetHelper::var($viewName, (int) $ID, 'id', 'admin_view');
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
		$db = Factory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(['a.addtabs'],['addtabs']));
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
		if (GuidHelper::valid($adminView))
		{
			$query->where($db->quoteName('a.guid') . ' = ' . $db->quote($adminView));
		}
		else
		{
			// kry maar niks
			$query->where($db->quoteName('a.id') . ' = 0');
		}
		$query->where($db->quoteName('a.published') . ' >= 1');
		$db->setQuery((string)$query);
		$item = $db->loadObject();
		$options = [];
		if (isset($item->addtabs) && JsonHelper::check($item->addtabs))
		{
			$items = json_decode($item->addtabs, true);
			// check if the array has values
			if (ArrayHelper::check($items))
			{
				$nr = 1;
				foreach($items as $itemName)
				{
					$options[] = Html::_('select.option', $nr, $itemName['name']);
					$nr++;
				}
			}
		}
		// check if any were loaded
		if (!ArrayHelper::check($options))
		{
			$options[] = Html::_('select.option', 1, Text::_('COM_COMPONENTBUILDER_DETAILS'));
		}
		// add the default publish tab as an option
		$options[] = Html::_('select.option', 15, Text::_('COM_COMPONENTBUILDER_PUBLISHING'));
		return $options;
	}
}
