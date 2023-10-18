<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator;


/**
 * Field Creator Interface (needed for the container)
 * 
 * @since 3.2.0
 */
interface Fielddynamicinterface
{
	/**
	 * Get the Dynamic field and build all it needs
	 *
	 * @param   array    $field           The field data
	 * @param   array    $view            The view data
	 * @param   int      $viewType        The view type
	 * @param   string   $langView        The language string of the view
	 * @param   string   $nameSingleCode  The single view name
	 * @param   string   $nameListCode    The list view name
	 * @param   array    $placeholders    The place holder and replace values
	 * @param   string   $dbkey           The the custom table key
	 * @param   boolean  $build           The switch to set the build option
	 *
	 * @return  mixed   The complete field
	 * @since 3.2.0
	 */
	public function get(array &$field, array &$view, int &$viewType, string &$langView, string &$nameSingleCode,
		string &$nameListCode, array &$placeholders, string &$dbkey, bool $build);
}

