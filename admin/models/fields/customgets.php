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
 * Customgets Form Field class for the Componentbuilder component
 */
class JFormFieldCustomgets extends JFormFieldList
{
	/**
	 * The customgets field type.
	 *
	 * @var		string
	 */
	public $type = 'customgets';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.name','a.gettype'),array('id','custom_get_name','type')));
		$query->from($db->quoteName('#__componentbuilder_dynamic_get', 'a'));
		$query->where($db->quoteName('a.published') . ' = 1');
		$query->where('( '.$db->quoteName('a.gettype') . ' = 3 OR ' . $db->quoteName('a.gettype') . ' = 4 )');
		$query->order('a.name ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$model = ComponentbuilderHelper::getModel('dynamic_gets');
			foreach($items as $item)
			{
				$type = $model->selectionTranslation($item->type,'gettype');
				$options[] = JHtml::_('select.option', $item->id, $item->custom_get_name . ' (' . JText::_($type) . ')' );
			}
		}
		return $options;
	}
}
