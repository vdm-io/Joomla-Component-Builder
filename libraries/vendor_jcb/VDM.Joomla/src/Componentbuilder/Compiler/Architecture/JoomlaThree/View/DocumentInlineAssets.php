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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\DocumentInlineAssets as SharedDocumentInlineAssets;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Joomla 3 View Document Inline Assets Class.
 * 
 * A Joomla 3 view declares its stylesheet and its script on the document
 * itself, there being no web asset manager to hand them to.
 * 
 * @since  6.1.7
 */
final class DocumentInlineAssets extends SharedDocumentInlineAssets
{
	/**
	 * The statement a view opens its inline stylesheet with.
	 *
	 * @return  string  The comment and the opening call.
	 *
	 * @since   6.1.7
	 */
	protected function styleOpening(): string
	{
		return PHP_EOL . Indent::_(2) . "//" . Line::_(
			__LINE__,__CLASS__
			) . " Set the Custom CSS script to view" . PHP_EOL
			. Indent::_(2) . '$this->document->addStyleDeclaration("';
	}

	/**
	 * The statement a view opens its inline script with.
	 *
	 * @return  string  The comment and the opening call.
	 *
	 * @since   6.1.7
	 */
	protected function scriptOpening(): string
	{
		return PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Set the Custom JS script to view" . PHP_EOL
			. Indent::_(2) . '$this->getDocument()->addScriptDeclaration("';
	}
}

