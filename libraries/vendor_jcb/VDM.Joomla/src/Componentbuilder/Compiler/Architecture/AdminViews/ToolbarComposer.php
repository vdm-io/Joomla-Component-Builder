<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;


/**
 * Toolbar Composer Class
 * 
 * @since 5.1.4
 */
final class ToolbarComposer
{
	/**
	 * Build the complete toolbar output dynamically, replacing placeholders
	 * where found, or appending where missing, ensuring button order
	 * and proper wrapping in conditional blocks.
	 *
	 * @param  string  $overrideToolbar   The override toolbar code provided by the user.
	 * @param  string  $dynamicButtons    The rendered dynamic buttons code.
	 * @param  string  $customButtons     The rendered custom buttons code.
	 * @param  string  $functionButtons   The rendered function buttons code.
	 *
	 * @return string  The complete toolbar code.
	 * @since  5.1.4
	 */
	public function build(string $overrideToolbar, string $dynamicButtons, string $customButtons, string $functionButtons): string
	{
		$toolbar = $overrideToolbar;

		$placeholders = [
			'dynamic'       => Placefix::_('DYNAMIC_BUTTONS'),
			'custom'        => Placefix::_('CUSTOM_BUTTONS'),
			'function'      => Placefix::_('FUNCTION_BUTTONS'),
			'dynamicCustom' => Placefix::_('DYNAMIC_CUSTOM_BUTTONS'),
		];

		$found = $this->detectPlaceholders($toolbar, $placeholders);

		// --- Replacement phase (placeholders replaced exactly; no whitespace changes) ---
		if ($found['dynamicCustom'])
		{
			$toolbar = str_replace(
				$placeholders['dynamicCustom'],
				$this->combineDynamicAndCustom($dynamicButtons, $customButtons),
				$toolbar
			);
		}
		else
		{
			$toolbar = $this->replaceIfFound($toolbar, $placeholders['dynamic'], $dynamicButtons, $found['dynamic']);
			$toolbar = $this->replaceIfFound($toolbar, $placeholders['custom'], $customButtons, $found['custom']);
		}

		$toolbar = $this->replaceIfFound($toolbar, $placeholders['function'], $functionButtons, $found['function']);

		// --- Append missing sections in correct order: Dynamic → Custom → Function ---
		$toolbar = $this->appendMissingSections(
			$toolbar,
			$found,
			$dynamicButtons,
			$customButtons,
			$functionButtons
		);

		return $toolbar;
	}

	/**
	 * Combine dynamic and custom buttons inside an if-wrapper block.
	 *
	 * @param  string  $dynamicButtons  The dynamic buttons.
	 * @param  string  $customButtons   The custom buttons.
	 * @param  bool    $wrapBoth        If true, applies if-wrapper to both (default true).
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function combineDynamicAndCustom(string $dynamicButtons, string $customButtons, bool $wrapBoth = true): string
	{
		$hasDynamic = strlen(trim($dynamicButtons)) > 0;
		$hasCustom  = strlen(trim($customButtons)) > 0;

		if (!$hasDynamic && !$hasCustom)
		{
			return '';
		}

		$content = $dynamicButtons . $customButtons;

		if ($wrapBoth)
		{
			return $this->wrapInIf($content, 'dynamic+custom');
		}

		return $content;
	}

	/**
	 * Wrap given code block in the "if (!\$this->isEmptyState)" condition.
	 *
	 * @param  string  $content  The code block to wrap.
	 * @param  string  $label    The comment label.
	 *
	 * @return string  The wrapped block.
	 * @since  5.1.4
	 */
	protected function wrapInIf(string $content, string $label): string
	{
		return PHP_EOL
			. Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Only load {$label} if there are items" . PHP_EOL
			. Indent::_(2) . "if (!\$this->isEmptyState)" . PHP_EOL
			. Indent::_(2) . '{' . PHP_EOL
			. $content
			. PHP_EOL . Indent::_(2) . '}' . PHP_EOL;
	}

	/**
	 * Detect which placeholders exist in the override toolbar.
	 *
	 * @param  string  $toolbar        The override toolbar string.
	 * @param  array   $placeholders   List of placeholders to detect.
	 *
	 * @return array   Boolean map of found placeholders.
	 * @since  5.1.4
	 */
	protected function detectPlaceholders(string $toolbar, array $placeholders): array
	{
		$result = [];
		foreach ($placeholders as $key => $token)
		{
			$result[$key] = strpos($toolbar, $token) !== false;
		}
		return $result;
	}

	/**
	 * Replace placeholder in toolbar if it exists.
	 *
	 * @param  string  $toolbar       The toolbar string.
	 * @param  string  $placeholder   The placeholder token.
	 * @param  string  $replacement   The replacement content.
	 * @param  bool    $found         Whether placeholder exists.
	 *
	 * @return string  Updated toolbar string.
	 * @since  5.1.4
	 */
	protected function replaceIfFound(string $toolbar, string $placeholder, string $replacement, bool $found): string
	{
		if (!$found)
		{
			return $toolbar;
		}

		// Do not trim actual output; only clear placeholder if content is empty.
		if (strlen(trim($replacement)) === 0)
		{
			$replacement = '';
		}

		return str_replace($placeholder, $replacement, $toolbar);
	}

	/**
	 * Append missing button blocks in correct order (Dynamic → Custom → Function).
	 * Dynamic & Custom are always siblings and always wrapped when auto-appended.
	 * If only one sibling was placed via placeholder, the missing one is wrapped alone.
	 *
	 * @param  string  $toolbar          The current toolbar code.
	 * @param  array   $found            Map of detected placeholders.
	 * @param  string  $dynamicButtons   The dynamic buttons code.
	 * @param  string  $customButtons    The custom buttons code.
	 * @param  string  $functionButtons  The function buttons code.
	 *
	 * @return string  Updated toolbar code.
	 * @since  5.1.4
	 */
	protected function appendMissingSections(
		string $toolbar,
		array $found,
		string $dynamicButtons,
		string $customButtons,
		string $functionButtons
	): string
	{
		$hasDynamic  = strlen(trim($dynamicButtons)) > 0;
		$hasCustom   = strlen(trim($customButtons)) > 0;
		$hasFunction = strlen(trim($functionButtons)) > 0;

		// Handle Dynamic + Custom pairing (must be before Function)
		if (!$found['dynamicCustom'])
		{
			if (!$found['dynamic'] && !$found['custom'])
			{
				// Neither placeholder used -> add both together, wrapped
				if ($hasDynamic || $hasCustom)
				{
					$toolbar .= $this->wrapInIf($dynamicButtons . $customButtons, 'dynamic+custom');
				}
			}
			elseif ($found['custom'] && !$found['dynamic'] && $hasDynamic)
			{
				// Custom was placed via placeholder; add missing Dynamic (wrapped alone)
				$toolbar .= $this->wrapInIf($dynamicButtons, 'dynamic');
			}
			elseif ($found['dynamic'] && !$found['custom'] && $hasCustom)
			{
				// Dynamic was placed via placeholder; add missing Custom (wrapped alone)
				$toolbar .= $this->wrapInIf($customButtons, 'custom');
			}
		}

		// Function buttons must always be last
		if (!$found['function'] && $hasFunction)
		{
			$toolbar .= PHP_EOL . $functionButtons;
		}

		return $toolbar;
	}
}

