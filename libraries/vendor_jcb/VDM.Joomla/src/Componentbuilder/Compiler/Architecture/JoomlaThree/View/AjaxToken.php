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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\View;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\AjaxToken as SharedAjaxToken;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Joomla 3 View Ajax Token Class.
 * 
 * A Joomla 3 view declares the token straight on the document, there being no
 * web asset manager to hand it to.
 * 
 * @since  6.1.7
 */
final class AjaxToken extends SharedAjaxToken
{
	/**
	 * The statement that puts the token on the page.
	 *
	 * @return  string  The statement.
	 *
	 * @since   6.1.7
	 */
	protected function declaration(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$this->getDocument()->addScriptDeclaration(\"var token = '\" . Joomla__"."_5ba38513_5c4f_4b0d_935e_49e986a6bce8___Power::getFormToken() . \"';\");";
	}
}

