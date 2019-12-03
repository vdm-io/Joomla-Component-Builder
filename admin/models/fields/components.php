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
 * Components Form Field class for the Componentbuilder component
 */
class JFormFieldComponents extends JFormFieldList
{
	/**
	 * The components field type.
	 *
	 * @var		string
	 */
	public $type = 'components';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
				$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.system_name'),array('id','components_system_name')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.system_name ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->id, $item->components_system_name);
			}
		}

		return $options;
	}
}
