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
		$code = $this->joomlaPowers(PHP_EOL . <<<'PHP'
		$conditionRule = __JCB_VALIDATION_FORM_HELPER__::loadRuleType('jcbconditionalrequired');
		$conditionField = '__jcb_conditional_required';
		if (!$conditionRule || $form->getFieldXml($conditionField, $group) !== false)
		{
			return false;
		}
		$conditionRan = false;
		$conditionAttributes = [];
		$conditionCallback = function (array $data) use ($form, $group, &$conditionRan, &$conditionAttributes): bool
		{
			if ($conditionRan)
			{
				return false;
			}
			$conditionRan = true;
PHP
		);
		$code .= str_replace(PHP_EOL . Indent::_(2), PHP_EOL . Indent::_(3), $this->conditions($view));
		$code .= $this->joomlaPowers(PHP_EOL . <<<'PHP'
			return true;
		};
		if (!$conditionRule::attach($form, $conditionCallback, $group, $conditionField))
		{
			return false;
		}
		$conditionNode = null;
		try
		{
			$element = new \SimpleXMLElement('<field name="__jcb_conditional_required" type="hidden" filter="unset" validate="jcbconditionalrequired" />');
			if (!$form->setField($element, $group))
			{
				return false;
			}
			$element = $form->getFieldXml($conditionField, $group);
			if ($element === false)
			{
				return false;
			}
			$conditionNode = dom_import_simplexml($element);
			$container = $conditionNode->parentNode;
			while ($container->nodeName !== 'form' && $container->nodeName !== 'fields')
			{
				$container = $container->parentNode;
			}
			$container->insertBefore($conditionNode, $container->firstChild);
			// The internal rule needs no submitted value and must never reach persistence.
			$conditionPath = $group ? $group . '.' . $conditionField : $conditionField;
			$conditionInput = new __JCB_VALIDATION_REGISTRY__($data);
			$conditionInput->remove($conditionPath);
			$result = parent::validate($form, $conditionInput->toArray(), $group);
			if (!$conditionRan || $result === false)
			{
				return false;
			}
			$conditionOutput = new __JCB_VALIDATION_REGISTRY__($result);
			$conditionOutput->remove($conditionPath);
			return $conditionOutput->toArray();
		}
		finally
		{
			if ($conditionNode !== null && $conditionNode->parentNode !== null)
			{
				$conditionNode->parentNode->removeChild($conditionNode);
			}
			foreach ($conditionAttributes as [$conditionElement, $conditionRequired])
			{
				if ($conditionRequired === null)
				{
					unset($conditionElement['required']);
				}
				else
				{
					$conditionElement['required'] = $conditionRequired;
				}
			}
			$form->removeField($conditionField, $group);
			$conditionRule::detach($form);
		}
PHP
		);
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

		$code = PHP_EOL . Indent::_(2) . '$conditionGroups = ' . $this->export($groups) . ';';
		$code .= $this->joomlaPowers(PHP_EOL . <<<'PHP'
		// The browser's not_required list is informational, never an authority.
		$conditionInput = new __JCB_VALIDATION_REGISTRY__($data);
		$conditionData = $group ? (array) $conditionInput->get($group, []) : $data;
		$conditionStored = [];
		$conditionApp = __JCB_VALIDATION_FACTORY__::getApplication();
		$conditionPatch = $conditionApp->isClient('api') && $conditionApp->getInput()->getMethod() === 'PATCH';
		$recordId = (int) ($data['id'] ?? $this->getState($this->getName() . '.id', 0));
		if ($recordId > 0)
		{
			$stored = $this->getItem($recordId);
			if ($stored === false || $stored === null)
			{
				return false;
			}
			$conditionStored = new __JCB_VALIDATION_REGISTRY__($stored);
			$conditionStored = $group ? (array) $conditionStored->get($group, []) : $conditionStored->toArray();
		}
		$conditionPresent = static function ($value): bool
		{
			return $value !== null && $value !== '' && $value !== [];
		};
		$conditionEquals = static function ($value, $option): bool
		{
			// Selection values arrive as DOM strings; numeric/boolean options use JS equality.
			if (is_numeric($option) || $option === 'true' || $option === 'false')
			{
				if ($value === null)
				{
					return false;
				}
				$number = $option === 'true' ? 1 : ($option === 'false' ? 0 : (float) $option);
				if (is_bool($value) || (is_string($value) && trim($value) === ''))
				{
					return (float) $value === (float) $number;
				}
				return is_numeric($value) && (float) $value === (float) $number;
			}
			return is_scalar($value) && (string) $value === (string) $option;
		};
		$conditionMatch = static function ($value, array $rule) use ($conditionPresent, $conditionEquals): bool
		{
			$behavior = $rule['behavior'];
			$options = $rule['options'];
			if ($behavior >= 1 && $behavior <= 3)
			{
				if ($options !== [])
				{
					foreach ($options as $option)
					{
						$equal = $conditionEquals($value, $option);
						// Preserve the browser's OR across options, including Is Not.
						if ($behavior === 2 ? !$equal : $equal)
						{
							return true;
						}
					}
					return false;
				}
				$present = $conditionPresent($value);
				if ($behavior === 2)
				{
					return !$present;
				}
				return $present && !($behavior === 3 && $rule['user'] && $conditionEquals($value, '0'));
			}
			if ($behavior === 4 || $behavior === 5)
			{
				return $behavior === 4 ? $conditionPresent($value) : !$conditionPresent($value);
			}
			if (!is_scalar($value) && $value !== null)
			{
				return false;
			}
			$value = (string) $value;
			if ($behavior >= 6 && $behavior <= 9)
			{
				$keywords = $options['keywords'] ?? [];
				if ($keywords === [])
				{
					return $value === 'error';
				}
				$all = $behavior === 6 || $behavior === 8;
				if ($behavior === 8 || $behavior === 9)
				{
					$value = StringHelper::strtolower($value);
				}
				foreach ($keywords as $keyword)
				{
					$found = strpos($value, $keyword) !== false;
					if ($all ? !$found : $found)
					{
						return !$all;
					}
				}
				return $all;
			}
			// JavaScript length counts UTF-16 code units, including surrogate pairs.
			$length = StringHelper::strlen($value) + preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $value);
			$expected = (int) (($options['length'] ?? 0) ?: 5);
			switch ($behavior)
			{
				case 10:
					return $length >= $expected;
				case 11:
					return $length <= $expected;
				case 12:
					return $length == $expected;
			}
			return false;
		};
		$conditionalRequired = [];
		foreach ($conditionGroups as $conditionGroup)
		{
			foreach ($conditionGroup['targets'] as $target)
			{
				$conditionalRequired[$target] = true;
			}
		}
		foreach ($conditionGroups as $conditionGroup)
		{
			$matched = true;
			foreach ($conditionGroup['matches'] as $rule)
			{
				// Unsupported definitions cannot relax a required field.
				if (!$rule['supported'])
				{
					continue 2;
				}
				// ACL-denied selectors cannot change applicability through discarded input.
				$disabled = strtolower((string) $form->getFieldAttribute($rule['name'], 'disabled', '', $group));
				$filter = strtolower((string) $form->getFieldAttribute($rule['name'], 'filter', '', $group));
				$available = $form->getFieldAttribute($rule['name'], 'name', null, $group) !== null;
				$protected = !$available || in_array($disabled, ['true', '1', 'disabled'], true) || $filter === 'unset';
				$values = $protected ? $conditionStored : $conditionData;
				if (array_key_exists($rule['name'], $values))
				{
					$value = $values[$rule['name']];
				}
				elseif (!$protected && $conditionPatch && array_key_exists($rule['name'], $conditionStored))
				{
					$value = $conditionStored[$rule['name']];
				}
				elseif (!$protected && $rule['checkbox'])
				{
					// Native unchecked checkboxes omit their key on ordinary form submissions.
					$value = false;
				}
				else
				{
					$value = $form->getFieldAttribute($rule['name'], 'default', null, $group);
				}
				if ($rule['checkbox'])
				{
					$value = (bool) $value;
				}
				if ($rule['array'])
				{
					$values = $conditionPresent($value) ? (array) $value : [];
					$oneMatches = false;
					foreach ($values as $entry)
					{
						if ($conditionMatch($entry, $rule))
						{
							$oneMatches = true;
							break;
						}
					}
				}
				else
				{
					$oneMatches = $conditionMatch($value, $rule);
				}
				$matched = $matched && $oneMatches;
			}
			if ($matched || $conditionGroup['toggle'])
			{
				$required = $matched ? $conditionGroup['show'] : !$conditionGroup['show'];
				foreach ($conditionGroup['targets'] as $target)
				{
					$conditionalRequired[$target] = $required;
				}
			}
		}
		foreach ($conditionalRequired as $field => $required)
		{
			$conditionElement = $form->getFieldXml($field, $group);
			if ($conditionElement !== false)
			{
				// Snapshot after native validation plugins have finished changing the form.
				$conditionAttributes[] = [$conditionElement, isset($conditionElement['required']) ? (string) $conditionElement['required'] : null];
				$form->setFieldAttribute($field, 'required', $required ? 'true' : 'false', $group);
			}
		}
		// Inactive fields keep their values; ordinary filtering and validation still apply.
PHP
		);

		return $code;
	}

	/**
	 * Insert Joomla Power keys into a static generated-code template.
	 *
	 * Keep the keys split in this compiler class so that compiling JCB itself
	 * does not resolve them before the generated model is processed.
	 * Apply this only to static templates, never to exported condition values.
	 *
	 * @param   string  $code  The static generated-code template.
	 *
	 * @return  string  The template containing deferred Joomla Power keys.
	 * @since   6.2.0
	 */
	protected function joomlaPowers(string $code): string
	{
		return strtr($code, [
			'__JCB_VALIDATION_FORM_HELPER__' => 'Joomla__' . '_571422c4_0340_49f8_b846_5729c7af6ed7___Power',
			'__JCB_VALIDATION_REGISTRY__' => 'Joomla__' . '_a87c432d_b5b4_428e_b7ff_14b51664c624___Power',
			'__JCB_VALIDATION_FACTORY__' => 'Joomla__' . '_39403062_84fb_46e0_bac4_0023f766e827___Power',
		]);
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

