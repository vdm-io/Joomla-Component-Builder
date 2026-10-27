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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Emit the small native FormRule bridge for conditional requirements.
 * 
 * @since  6.2.0
 */
final class ConditionalRule
{
	/**
	 * Build the rule methods used by every conditioned form in the component.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	public function get(): string
	{
		return Indent::_(1) . '/**'
			. PHP_EOL . Indent::_(1) . ' * Active model callbacks, isolated by their exact validation form.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @var    \\SplObjectStorage|null'
			. PHP_EOL . Indent::_(1) . ' * @since  6.2.0'
			. PHP_EOL . Indent::_(1) . ' */'
			. PHP_EOL . Indent::_(1) . 'private static $callbacks;'
			. PHP_EOL
			. PHP_EOL . Indent::_(1) . '/**'
			. PHP_EOL . Indent::_(1) . ' * Attach one temporary callback without allowing recursive validation.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @param   Form      $form      The original validation form.'
			. PHP_EOL . Indent::_(1) . ' * @param   \\Closure  $callback  The conditional requirement evaluator.'
			. PHP_EOL . Indent::_(1) . ' * @param   ?string   $group     The selected field group.'
			. PHP_EOL . Indent::_(1) . ' * @param   string    $field     The internal field name.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @return  bool'
			. PHP_EOL . Indent::_(1) . ' * @since   6.2.0'
			. PHP_EOL . Indent::_(1) . ' */'
			. PHP_EOL . Indent::_(1) . 'public static function attach(Form $form, \\Closure $callback, ?string $group, string $field): bool'
			. PHP_EOL . Indent::_(1) . '{'
			. PHP_EOL . Indent::_(2) . 'if (self::$callbacks === null)'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'self::$callbacks = new \\SplObjectStorage();'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . 'if (self::$callbacks->contains($form))'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'return false;'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . 'self::$callbacks[$form] = [$callback, $group, $field];'
			. PHP_EOL . Indent::_(2) . 'return true;'
			. PHP_EOL . Indent::_(1) . '}'
			. PHP_EOL
			. PHP_EOL . Indent::_(1) . '/**'
			. PHP_EOL . Indent::_(1) . ' * Release the callback on success, validation failure, or an exception.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @param   Form  $form  The original validation form.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @return  void'
			. PHP_EOL . Indent::_(1) . ' * @since   6.2.0'
			. PHP_EOL . Indent::_(1) . ' */'
			. PHP_EOL . Indent::_(1) . 'public static function detach(Form $form): void'
			. PHP_EOL . Indent::_(1) . '{'
			. PHP_EOL . Indent::_(2) . 'if (self::$callbacks !== null)'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'self::$callbacks->detach($form);'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(1) . '}'
			. PHP_EOL
			. PHP_EOL . Indent::_(1) . '/**'
			. PHP_EOL . Indent::_(1) . ' * Apply requirements before the selected fields validate, using filtered data.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @param   \\SimpleXMLElement  $element  The internal field definition.'
			. PHP_EOL . Indent::_(1) . ' * @param   mixed              $value    Ignored; browser input is never authoritative.'
			. PHP_EOL . Indent::_(1) . ' * @param   ?string            $group    The field group being validated.'
			. PHP_EOL . Indent::_(1) . ' * @param   ?Registry          $input    All values after native filtering.'
			. PHP_EOL . Indent::_(1) . ' * @param   ?Form              $form     The original validation form.'
			. PHP_EOL . Indent::_(1) . ' *'
			. PHP_EOL . Indent::_(1) . ' * @return  bool'
			. PHP_EOL . Indent::_(1) . ' * @since   6.2.0'
			. PHP_EOL . Indent::_(1) . ' */'
			. PHP_EOL . Indent::_(1) . 'public function test(\\SimpleXMLElement $element, $value, $group = null, ?Registry $input = null, ?Form $form = null)'
			. PHP_EOL . Indent::_(1) . '{'
			. PHP_EOL . Indent::_(2) . 'if ($form === null || $input === null || self::$callbacks === null || !self::$callbacks->contains($form))'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'return false;'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . '[$callback, $selectedGroup, $field] = self::$callbacks[$form];'
			. PHP_EOL . Indent::_(2) . 'if ((string) $element[\'name\'] !== $field || (string) $group !== (string) $selectedGroup)'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'return false;'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . '//' . Line::_(__LINE__, __CLASS__) . ' A plugin may edit the form, but cannot move this rule after a selected field.'
			. PHP_EOL . Indent::_(2) . 'foreach ($element->xpath(\'preceding::field[not(ancestor::field)]\') ?: [] as $previous)'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . '$groups = $previous->xpath(\'ancestor::fields[@name]/@name\');'
			. PHP_EOL . Indent::_(3) . '$previousGroup = implode(\'.\', array_map(\'strval\', $groups ?: []));'
			. PHP_EOL . Indent::_(3) . 'if ($selectedGroup === null || $selectedGroup === \'\' || $previousGroup === $selectedGroup'
			. PHP_EOL . Indent::_(4) . '|| strpos($previousGroup, $selectedGroup . \'.\') === 0)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'return false;'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . 'return $callback($input->toArray());'
			. PHP_EOL . Indent::_(1) . '}';
	}
}

