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


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * View Document Custom PHP Class.
 * 
 * Gives back the php a view was built to run when its document is prepared,
 * laid out at the indent the generated method expects and with its
 * placeholders filled in.
 * 
 * @since  6.1.7
 */
final class DocumentCustomPHP
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the custom php a view runs when it prepares its document.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The php, or nothing when the view declared none.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string
	{
		if ($view['settings']->add_php_document == 1)
		{
			$view['settings']->php_document = (array) explode(
				PHP_EOL, (string) $view['settings']->php_document
			);
			if (ArrayHelper::check(
				$view['settings']->php_document
			))
			{
				$_tmp = PHP_EOL . Indent::_(2) . implode(
					PHP_EOL . Indent::_(2), $view['settings']->php_document
				);

				return $this->placeholder->update_($_tmp);
			}
		}

		return '';
	}
}

