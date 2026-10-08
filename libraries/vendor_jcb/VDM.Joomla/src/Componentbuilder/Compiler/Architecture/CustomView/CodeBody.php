<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    20th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Custom View Code Body Class.
 * 
 * A custom view the component was given php of its own carries that php, with
 * whatever placeholders it was written with filled in.
 * 
 * @since 6.1.7
 */
final class CodeBody
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
	 * @param Placeholder $placeholder The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the php a custom view was drawn with.
	 *
	 * A view that was given none, or given only blank lines, gets nothing.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The php.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		if ($view['settings']->add_php_view == 1)
		{
			$view['settings']->php_view = (array) explode(
				PHP_EOL, (string) $view['settings']->php_view
			);
			if (ArrayHelper::check($view['settings']->php_view))
			{
				$_tmp = PHP_EOL . PHP_EOL . implode(
						PHP_EOL, $view['settings']->php_view
					);

				return $this->placeholder->update_($_tmp);
			}
		}

		return '';
	}
}

