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


use VDM\Joomla\Componentbuilder\Compiler\Builder\ValidationFix as ValidationFixRegistry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Registry as CompilerRegistry;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Validation Fix Class.
 * 
 * Builds server-side conditional requirements from the same normalized
 * definitions used by the administrator form script.
 * 
 * @since 6.1.7
 */
final class ValidationFix
{
	/**
	 * The Validation Fix Builder Class.
	 *
	 * @var   ValidationFixRegistry
	 * @since 6.1.7
	 */
	protected ValidationFixRegistry $validationfix;

	/**
	 * The compiler registry for generated validation rule files.
	 *
	 * @var    CompilerRegistry
	 * @since  6.2.0
	 */
	protected CompilerRegistry $registry;

	/**
	 * The native conditional rule emitter.
	 *
	 * @var    ConditionalRule
	 * @since  6.2.0
	 */
	protected ConditionalRule $conditionalrule;

	/**
	 * Constructor.
	 *
	 * @param   ValidationFixRegistry  $validationfix   Normalized condition definitions.
	 * @param   CompilerRegistry       $registry        Generated rule registry.
	 * @param   ConditionalRule        $conditionalrule Native rule emitter.
	 * @since   6.2.0
	 */
	public function __construct(ValidationFixRegistry $validationfix, CompilerRegistry $registry, ConditionalRule $conditionalrule)
	{
		$this->validationfix = $validationfix;
		$this->registry = $registry;
		$this->conditionalrule = $conditionalrule;
	}

	/**
	 * Build the validation fix statements of a view.
	 *
	 * Only a view that was found to need one gets it.
	 *
	 * @param   string  $view       The single view name.
	 * @param   string  $Component  The component name.
	 *
	 * @return  string  The statements, or nothing when the view needs none.
	 *
	 * @since   6.1.7
	 */
	public function get($view, $Component): string
	{
		$fix = '';
		if (ArrayHelper::check(
				$this->validationfix->get($view)
			))
		{
			$fix .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$fix .= PHP_EOL . Indent::_(1)
				. " * Method to validate the form data.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @param   Form   \$form   The form to validate against.";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @param   array   \$data   The data to validate.";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @param   string  \$group  The name of the field group to validate.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @return  mixed  Array of filtered data if valid, false otherwise.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1) . " * @see     JFormRule";
			$fix .= PHP_EOL . Indent::_(1) . " * @see     JFilterInput";
			$fix .= PHP_EOL . Indent::_(1) . " * @since   12.2";
			$fix .= PHP_EOL . Indent::_(1) . " */";
			$fix .= PHP_EOL . Indent::_(1)
				. "public function validate(\$form, \$data, \$group = null)";
			$fix .= PHP_EOL . Indent::_(1) . "{";
			$fix .= $this->validationfix->getConditions($view) === []
				? PHP_EOL . Indent::_(2) . "return parent::validate(\$form, \$data, \$group);"
				: $this->lifecycle($view);
			$fix .= PHP_EOL . Indent::_(1) . "}";
		}

		return $fix;
	}

