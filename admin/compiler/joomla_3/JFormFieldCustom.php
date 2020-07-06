<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the ###JFORM_extends### field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('###JFORM_extends###');

/**
 * ###Type### Form Field class for the ###Component### component
 */
class ###JPREFIX###FormField###Type### extends JFormField###JFORM_EXTENDS###
{
	/**
	 * The ###type### field type.
	 *
	 * @var		string
	 */
	public $type = '###type###';###JFORM_TYPE_PHP###
}
