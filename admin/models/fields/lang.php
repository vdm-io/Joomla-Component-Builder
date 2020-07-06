<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2020 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Lang Form Field class for the Componentbuilder component
 */
class JFormFieldLang extends JFormFieldList
{
	/**
	 * The lang field type.
	 *
	 * @var		string
	 */
	public $type = 'lang';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.langtag','a.name'),array('langtag','language_name')));
		$query->from($db->quoteName('#__componentbuilder_language', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.langtag ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		// add the main language
		$main_lang = trim(JComponentHelper::getParams('com_componentbuilder')->get('language', 'en-GB'));
		// make sure the main language is added
		$wasAdded = false;
		$options = array();
		if ($items)
		{
			$options[] = JHtml::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				$item->langtag = trim($item->langtag);
				$options[] = JHtml::_('select.option', $item->langtag, $item->language_name . ' (' .$item->langtag.')');
				if ($main_lang === $item->langtag)
				{
					$wasAdded = true;
				}
			}
		}
		// now add it if not already added (it must default to $main_lang)
		if (!$wasAdded)
		{
			if ('en-GB' === $main_lang)
			{
				$options[] = JHtml::_('select.option', $main_lang, 'English GB (' . $main_lang . ')');
			}
			else
			{
				$options[] = JHtml::_('select.option', $main_lang, 'Main Language (' . $main_lang . ')');
			}
		}
		return $options;
	}
}
