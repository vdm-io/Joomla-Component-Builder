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
 * Articles Form Field class for the Componentbuilder component
 */
class JFormFieldArticles extends JFormFieldList
{
	/**
	 * The articles field type.
	 *
	 * @var		string
	 */
	public $type = 'articles';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.title','a.alias'),array('id','article_title','alias')));
		$query->from($db->quoteName('#__content', 'a'));
		$query->where($db->quoteName('a.state') . ' = 1');
		$query->order('a.title ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = JHtml::_('select.option', '', 'Select an Article');
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->id, $item->article_title . ' (' . $item->alias . ')');
			}
		}
		return $options;
	}
}
