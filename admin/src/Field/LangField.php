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
 * Lang Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class LangField extends ListField
{
	/**
	 * The lang field type.
	 *
	 * @var        string
	 */
	public $type = 'Lang';

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
		$query->select($db->quoteName(array('a.langtag','a.name'),array('langtag','language_name')));
		$query->from($db->quoteName('#__componentbuilder_language', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.langtag ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		// add the main language
		$main_lang = trim(ComponentHelper::getParams('com_componentbuilder')->get('language', 'en-GB'));
		// make sure the main language is added
		$wasAdded = false;
		$options = array();
		if ($items)
		{
			$options[] = Html::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				$item->langtag = trim($item->langtag);
				$options[] = Html::_('select.option', $item->langtag, $item->language_name . ' (' .$item->langtag.')');
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
				$options[] = Html::_('select.option', $main_lang, 'English GB (' . $main_lang . ')');
			}
			else
			{
				$options[] = Html::_('select.option', $main_lang, 'Main Language (' . $main_lang . ')');
			}
		}
		return $options;
	}
}
