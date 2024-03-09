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
 * Fields Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class FieldsField extends ListField
{
	/**
	 * The fields field type.
	 *
	 * @var        string
	 */
	public $type = 'Fields';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		$db = Factory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id', 'a.name', 'a.xml', 'b.name'), array('id', 'field_name', 'xml', 'type')));
		$query->from($db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', '#__componentbuilder_fieldtype AS b ON b.id = a.fieldtype');
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.name ASC');
		$db->setQuery((string) $query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = Html::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				// get the field name (TODO this could slow down the system so we will need to improve on this)
				if (isset($item->xml) && ComponentbuilderHelper::checkJson($item->xml))
				{
					$field_xml = json_decode($item->xml);
					$field_name = ComponentbuilderHelper::getBetween($field_xml,'name="','"');
					$field_name = ComponentbuilderHelper::safeFieldName($field_name);
					$options[] = Html::_('select.option', $item->id, $item->field_name . ' [ ' . $field_name . ' - ' . $item->type . ' ]');
				}
				else
				{
					$options[] = Html::_('select.option', $item->id, $item->field_name . ' [ empty - ' . $item->type . ' ]');
				}
			}
		}

		return $options;
	}
}
