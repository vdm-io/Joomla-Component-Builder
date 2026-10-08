<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Administrator\Rule;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormRule;
use Joomla\Registry\Registry;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Form Rule (Jcbconditionalrequired) class for the Joomla Platform.
 *
 * @since  3.5
 */
class JcbconditionalrequiredRule extends FormRule
{
	/**
	 * Active model callbacks, isolated by their exact validation form.
	 *
	 * @var    \SplObjectStorage|null
	 * @since  6.2.0
	 */
	private static $callbacks;

	/**
	 * Attach one temporary callback without allowing recursive validation.
	 *
	 * @param   Form      $form      The original validation form.
	 * @param   \Closure  $callback  The conditional requirement evaluator.
	 * @param   ?string   $group     The selected field group.
	 * @param   string    $field     The internal field name.
	 *
	 * @return  bool
	 * @since   6.2.0
	 */
	public static function attach(Form $form, \Closure $callback, ?string $group, string $field): bool
	{
		if (self::$callbacks === null)
		{
			self::$callbacks = new \SplObjectStorage();
		}
		if (self::$callbacks->contains($form))
		{
			return false;
		}
		self::$callbacks[$form] = [$callback, $group, $field];
		return true;
	}

	/**
	 * Release the callback on success, validation failure, or an exception.
	 *
	 * @param   Form  $form  The original validation form.
	 *
	 * @return  void
	 * @since   6.2.0
	 */
	public static function detach(Form $form): void
	{
		if (self::$callbacks !== null)
		{
			self::$callbacks->detach($form);
		}
	}

	/**
	 * Apply requirements before the selected fields validate, using filtered data.
	 *
	 * @param   \SimpleXMLElement  $element  The internal field definition.
	 * @param   mixed              $value    Ignored; browser input is never authoritative.
	 * @param   ?string            $group    The field group being validated.
	 * @param   ?Registry          $input    All values after native filtering.
	 * @param   ?Form              $form     The original validation form.
	 *
	 * @return  bool
	 * @since   6.2.0
	 */
	public function test(\SimpleXMLElement $element, $value, $group = null, ?Registry $input = null, ?Form $form = null)
	{
		if ($form === null || $input === null || self::$callbacks === null || !self::$callbacks->contains($form))
		{
			return false;
		}
		[$callback, $selectedGroup, $field] = self::$callbacks[$form];
		if ((string) $element['name'] !== $field || (string) $group !== (string) $selectedGroup)
		{
			return false;
		}
		// A plugin may edit the form, but cannot move this rule after a selected field.
		foreach ($element->xpath('preceding::field[not(ancestor::field)]') ?: [] as $previous)
		{
			$groups = $previous->xpath('ancestor::fields[@name]/@name');
			$previousGroup = implode('.', array_map('strval', $groups ?: []));
			if ($selectedGroup === null || $selectedGroup === '' || $previousGroup === $selectedGroup
				|| strpos($previousGroup, $selectedGroup . '.') === 0)
			{
				return false;
			}
		}
		return $callback($input->toArray());
	}
}
