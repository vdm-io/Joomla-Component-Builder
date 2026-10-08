<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Controller\AjaxCases as SharedAjaxCases;


/**
 * Joomla 3 Controller Ajax Cases Class.
 * 
 * A Joomla 3 controller reaches its models without naming the side they belong
 * to, and answers a task it cannot run with false.
 * 
 * @since  6.1.7
 */
final class AjaxCases extends SharedAjaxCases
{
	/**
	 * What a task that cannot run answers with.
	 *
	 * @return  string  The expression.
	 *
	 * @since   6.1.7
	 */
	protected function failed(): string
	{
		return "false";
	}

	/**
	 * The statement that asks for the ajax model.
	 *
	 * @param   string  $prefix  The side of the component the model belongs to.
	 *
	 * @return  string  The statement.
	 *
	 * @since   6.1.7
	 */
	protected function ajaxModel(string $prefix): string
	{
		return "\$ajaxModule = \$this->getModel('ajax');";
	}
}

