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
 * Adminviews Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class AdminviewsField extends ListField
{
	/**
	 * The adminviews field type.
	 *
	 * @var        string
	 */
	public $type = 'Adminviews';

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
$query->select($db->quoteName(array('a.id','a.system_name'),array('id','adminview_system_name')));
$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
$query->where($db->quoteName('a.published') . ' >= 1');
$query->order('a.system_name ASC');
$db->setQuery((string)$query);
$items = $db->loadObjectList();
$options = array();
if ($items)
{
	$options[] = Html::_('select.option', '', 'Select an option');
	foreach($items as $item)
	{
		$options[] = Html::_('select.option', $item->id, $item->adminview_system_name);
	}
}

return $options;
	}
}
