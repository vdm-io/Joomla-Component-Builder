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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Ajax Methods Class.
 * 
 * The ajax model of a target carries the methods every view of that target was
 * given to answer with, each one saying which view asked for it.
 * 
 * @since 6.1.7
 */
final class AjaxMethods
{
	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

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
	 * @param Dispenser   $dispenser   The Customcode Dispenser Class.
	 * @param Placeholder $placeholder The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Dispenser $dispenser,
		Placeholder $placeholder)
	{
		$this->dispenser = $dispenser;
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the ajax methods of one target's model.
	 *
	 * A target no view was given ajax for gets none.
	 *
	 * @param   string  $target  The target being built.
	 *
	 * @return  string  The methods.
	 *
	 * @since   6.1.7
	 */
	public function get($target): string
	{
		$methods = '';
		if (isset($this->dispenser->hub[$target]['ajax_model'])
			&& ArrayHelper::check(
				$this->dispenser->hub[$target]['ajax_model']
			))
		{
			foreach (
				$this->dispenser->hub[$target]['ajax_model'] as $view =>
				$method
			)
			{
				$methods .= PHP_EOL . PHP_EOL . Indent::_(1) . "//"
					. Line::_(__LINE__, __CLASS__) . " Used in " . $view . PHP_EOL;
				$methods .= $this->placeholder->update_(
					$method
				);
			}
		}

		return $methods;
	}
}

