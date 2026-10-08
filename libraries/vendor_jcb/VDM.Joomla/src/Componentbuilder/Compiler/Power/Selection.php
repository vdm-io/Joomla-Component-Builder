<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    29th September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Power;


use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Pure selection decisions shared by compilation and read-only discovery.
 * 
 * This service neither loads definitions nor executes custom code. It preserves
 * stored selector values so callers can report malformed references separately.
 * 
 * @since  6.2.0
 */
final class Selection
{
	/**
	 * Permission utility emitted by helper templates and admin-view builders.
	 *
	 * @var    string
	 * @since  6.2.0
	 */
	private const ACTIONS_GUID = '7d95ce74-53dc-4672-bd8a-3b71cdacabea';

	/**
	 * Return utilities whose tokens are emitted after the initializer phase.
	 *
	 * The modern admin helper always emits Actions. Selected admin views also
	 * emit it through the shared batch builders on every generated target.
	 * These are ordinary tokens, so the component Power switch still applies.
	 *
	 * @param   int   $target     Generated Joomla major, not the installed host.
	 * @param   bool  $adminView  Whether a selected admin view is being compiled.
	 *
	 * @return  array<string, int>
	 * @since   6.2.0
	 */
	public function lateUtilityPowers(int $target, bool $adminView = false): array
	{
		return $target >= 4 || $adminView ? [self::ACTIONS_GUID => 0] : [];
	}

	/**
	 * Build the late permission utility token without loading it prematurely.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	public static function permittedActionsToken(): string
	{
		return 'Super___' . str_replace('-', '_', self::ACTIONS_GUID) . '___Power';
	}

	/**
	 * Enumerate the relationship selectors consumed by Compiler Power.
	 *
	 * Legacy method/property selection columns are not read by the compiler.
	 * Inheritance selectors are narrowed further by inheritanceField.
	 *
	 * @return  list<string>
	 * @since   6.2.0
	 */
	public function relationshipFields(): array
	{
		return ['load_selection|load', 'use_selection|use', 'implements', 'extends', 'extendsinterfaces'];
	}

	/**
	 * Return the compiler initializer's required utility roots in build order.
	 *
	 * Each entry is forced independently of the component's Power switch.
	 *
	 * @return  array<string, int>
	 * @since   6.2.0
	 */
	public function utilityPowers(): array
	{
		return [
			'1f28cb53-60d9-4db1-b517-3c7dc6b429ef' => 1,
			'0a59c65c-9daf-4bc9-baf4-e063ff9e6a8a' => 1,
			'640b5352-fb09-425f-a26e-cd44eda03f15' => 1,
			'91004529-94a9-4590-b842-e7c6b624ecf5' => 1,
			'db87c339-5bb6-4291-a7ef-2c48ea1b06bc' => 1,
			'4b225c51-d293-48e4-b3f6-5136cf5c3f18' => 1,
			'1198aecf-84c6-45d2-aea8-d531aa4afdfa' => 1,
		];
	}

	/**
	 * Enumerate Power fields processed by the compiler custom-code pipeline.
	 *
	 * Namespace is placeholder-only; inactive custom branches are filtered by
	 * codeEnabled. This includes varchar selectors omitted by text-column scans.
	 *
	 * @return  list<string>
	 * @since   6.2.0
	 */
	public function codeFields(): array
	{
		return [
			'name', 'description', 'head', 'main_class_code', 'licensing_template',
			'extends_custom', 'implements_custom', 'extendsinterfaces_custom',
		];
	}

	/**
	 * Apply the compiler's global enablement and explicit forced-load switch.
	 *
	 * @param   bool|int  $enabled  Effective compiler Power option.
	 * @param   int       $force    Explicit build override.
	 *
	 * @return  bool
	 * @since   6.2.0
	 */
	public function enabled(bool|int $enabled, int $force = 0): bool
	{
		return $enabled || $force === 1;
	}

	/**
	 * Read the core compiler's literal custom-code and template/layout selectors.
	 *
	 * Argument suffixes and the core reader's selector order are preserved.
	 * Read-only callers resolve the selectors through their own bounded loader.
	 *
	 * @param   string  $code  Effective code being processed.
	 *
	 * @return  array{custom_code: array, template: array, layout: array}
	 * @since   6.2.0
	 */
	public function codeReferences(string $code): array
	{
		$templates = array_merge(
			GetHelper::allBetween($code, "\$this->loadTemplate('", "')") ?? [],
			GetHelper::allBetween($code, '$this->loadTemplate("', '")') ?? []
		);
		$layouts = [];

		foreach (['LayoutHelper', 'Joomla__' . '_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power'] as $class)
		{
			$layouts = array_merge(
				$layouts,
				GetHelper::allBetween($code, $class . "::render('", "',") ?? [],
				GetHelper::allBetween($code, $class . '::render("', '",') ?? []
			);
		}

		return [
			'custom_code' => GetHelper::allBetween($code, '[CUSTOMCODE=', ']') ?? [],
			'template' => $templates,
			'layout' => $layouts,
		];
	}

	/**
	 * Decode a compiler selection without changing keys or sentinel values.
	 *
	 * Valid JSON scalars are retained to preserve the compiler's existing input
	 * contract; relationship consumers separately require the expected shape.
	 *
	 * @param   mixed  $value  The stored JSON selection.
	 *
	 * @return  mixed  Decoded JSON or null for absent or malformed input.
	 * @since   6.2.0
	 */
	public function decode(mixed $value): mixed
	{
		return JsonHelper::check($value) ? json_decode((string) $value, true) : null;
	}

	/**
	 * Select the inheritance field that the compiler consumes for this type.
	 *
	 * @param   string  $type  The Power declaration type.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	public function inheritanceField(string $type): string
	{
		return $type === 'interface' ? 'extendsinterfaces' : 'extends';
	}

	/**
	 * Determine whether the compiler processes a Power code field.
	 *
	 * Loose selector comparisons deliberately preserve database numeric-string
	 * behavior. Both serialized records and already decoded compiler selections
	 * are accepted, without evaluating their code.
	 *
	 * @param   array   $record  The Power definition.
	 * @param   string  $field   The code field to inspect.
	 *
	 * @return  bool
	 * @since   6.2.0
	 */
	public function codeEnabled(array $record, string $field): bool
	{
		switch ($field)
		{
			case 'head':
				return ($record['add_head'] ?? 0) == 1;
			case 'licensing_template':
				return ($record['add_licensing_template'] ?? 0) == 2
					&& StringHelper::check($record[$field] ?? null);
			case 'extends_custom':
				return $this->inheritanceField((string) ($record['type'] ?? '')) === 'extends'
					&& ($record['extends'] ?? '') == -1
					&& StringHelper::check($record[$field] ?? null);
			case 'implements_custom':
				return $this->customSelected($record['implements'] ?? null)
					&& StringHelper::check($record[$field] ?? null);
			case 'extendsinterfaces_custom':
				return $this->inheritanceField((string) ($record['type'] ?? '')) === 'extendsinterfaces'
					&& $this->customSelected($record['extendsinterfaces'] ?? null)
					&& StringHelper::check($record[$field] ?? null);
			default:
				return true;
		}
	}

	/**
	 * Check the compiler's custom inheritance/interface sentinel.
	 *
	 * @param   mixed  $selection  Serialized or normalized selection.
	 *
	 * @return  bool
	 * @since   6.2.0
	 */
	private function customSelected(mixed $selection): bool
	{
		$values = is_array($selection) ? $selection : $this->decode($selection);

		return is_array($values) && in_array(-1, $values, false);
	}
}

