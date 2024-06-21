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
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Form\Field\CheckboxesField;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Superpowerpaths Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class SuperpowerpathsField extends CheckboxesField
{
	/**
	 * The superpowerpaths field type.
	 *
	 * @var        string
	 */
	public $type = 'Superpowerpaths';

	// A DynamicCheckboxes@ Field
	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   3.7.0
	 */
	protected function getOptions()
	{
		// Get the databse object.
		$db = Factory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.repository', 'a.organisation')))
			->from($db->quoteName('#__componentbuilder_repository', 'a'))
			->where($db->quoteName('a.published') . ' >= 1')
			->where($db->quoteName('a.target') . ' = 1') // super powers
			->order($db->quoteName('a.ordering') . ' ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = [];
		if ($items)
		{
			if ($this->multiple === false)
			{
				$options[] = Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_SELECT_AN_OPTION'));
			}
			foreach($items as $item)
			{
				$path = $item->organisation . '/' . $item->repository;
				$options[] = Html::_('select.option', $path, $path);
			}
		}
		else
		{
			$options[] = Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_NO_ACTIVE_REPOSITORIES_FOUND'));
		}
		return $options;
	}
}
