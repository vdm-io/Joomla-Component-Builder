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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Controller Ajax Tasks Class.
 * 
 * The ajax controller of a target registers every task the views of that
 * target were given, each task once however many views asked for it.
 * 
 * @since 6.1.7
 */
final class AjaxTasks
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
	 * @param Dispenser $dispenser The Customcode Dispenser Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Dispenser $dispenser)
	{
		$this->dispenser = $dispenser;
	}

	/**
	 * Build the task registrations of one target's ajax controller.
	 *
	 * A target no view was given ajax for gets none.
	 *
	 * @param   string  $target  The target being built.
	 *
	 * @return  string  The registrations.
	 *
	 * @since   6.1.7
	 */
	public function get($target): string
	{
		$tasks = '';
		if (isset($this->dispenser->hub[$target]['ajax_controller'])
			&& ArrayHelper::check(
				$this->dispenser->hub[$target]['ajax_controller']
			))
		{
			$taskArray = [];
			foreach (
				$this->dispenser->hub[$target]['ajax_controller'] as $view
			)
			{
				foreach ($view as $task)
				{
					$taskArray[$task['task_name']] = $task['task_name'];
				}
			}
			if (ArrayHelper::check($taskArray))
			{
				foreach ($taskArray as $name)
				{
					$tasks .= PHP_EOL . Indent::_(2) . "\$this->registerTask('"
						. $name . "', 'ajax');";
				}
			}
		}

		return $tasks;
	}
}

