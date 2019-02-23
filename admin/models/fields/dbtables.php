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
 * Dbtables Form Field class for the Componentbuilder component
 */
class JFormFieldDbtables extends JFormFieldList
{
	/**
	 * The dbtables field type.
	 *
	 * @var		string
	 */
	public $type = 'dbtables';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// get db object
		$db = JFactory::getDBO();
		// get all tables
		$tables= $db->getTableList();
		// get config
		$config = JFactory::getConfig();
		$dbprefix = version_compare(JVERSION,'3.0','lt') ? $config->getValue('config.dbprefix') : $config->get('dbprefix');
		$options = array();
		$options[] = JHtml::_('select.option', '', 'Select an option');
		for ($i=0; $i < count($tables); $i++)
		{
			//only tables with primary key
			$db->setQuery('SHOW FIELDS FROM `'.$tables[$i].'` WHERE LOWER( `Key` ) = \'pri\'');
			if ($db->loadResult())
			{
				$key = $i+1;
				$options[$key] = new stdClass;
				$options[$key]->value = str_replace($dbprefix, '', $tables[$i]);
				$options[$key]->text = $tables[$i];
			}
		}
		return $options;
	}
}
