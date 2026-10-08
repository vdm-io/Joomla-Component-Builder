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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\View\AjaxTokenInterface;


/**
 * View Ajax Token Class.
 * 
 * Builds the statement a view runs to put the form token where its ajax calls
 * can reach it. Only a view that was found to make ajax calls gets one.
 * 
 * How the statement reaches the page is what the compile target decides, and
 * it is the extension point below.
 * 
 * @since  6.1.7
 */
class AjaxToken implements AjaxTokenInterface
{
	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor.
	 *
	 * @param Dispenser  $dispenser  The Customcode Dispenser Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Dispenser $dispenser)
	{
		$this->dispenser = $dispenser;
	}

	/**
	 * Build the ajax token declaration a view makes.
	 *
	 * @param   string  $view  The view being built.
	 *
	 * @return  string  The statement, or nothing when the view makes no ajax calls.
	 *
	 * @since   6.1.7
	 */
	public function get(string &$view): string
	{
		$fix = '';
		if (isset($this->dispenser->hub['token'][$view])
			&& $this->dispenser->hub['token'][$view])
		{
			$fix .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Add Ajax Token";

			$fix .= $this->declaration();
		}

		return $fix;
	}

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
			. "\$this->getDocument()->getWebAssetManager()->addInlineScript(\"var token = '\" . Joomla__"."_5ba38513_5c4f_4b0d_935e_49e986a6bce8___Power::getFormToken() . \"';\");";
	}
}

