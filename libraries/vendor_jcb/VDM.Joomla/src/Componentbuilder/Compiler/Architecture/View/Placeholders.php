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


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Utilities\StringHelper;


/**
 * View Placeholders Class.
 * 
 * Names one view to everything built for it: the single name, the list name,
 * and the three casings of each that the generated code is written with.
 * 
 * A view that has only one of the two names is named by that one alone, and
 * whatever is built for it never asks for the other.
 * 
 * @since 6.1.7
 */
final class Placeholders
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * Constructor.
	 *
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 * @param ContentMulti $contentmulti The Content Multi Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder,
		ContentMulti $contentmulti)
	{
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
	}

	/**
	 * Name one view to everything built for it.
	 *
	 * @param   object  $view  The view being built.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(&$view): void
	{
		// just to be safe, lets clear previous view placeholders
		$this->placeholder->clearType('view');
		$this->placeholder->clearType('views');

		// VIEW <<<DYNAMIC>>>
		if (isset($view->name_single) && $view->name_single != 'null')
		{
			// set main keys
			$nameSingleCode              = $view->name_single_code;
			$name_single_uppercase       = StringHelper::safe(
				$view->name_single, 'U'
			);
			$name_single_first_uppercase = StringHelper::safe(
				$view->name_single, 'F'
			);

			// set some place holder for the views
			$this->placeholder->set('view', $nameSingleCode);
			$this->placeholder->set('View', $name_single_first_uppercase);
			$this->placeholder->set('VIEW', $name_single_uppercase);
		}

		// VIEWS <<<DYNAMIC>>>
		if (isset($view->name_list) && $view->name_list != 'null')
		{
			$nameListCode              = $view->name_list_code;
			$name_list_uppercase       = StringHelper::safe(
				$view->name_list, 'U'
			);
			$name_list_first_uppercase = StringHelper::safe(
				$view->name_list, 'F'
			);

			// set some place holder for the views
			$this->placeholder->set('views', $nameListCode);
			$this->placeholder->set('Views', $name_list_first_uppercase);
			$this->placeholder->set('VIEWS', $name_list_uppercase);
		}

		// view <<<DYNAMIC>>>
		if (isset($nameSingleCode))
		{
			$this->contentmulti->set($nameSingleCode . '|view', $nameSingleCode);
			$this->contentmulti->set($nameSingleCode . '|VIEW', $name_single_uppercase);
			$this->contentmulti->set($nameSingleCode . '|View', $name_single_first_uppercase);

			if (isset($nameListCode))
			{
				$this->contentmulti->set($nameListCode . '|view', $nameSingleCode);
				$this->contentmulti->set($nameListCode . '|VIEW', $name_single_uppercase);
				$this->contentmulti->set($nameListCode . '|View', $name_single_first_uppercase);
			}
		}

		// views <<<DYNAMIC>>>
		if (isset($nameListCode))
		{
			$this->contentmulti->set($nameListCode . '|views', $nameListCode);
			$this->contentmulti->set($nameListCode . '|VIEWS', $name_list_uppercase);
			$this->contentmulti->set($nameListCode . '|Views', $name_list_first_uppercase);

			if (isset($nameSingleCode))
			{
				$this->contentmulti->set($nameSingleCode . '|views', $nameListCode);
				$this->contentmulti->set($nameSingleCode . '|VIEWS', $name_list_uppercase);
				$this->contentmulti->set($nameSingleCode . '|Views', $name_list_first_uppercase);
			}
		}
	}
}

