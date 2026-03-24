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


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldRelations;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListJoin;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * List Item Builder Class
 * 
 * @since 5.1.5
 */
final class ListItemBuilder
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.5
	 */
	protected Placeholder $placeholder;

	/**
	 * The ListItem Class.
	 *
	 * @var   ListItem
	 * @since 5.1.5
	 */
	protected ListItem $listitem;

	/**
	 * The FieldRelations Class.
	 *
	 * @var   FieldRelations
	 * @since 5.1.5
	 */
	protected FieldRelations $fieldrelations;

	/**
	 * The ListJoin Class.
	 *
	 * @var   ListJoin
	 * @since 5.1.5
	 */
	protected ListJoin $listjoin;

	/**
	 * Constructor.
	 *
	 * @param Placeholder      $placeholder      The Placeholder Class.
	 * @param ListItem         $listitem         The ListItem Class.
	 * @param FieldRelations   $fieldrelations   The FieldRelations Class.
	 * @param ListJoin         $listjoin         The ListJoin Class.
	 *
	 * @since 5.1.5
	 */
	public function __construct(Placeholder $placeholder, ListItem $listitem,
		FieldRelations $fieldrelations, ListJoin $listjoin)
	{
		$this->placeholder = $placeholder;
		$this->listitem = $listitem;
		$this->fieldrelations = $fieldrelations;
		$this->listjoin = $listjoin;
	}

	/**
	 * Get the list item dynamic row.
	 *
	 * @param  array    $item            The item array.
	 * @param  string   $nameSingleCode  The single view code name.
	 * @param  string   $nameListCode    The list view code name.
	 * @param  string   $itemClass       The table row default class.
	 * @param  bool     $doNotEscape     The do not escape global switch.
	 * @param  bool     $class           The div class adding switch.
	 * @param  ?string  $ref             The link referral string.
	 * @param  string   $classPointer    The class pointer (this or displaydata).
	 * @param  string   $user            The user code name.
	 * @param  ?string  $refview         The override of the referral view code name.
	 *
	 * @return string  The completed item value for the table row.
	 * @since  5.1.2
	 */
	public function get(
		array $item,
		string $nameSingleCode,
		string $nameListCode,
		string &$itemClass,
		bool $doNotEscape,
		bool $class = true,
		?string $ref = null,
		string $classPointer = '$this->',
		string $user = '$this->user',
		?string $refview = null
	): string
	{
		$fieldRelations = $this->getListItemFieldRelations($nameListCode, $item);

		if ($fieldRelations === null)
		{
			return $this->listitem->get(
				$item,
				$nameSingleCode,
				$nameListCode,
				$itemClass,
				$doNotEscape,
				$class,
				$ref,
				$classPointer,
				$user,
				$refview
			);
		}

		$fieldListItem = $this->listitem->get(
			$item,
			$nameSingleCode,
			$nameListCode,
			$itemClass,
			$doNotEscape,
			false,
			$ref,
			$classPointer,
			$user,
			$refview
		);

		$fieldPlaceholders = [];
		$fieldArray = [];

		$id = (int) ($item['id'] ?? 0);
		$guid = (string) ($item['guid'] ?? 'error');

		$this->addFieldOutputPlaceholders(
			$fieldPlaceholders,
			$fieldArray,
			$fieldListItem,
			$id,
			$guid
		);

		$this->addItemCodePlaceholders(
			$item,
			$id,
			$guid,
			$fieldPlaceholders
		);

		$this->addJoinListItemFieldData(
			$fieldRelations,
			$nameSingleCode,
			$nameListCode,
			$doNotEscape,
			$ref,
			$classPointer,
			$user,
			$refview,
			$fieldPlaceholders,
			$fieldArray
		);

		return $this->renderListItemBuilderOutput(
			$fieldRelations,
			$fieldPlaceholders,
			$fieldArray
		);
	}

	/**
	 * Get the field relation settings for a list item.
	 *
	 * @param  string  $nameListCode  The list view code name.
	 * @param  array   $item          The field item array.
	 *
	 * @return array|null  The field relation settings or null.
	 * @since  5.1.2
	 */
	protected function getListItemFieldRelations(string $nameListCode, array $item): ?array
	{
		$fieldRelations = $this->fieldrelations->get(
			$nameListCode . '.' . (string) $item['guid'] . '.2'
		);

		return is_array($fieldRelations) ? $fieldRelations : null;
	}

	/**
	 * Add rendered field output placeholders.
	 *
	 * @param  array   $fieldPlaceholders  The field placeholders.
	 * @param  array   $fieldArray         The rendered field array.
	 * @param  string  $fieldOutput        The rendered field output.
	 * @param  int     $fieldId            The field ID.
	 * @param  string  $fieldGuid          The field GUID.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function addFieldOutputPlaceholders(
		array &$fieldPlaceholders,
		array &$fieldArray,
		string $fieldOutput,
		int $fieldId,
		string $fieldGuid
	): void
	{
		$fieldPlaceholders['[field=' . $fieldId . ']'] = $fieldOutput;
		$fieldPlaceholders['[field=' . $fieldGuid . ']'] = $fieldOutput;
		$fieldArray[] = trim($fieldOutput);
	}

	/**
	 * Add code name placeholders for an item.
	 *
	 * @param  array   $item               The field item array.
	 * @param  int     $fieldId            The field ID.
	 * @param  string  $fieldGuid          The field GUID.
	 * @param  array   $fieldPlaceholders  The field placeholders.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function addItemCodePlaceholders(
		array $item,
		int $fieldId,
		string $fieldGuid,
		array &$fieldPlaceholders
	): void
	{
		if (
			!isset($item['code'])
			|| !StringHelper::check((string) $item['code'])
		)
		{
			return;
		}

		$codeReference = '$item->' . $item['code'];

		$fieldPlaceholders['$item->{' . $fieldId . '}'] = $codeReference;
		$fieldPlaceholders['$item->{' . $fieldGuid . '}'] = $codeReference;
	}

	/**
	 * Add joined list item field data.
	 *
	 * @param  array    $fieldRelations     The field relation settings.
	 * @param  string   $nameSingleCode     The single view code name.
	 * @param  string   $nameListCode       The list view code name.
	 * @param  bool     $doNotEscape        The do not escape global switch.
	 * @param  ?string  $ref                The link referral string.
	 * @param  string   $classPointer       The class pointer.
	 * @param  string   $user               The user code name.
	 * @param  ?string  $refview            The referral view code name override.
	 * @param  array    $fieldPlaceholders  The field placeholders.
	 * @param  array    $fieldArray         The rendered field array.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function addJoinListItemFieldData(
		array $fieldRelations,
		string $nameSingleCode,
		string $nameListCode,
		bool $doNotEscape,
		?string $ref,
		string $classPointer,
		string $user,
		?string $refview,
		array &$fieldPlaceholders,
		array &$fieldArray
	): void
	{
		if (
			!isset($fieldRelations['joinfields'])
			|| !ArrayHelper::check($fieldRelations['joinfields'])
		)
		{
			return;
		}

		foreach ($fieldRelations['joinfields'] as $join)
		{
			$joinKey = $nameListCode . '.' . (string) $join;
			$joinItem = $this->listjoin->get($joinKey);

			if (!is_array($joinItem))
			{
				continue;
			}

			$blankClass = '';
			$joinId = (int) $this->listjoin->get($joinKey . '.id', 0);

			$joinFieldListItem = $this->listitem->get(
				$joinItem,
				$nameSingleCode,
				$nameListCode,
				$blankClass,
				$doNotEscape,
				false,
				$ref,
				$classPointer,
				$user,
				$refview
			);

			$this->addFieldOutputPlaceholders(
				$fieldPlaceholders,
				$fieldArray,
				$joinFieldListItem,
				$joinId,
				(string) $join
			);

			$this->addItemCodePlaceholders(
				$joinItem,
				$joinId,
				(string) $join,
				$fieldPlaceholders
			);
		}
	}

	/**
	 * Render the final list item builder output.
	 *
	 * @param  array  $fieldRelations     The field relation settings.
	 * @param  array  $fieldPlaceholders  The field placeholders.
	 * @param  array  $fieldArray         The rendered field array.
	 *
	 * @return string  The rendered output.
	 * @since  5.1.2
	 */
	protected function renderListItemBuilderOutput(
		array $fieldRelations,
		array $fieldPlaceholders,
		array $fieldArray
	): string
	{
		if ($this->shouldUseCustomRelationCode($fieldRelations))
		{
			$output = str_replace(
				array_keys($fieldPlaceholders),
				array_values($fieldPlaceholders),
				(string) $fieldRelations['set']
			);

			return $this->wrapListItemBuilderOutput(
				$this->placeholder->update_($output)
			);
		}

		if (
			isset($fieldRelations['set'])
			&& StringHelper::check((string) $fieldRelations['set'])
		)
		{
			return $this->wrapListItemBuilderOutput(
				implode((string) $fieldRelations['set'], $fieldArray)
			);
		}

		return $this->wrapListItemBuilderOutput(
			implode('', $fieldArray)
		);
	}

	/**
	 * Check if the relation should use custom code.
	 *
	 * @param  array  $fieldRelations  The field relation settings.
	 *
	 * @return bool  True if custom relation code should be used.
	 * @since  5.1.2
	 */
	protected function shouldUseCustomRelationCode(array $fieldRelations): bool
	{
		return isset($fieldRelations['join_type'], $fieldRelations['set'])
			&& (int) $fieldRelations['join_type'] === 2
			&& StringHelper::check((string) $fieldRelations['set']);
	}

	/**
	 * Wrap the output in the standard list item builder div.
	 *
	 * @param  string  $output  The output string.
	 *
	 * @return string  The wrapped output.
	 * @since  5.1.2
	 */
	protected function wrapListItemBuilderOutput(string $output): string
	{
		return PHP_EOL . Indent::_(3) . '<div>'
			. $output . PHP_EOL . Indent::_(3) . '</div>';
	}
}

