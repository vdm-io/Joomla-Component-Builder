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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AjaxCasesInterface;


/**
 * Controller Ajax Cases Class.
 * 
 * Builds the case of every ajax task a build target declares: the values the
 * task reads off the request, the check they have to pass, the model method
 * that answers, and how the answer is written back.
 * 
 * How the ajax model is asked for, and what a task that cannot run answers
 * with, are what the compile target decides, and they are the two extension
 * points below.
 * 
 * @since  6.1.7
 */
class AjaxCases implements AjaxCasesInterface
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
	 * Build the ajax controller cases one build target declares.
	 *
	 * @param   string  $target  The build target, site or administrator.
	 *
	 * @return  string  The cases, or nothing when the target declares no ajax.
	 *
	 * @since   6.1.7
	 */
	public function get($target): string
	{
		$cases = '';
		if (isset($this->dispenser->hub[$target]['ajax_controller'])
			&& ArrayHelper::check(
				$this->dispenser->hub[$target]['ajax_controller']
			))
		{
			$input      = [];
			$valueArray = [];
			$ifArray    = [];
			$getModel   = [];
			$userCheck  = [];
			$prefix     = ($target == 'site') ? 'Site':'Administrator';
			$failed     = $this->failed();
			foreach (
				$this->dispenser->hub[$target]['ajax_controller'] as $view
			)
			{
				foreach ($view as $task)
				{
					$input[$task['task_name']][]      = "\$"
						. $task['value_name'] . "Value = \$jinput->get('"
						. $task['value_name'] . "', " . $task['input_default']
						. ", '" . $task['input_filter'] . "');";
					$valueArray[$task['task_name']][] = "\$"
						. $task['value_name'] . "Value";
					$getModel[$task['task_name']] =
						"\$result = \$ajaxModule->"
						. $task['method_name'] . "(" . Placefix::_("valueArray") . ");";
					// check if null or zero is allowed
					if (!isset($task['allow_zero']) || 1 != $task['allow_zero'])
					{
						$ifArray[$task['task_name']][] = "\$"
							. $task['value_name'] . "Value";
					}
					// see user check is needed
					if (!isset($userCheck[$task['task_name']])
						&& isset($task['user_check'])
						&& 1 == $task['user_check'])
					{
						// add it since this means it was not set, and in the old method we assumed it was inplace
						// or it is set and 1 means we still want it inplace
						$ifArray[$task['task_name']][] = '$user->id != 0';
						// add it only once
						$userCheck[$task['task_name']] = true;
					}
				}
			}
			if (ArrayHelper::check($getModel))
			{
				foreach ($getModel as $task => $getMethod)
				{
					$cases .= PHP_EOL . Indent::_(4) . "case '" . $task . "':";
					$cases .= PHP_EOL . Indent::_(5) . "try";
					$cases .= PHP_EOL . Indent::_(5) . "{";
					foreach ($input[$task] as $string)
					{
						$cases .= PHP_EOL . Indent::_(6) . $string;
					}
					// set the values
					$values = implode(', ', $valueArray[$task]);
					// set the values to method
					$getMethod = str_replace(
						Placefix::_('valueArray'), $values,
						$getMethod
					);
					// check if we have some values to check
					if (isset($ifArray[$task])
						&& ArrayHelper::check($ifArray[$task]))
					{
						// set if string
						$ifvalues = implode(' && ', $ifArray[$task]);
						// add to case
						$cases .= PHP_EOL . Indent::_(6) . "if(" . $ifvalues
							. ")";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . $this->ajaxModel($prefix);
						$cases .= PHP_EOL . Indent::_(7) . "if (\$ajaxModule)";
						$cases .= PHP_EOL . Indent::_(7) . "{";
						$cases .= PHP_EOL . Indent::_(8) . $getMethod;
						$cases .= PHP_EOL . Indent::_(7) . "}";
						$cases .= PHP_EOL . Indent::_(7) . "else";
						$cases .= PHP_EOL . Indent::_(7) . "{";
						$cases .= PHP_EOL . Indent::_(8) . "\$result = $failed;";
						$cases .= PHP_EOL . Indent::_(7) . "}";
						$cases .= PHP_EOL . Indent::_(6) . "}";
						$cases .= PHP_EOL . Indent::_(6) . "else";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . "\$result = $failed;";
						$cases .= PHP_EOL . Indent::_(6) . "}";
					}
					else
					{
						$cases .= PHP_EOL . Indent::_(6) . $this->ajaxModel($prefix);
						$cases .= PHP_EOL . Indent::_(6) . "if (\$ajaxModule)";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . $getMethod;
						$cases .= PHP_EOL . Indent::_(6) . "}";
						$cases .= PHP_EOL . Indent::_(6) . "else";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . "\$result = $failed;";
						$cases .= PHP_EOL . Indent::_(6) . "}";
					}
					// continue the build
					$cases .= PHP_EOL . Indent::_(6)
						. "if(\$callback)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \$callback . \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6) . "elseif(\$returnRaw)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo json_encode(\$result);";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6) . "else";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(5) . "}";
					$cases .= PHP_EOL . Indent::_(5) . "catch(\Exception \$e)";
					$cases .= PHP_EOL . Indent::_(5) . "{";
					$cases .= PHP_EOL . Indent::_(6)
						. "if(\$callback)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \$callback.\"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6)
						. "elseif(\$returnRaw)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo json_encode(\$e);";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6) . "else";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(5) . "}";
					$cases .= PHP_EOL . Indent::_(4) . "break;";
				}
			}
		}

		return $cases;
	}

	/**
	 * What a task that cannot run answers with.
	 *
	 * @return  string  The expression.
	 *
	 * @since   6.1.7
	 */
	protected function failed(): string
	{
		return "['error' => 'There was an error! [149]']";
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
		return "\$ajaxModule = \$this->getModel('ajax', '$prefix');";
	}
}

