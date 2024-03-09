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

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Libconfigfield Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class LibconfigfieldField extends ListField
{
	/**
	 * The libconfigfield field type.
	 *
	 * @var        string
	 */
	public $type = 'Libconfigfield';

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
				$options[] = Html::_('select.option', '', 'Select an option');
				foreach($items as $item)
				{
					$options[] = Html::_('select.option', $item->id, $item->name);
				}
				return $options;
			}
		}
		return array(Html::_('select.option', '', 'No config fields linked'));
	}
}