	/**
	 * Keep native model events, filtering, validation and post-processing intact.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	protected function lifecycle(string $view): string
	{
		$this->registry->set('validation.rules.jcbconditionalrequired', $this->conditionalrule->get());
		$code = PHP_EOL . Indent::_(2) . '$conditionRule = Joomla__' . '_571422c4_0340_49f8_b846_5729c7af6ed7___Power::loadRuleType(\'jcbconditionalrequired\');'
			. PHP_EOL . Indent::_(2) . '$conditionField = \'__jcb_conditional_required\';'
			. PHP_EOL . Indent::_(2) . 'if (!$conditionRule || $form->getFieldXml($conditionField, $group) !== false)'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'return false;'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . '$conditionRan = false;'
			. PHP_EOL . Indent::_(2) . '$conditionAttributes = [];'
			. PHP_EOL . Indent::_(2) . '$conditionCallback = function (array $data) use ($form, $group, &$conditionRan, &$conditionAttributes): bool'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'if ($conditionRan)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'return false;'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$conditionRan = true;';
		$code .= $this->conditions($view);
		$code .= PHP_EOL . Indent::_(3) . 'return true;'
			. PHP_EOL . Indent::_(2) . '};'
			. PHP_EOL . Indent::_(2) . 'if (!$conditionRule::attach($form, $conditionCallback, $group, $conditionField))'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'return false;'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . '$conditionNode = null;'
			. PHP_EOL . Indent::_(2) . 'try'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . '$element = new \\SimpleXMLElement(\'<field name="__jcb_conditional_required" type="hidden" filter="unset" validate="jcbconditionalrequired" />\');'
			. PHP_EOL . Indent::_(3) . 'if (!$form->setField($element, $group))'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'return false;'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$element = $form->getFieldXml($conditionField, $group);'
			. PHP_EOL . Indent::_(3) . 'if ($element === false)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'return false;'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$conditionNode = dom_import_simplexml($element);'
			. PHP_EOL . Indent::_(3) . '$container = $conditionNode->parentNode;'
			. PHP_EOL . Indent::_(3) . 'while ($container->nodeName !== \'form\' && $container->nodeName !== \'fields\')'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '$container = $container->parentNode;'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$container->insertBefore($conditionNode, $container->firstChild);'
			. PHP_EOL . Indent::_(3) . '//' . Line::_(__LINE__, __CLASS__) . ' The internal rule needs no submitted value and must never reach persistence.'
			. PHP_EOL . Indent::_(3) . '$conditionPath = $group ? $group . \'.\' . $conditionField : $conditionField;'
			. PHP_EOL . Indent::_(3) . '$conditionInput = new Joomla__' . '_a87c432d_b5b4_428e_b7ff_14b51664c624___Power($data);'
			. PHP_EOL . Indent::_(3) . '$conditionInput->remove($conditionPath);'
			. PHP_EOL . Indent::_(3) . '$result = parent::validate($form, $conditionInput->toArray(), $group);'
			. PHP_EOL . Indent::_(3) . 'if (!$conditionRan || $result === false)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'return false;'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$conditionOutput = new Joomla__' . '_a87c432d_b5b4_428e_b7ff_14b51664c624___Power($result);'
			. PHP_EOL . Indent::_(3) . '$conditionOutput->remove($conditionPath);'
			. PHP_EOL . Indent::_(3) . 'return $conditionOutput->toArray();'
			. PHP_EOL . Indent::_(2) . '}'
			. PHP_EOL . Indent::_(2) . 'finally'
			. PHP_EOL . Indent::_(2) . '{'
			. PHP_EOL . Indent::_(3) . 'if ($conditionNode !== null && $conditionNode->parentNode !== null)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '$conditionNode->parentNode->removeChild($conditionNode);'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . 'foreach ($conditionAttributes as [$conditionElement, $conditionRequired])'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'if ($conditionRequired === null)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'unset($conditionElement[\'required\']);'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . 'else'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . '$conditionElement[\'required\'] = $conditionRequired;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$form->removeField($conditionField, $group);'
			. PHP_EOL . Indent::_(3) . '$conditionRule::detach($form);'
			. PHP_EOL . Indent::_(2) . '}';
		return $code;
	}

	/**
	 * Render conditional requirements without trusting browser-supplied field names.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	protected function conditions(string $view): string
	{
		$groups = $this->validationfix->getConditions($view);
		if ($groups === [])
		{
			return '';
		}

		$code = PHP_EOL . Indent::_(3) . '$conditionGroups = ' . $this->export($groups) . ';';
		$code .= PHP_EOL . Indent::_(3) . '//' . Line::_(__LINE__, __CLASS__) . ' The browser\'s not_required list is informational, never an authority.'
			. PHP_EOL . Indent::_(3) . '$conditionInput = new Joomla__' . '_a87c432d_b5b4_428e_b7ff_14b51664c624___Power($data);'
			. PHP_EOL . Indent::_(3) . '$conditionData = $group ? (array) $conditionInput->get($group, []) : $data;'
			. PHP_EOL . Indent::_(3) . '$conditionStored = [];'
			. PHP_EOL . Indent::_(3) . '$conditionApp = Joomla__' . '_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();'
			. PHP_EOL . Indent::_(3) . '$conditionPatch = $conditionApp->isClient(\'api\') && $conditionApp->getInput()->getMethod() === \'PATCH\';'
			. PHP_EOL . Indent::_(3) . '$recordId = (int) ($data[\'id\'] ?? $this->getState($this->getName() . \'.id\', 0));'
			. PHP_EOL . Indent::_(3) . 'if ($recordId > 0)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '$stored = $this->getItem($recordId);'
			. PHP_EOL . Indent::_(4) . 'if ($stored === false || $stored === null)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'return false;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . '$conditionStored = new Joomla__' . '_a87c432d_b5b4_428e_b7ff_14b51664c624___Power($stored);'
			. PHP_EOL . Indent::_(4) . '$conditionStored = $group ? (array) $conditionStored->get($group, []) : $conditionStored->toArray();'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '$conditionPresent = static function ($value): bool'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'return $value !== null && $value !== \'\' && $value !== [];'
			. PHP_EOL . Indent::_(3) . '};'
			. PHP_EOL . Indent::_(3) . '$conditionEquals = static function ($value, $option): bool'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '//' . Line::_(__LINE__, __CLASS__) . ' Selection values arrive as DOM strings; numeric/boolean options use JS equality.'
			. PHP_EOL . Indent::_(4) . 'if (is_numeric($option) || $option === \'true\' || $option === \'false\')'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'if ($value === null)'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . 'return false;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . '$number = $option === \'true\' ? 1 : ($option === \'false\' ? 0 : (float) $option);'
			. PHP_EOL . Indent::_(5) . 'if (is_bool($value) || (is_string($value) && trim($value) === \'\'))'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . 'return (float) $value === (float) $number;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'return is_numeric($value) && (float) $value === (float) $number;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . 'return is_scalar($value) && (string) $value === (string) $option;'
			. PHP_EOL . Indent::_(3) . '};'
			. PHP_EOL . Indent::_(3) . '$conditionMatch = static function ($value, array $rule) use ($conditionPresent, $conditionEquals): bool'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '$behavior = $rule[\'behavior\'];'
			. PHP_EOL . Indent::_(4) . '$options = $rule[\'options\'];'
			. PHP_EOL . Indent::_(4) . 'if ($behavior >= 1 && $behavior <= 3)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'if ($options !== [])'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . 'foreach ($options as $option)'
			. PHP_EOL . Indent::_(6) . '{'
			. PHP_EOL . Indent::_(7) . '$equal = $conditionEquals($value, $option);'
			. PHP_EOL . Indent::_(7) . '//' . Line::_(__LINE__, __CLASS__) . ' Preserve the browser\'s OR across options, including Is Not.'
			. PHP_EOL . Indent::_(7) . 'if ($behavior === 2 ? !$equal : $equal)'
			. PHP_EOL . Indent::_(7) . '{'
			. PHP_EOL . Indent::_(8) . 'return true;'
			. PHP_EOL . Indent::_(7) . '}'
			. PHP_EOL . Indent::_(6) . '}'
			. PHP_EOL . Indent::_(6) . 'return false;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . '$present = $conditionPresent($value);'
			. PHP_EOL . Indent::_(5) . 'if ($behavior === 2)'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . 'return !$present;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'return $present && !($behavior === 3 && $rule[\'user\'] && $conditionEquals($value, \'0\'));'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . 'if ($behavior === 4 || $behavior === 5)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'return $behavior === 4 ? $conditionPresent($value) : !$conditionPresent($value);'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . 'if (!is_scalar($value) && $value !== null)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'return false;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . '$value = (string) $value;'
			. PHP_EOL . Indent::_(4) . 'if ($behavior >= 6 && $behavior <= 9)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . '$keywords = $options[\'keywords\'] ?? [];'
			. PHP_EOL . Indent::_(5) . 'if ($keywords === [])'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . 'return $value === \'error\';'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . '$all = $behavior === 6 || $behavior === 8;'
			. PHP_EOL . Indent::_(5) . 'if ($behavior === 8 || $behavior === 9)'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$value = StringHelper::strtolower($value);'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'foreach ($keywords as $keyword)'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$found = strpos($value, $keyword) !== false;'
			. PHP_EOL . Indent::_(6) . 'if ($all ? !$found : $found)'
			. PHP_EOL . Indent::_(6) . '{'
			. PHP_EOL . Indent::_(7) . 'return !$all;'
			. PHP_EOL . Indent::_(6) . '}'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'return $all;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . '//' . Line::_(__LINE__, __CLASS__) . ' JavaScript length counts UTF-16 code units, including surrogate pairs.'
			. PHP_EOL . Indent::_(4) . '$length = StringHelper::strlen($value) + preg_match_all(\'/[\\x{10000}-\\x{10FFFF}]/u\', $value);'
			. PHP_EOL . Indent::_(4) . '$expected = (int) (($options[\'length\'] ?? 0) ?: 5);'
			. PHP_EOL . Indent::_(4) . 'switch ($behavior)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . 'case 10:'
			. PHP_EOL . Indent::_(6) . 'return $length >= $expected;'
			. PHP_EOL . Indent::_(5) . 'case 11:'
			. PHP_EOL . Indent::_(6) . 'return $length <= $expected;'
			. PHP_EOL . Indent::_(5) . 'case 12:'
			. PHP_EOL . Indent::_(6) . 'return $length == $expected;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . 'return false;'
			. PHP_EOL . Indent::_(3) . '};'
			. PHP_EOL . Indent::_(3) . '$conditionalRequired = [];'
			. PHP_EOL . Indent::_(3) . 'foreach ($conditionGroups as $conditionGroup)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . 'foreach ($conditionGroup[\'targets\'] as $target)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . '$conditionalRequired[$target] = true;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . 'foreach ($conditionGroups as $conditionGroup)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '$matched = true;'
			. PHP_EOL . Indent::_(4) . 'foreach ($conditionGroup[\'matches\'] as $rule)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . '//' . Line::_(__LINE__, __CLASS__) . ' Unsupported definitions cannot relax a required field.'
			. PHP_EOL . Indent::_(5) . 'if (!$rule[\'supported\'])'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . 'continue 2;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . '//' . Line::_(__LINE__, __CLASS__) . ' ACL-denied selectors cannot change applicability through discarded input.'
			. PHP_EOL . Indent::_(5) . '$disabled = strtolower((string) $form->getFieldAttribute($rule[\'name\'], \'disabled\', \'\', $group));'
			. PHP_EOL . Indent::_(5) . '$filter = strtolower((string) $form->getFieldAttribute($rule[\'name\'], \'filter\', \'\', $group));'
			. PHP_EOL . Indent::_(5) . '$available = $form->getFieldAttribute($rule[\'name\'], \'name\', null, $group) !== null;'
			. PHP_EOL . Indent::_(5) . '$protected = !$available || in_array($disabled, [\'true\', \'1\', \'disabled\'], true) || $filter === \'unset\';'
			. PHP_EOL . Indent::_(5) . '$values = $protected ? $conditionStored : $conditionData;'
			. PHP_EOL . Indent::_(5) . 'if (array_key_exists($rule[\'name\'], $values))'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$value = $values[$rule[\'name\']];'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'elseif (!$protected && $conditionPatch && array_key_exists($rule[\'name\'], $conditionStored))'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$value = $conditionStored[$rule[\'name\']];'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'elseif (!$protected && $rule[\'checkbox\'])'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '//' . Line::_(__LINE__, __CLASS__) . ' Native unchecked checkboxes omit their key on ordinary form submissions.'
			. PHP_EOL . Indent::_(6) . '$value = false;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'else'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$value = $form->getFieldAttribute($rule[\'name\'], \'default\', null, $group);'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'if ($rule[\'checkbox\'])'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$value = (bool) $value;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'if ($rule[\'array\'])'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$values = $conditionPresent($value) ? (array) $value : [];'
			. PHP_EOL . Indent::_(6) . '$oneMatches = false;'
			. PHP_EOL . Indent::_(6) . 'foreach ($values as $entry)'
			. PHP_EOL . Indent::_(6) . '{'
			. PHP_EOL . Indent::_(7) . 'if ($conditionMatch($entry, $rule))'
			. PHP_EOL . Indent::_(7) . '{'
			. PHP_EOL . Indent::_(8) . '$oneMatches = true;'
			. PHP_EOL . Indent::_(8) . 'break;'
			. PHP_EOL . Indent::_(7) . '}'
			. PHP_EOL . Indent::_(6) . '}'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . 'else'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$oneMatches = $conditionMatch($value, $rule);'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(5) . '$matched = $matched && $oneMatches;'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(4) . 'if ($matched || $conditionGroup[\'toggle\'])'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . '$required = $matched ? $conditionGroup[\'show\'] : !$conditionGroup[\'show\'];'
			. PHP_EOL . Indent::_(5) . 'foreach ($conditionGroup[\'targets\'] as $target)'
			. PHP_EOL . Indent::_(5) . '{'
			. PHP_EOL . Indent::_(6) . '$conditionalRequired[$target] = $required;'
			. PHP_EOL . Indent::_(5) . '}'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . 'foreach ($conditionalRequired as $field => $required)'
			. PHP_EOL . Indent::_(3) . '{'
			. PHP_EOL . Indent::_(4) . '$conditionElement = $form->getFieldXml($field, $group);'
			. PHP_EOL . Indent::_(4) . 'if ($conditionElement !== false)'
			. PHP_EOL . Indent::_(4) . '{'
			. PHP_EOL . Indent::_(5) . '//' . Line::_(__LINE__, __CLASS__) . ' Snapshot after native validation plugins have finished changing the form.'
			. PHP_EOL . Indent::_(5) . '$conditionAttributes[] = [$conditionElement, isset($conditionElement[\'required\']) ? (string) $conditionElement[\'required\'] : null];'
			. PHP_EOL . Indent::_(5) . '$form->setFieldAttribute($field, \'required\', $required ? \'true\' : \'false\', $group);'
			. PHP_EOL . Indent::_(4) . '}'
			. PHP_EOL . Indent::_(3) . '}'
			. PHP_EOL . Indent::_(3) . '//' . Line::_(__LINE__, __CLASS__) . ' Inactive fields keep their values; ordinary filtering and validation still apply.';

		return $code;
	}

	/**
	 * Export normalized condition data as a compact PHP array literal.
	 *
	 * @param   mixed  $value  A scalar or array from the compiler definition.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	protected function export($value): string
	{
		if (!is_array($value))
		{
			return var_export($value, true);
		}

		$items = [];
		foreach ($value as $key => $item)
		{
			$items[] = var_export($key, true) . ' => ' . $this->export($item);
		}

		return '[' . implode(', ', $items) . ']';
	}
}

