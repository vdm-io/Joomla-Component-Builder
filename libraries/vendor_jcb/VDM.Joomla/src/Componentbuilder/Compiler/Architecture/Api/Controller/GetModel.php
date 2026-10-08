<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Api Controller Get Model Class.
 * 
 * Builds the getModel method of both API controllers of a view. Each
 * controller selects the model of its resource role, regardless of the name
 * Joomla derives from the content type.
 * 
 * @since 6.1.7
 */
final class GetModel
{
	/**
	 * Get the model mapping code of the API controllers.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 * @param   bool    $isList          Whether this controller serves the list resource.
	 *
	 * @return  string  The get model method body.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode, bool $isList = false): string
	{
		$code = [];
		$model = $isList ? $nameListCode : $nameSingleCode;

		$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " The controller role selects its explicit native model.";
		$code[] = Indent::_(2)
			. "\$name = '" . $model . "';";
		$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " The API carries no request state for the model, as the form controller does not:";
		$code[] = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " the id a save sets must never be replaced by a later read of the request.";
		$code[] = Indent::_(2) . "if (!array_key_exists('ignore_request', \$config))";
		$code[] = Indent::_(2) . "{";
		$code[] = Indent::_(3) . "\$config['ignore_request'] = true;";
		$code[] = Indent::_(2) . "}";
		$code[] = PHP_EOL . Indent::_(2)
			. "return parent::getModel(\$name, \$prefix, \$config);";

		return implode(PHP_EOL, $code);
	}
}

