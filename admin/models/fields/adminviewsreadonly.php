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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Adminviewsreadonly Form Field class for the Componentbuilder component
 */
class JFormFieldAdminviewsreadonly extends JFormFieldList
{
	/**
	 * The adminviewsreadonly field type.
	 *
	 * @var        string
	 */
	public $type = 'adminviewsreadonly';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return    array    An array of Html options.
	 */
	protected function getOptions()
	{
		$db = Factory::getDBO();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('a.id','a.system_name'),array('id','admin_view_system_name')));
$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
$query->order('a.system_name ASC');
$db->setQuery((string)$query);
$items = $db->loadObjectList();
$options = array();
if ($items)
{
	$options[] = Html::_('select.option', '', 'Select an option');
	foreach($items as $item)
	{
		$options[] = Html::_('select.option', $item->id, $item->admin_view_system_name);
	}
}

return $options;
	}
}
