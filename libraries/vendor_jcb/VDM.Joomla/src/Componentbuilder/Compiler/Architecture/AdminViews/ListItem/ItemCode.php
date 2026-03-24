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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SelectionTranslation;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DoNotEscape;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * List Item Item Code Class
 * 
 * @since 5.1.5
 */
final class ItemCode
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.5
	 */
	protected Config $config;

	/**
	 * The SelectionTranslation Class.
	 *
	 * @var   SelectionTranslation
	 * @since 5.1.5
	 */
	protected SelectionTranslation $selectiontranslation;

	/**
	 * The DoNotEscape Class.
	 *
	 * @var   DoNotEscape
	 * @since 5.1.5
	 */
	protected DoNotEscape $donotescape;

	/**
	 * Constructor.
	 *
	 * @param   Config                 $config                 The Config Class.
	 * @param   SelectionTranslation   $selectiontranslation   The SelectionTranslation Class.
	 * @param   DoNotEscape            $donotescape            The DoNotEscape Class.
	 *
	 * @since   5.1.5
	 */
	public function __construct(
		Config $config,
		SelectionTranslation $selectiontranslation,
		DoNotEscape $donotescape
	) {
		$this->config = $config;
		$this->selectiontranslation = $selectiontranslation;
		$this->donotescape = $donotescape;
	}

	/**
	 * Get the list item code value.
	 *
	 * @param   array   $item           The item array.
	 * @param   string  $nameListCode   The list view code name.
	 * @param   bool    $doNotEscape    The do not escape global switch.
	 * @param   string  $classPointer   The class pointer.
	 *
	 * @return  string  The single item code string.
	 * @since   5.1.5
	 */
	public function get(
		array &$item,
		string $nameListCode,
		bool $doNotEscape,
		string $classPointer = '$this->'
	): string {
		$this->prepareCustomItemCode($item);

		$extendsField = $item['custom']['extends'] ?? '';
		$extendsText = $item['custom']['text'] ?? '';

		if ($this->isCategoryWithoutTitle($item))
		{
			return $this->getCategoryTitleCode($classPointer);
		}

		if ($this->isDirectUserType($item))
		{
			return $this->getUserNameCode($item['code']);
		}

		if ($this->isCustomUserById($item, $extendsField))
		{
			return $this->getUserNameCode($item['id_code']);
		}

		if ($this->hasTranslatedSelection($nameListCode, $item['code']))
		{
			return $this->getTranslatedSelectionCode($item['code']);
		}

		if ($this->isCustomUserField($item, $extendsField, $extendsText))
		{
			return $this->getUserNameCode($item['code']);
		}

		if (
			$doNotEscape
			&& $this->shouldNotEscapeField($nameListCode, $item['code'])
		) {
			return $this->getRawItemCode($item['code']);
		}

		return $this->getEscapedItemCode($item['code'], $classPointer);
	}

	/**
	 * Prepare the item code for custom table values.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  void
	 * @since   5.1.5
	 */
	protected function prepareCustomItemCode(array &$item): void
	{
		if (
			isset($item['custom'])
			&& ArrayHelper::check($item['custom'])
			&& isset($item['custom']['table'])
			&& StringHelper::check($item['custom']['table'])
		) {
			$item['id_code'] = $item['code'];

			if (!(bool) $item['multiple'])
			{
				$item['code'] = $item['code'] . '_' . $item['custom']['text'];
			}
		}
	}

	/**
	 * Check if the item is a category without a title field.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isCategoryWithoutTitle(array $item): bool
	{
		return $item['type'] === 'category' && !$item['title'];
	}

	/**
	 * Check if the item is a direct user field type.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isDirectUserType(array $item): bool
	{
		return $item['type'] === 'user';
	}

	/**
	 * Check if the item is a custom user relation resolved by ID code.
	 *
	 * @param   array   $item          The item array.
	 * @param   string  $extendsField  The custom extends field value.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isCustomUserById(array $item, string $extendsField): bool
	{
		return isset($item['custom'])
			&& ArrayHelper::check($item['custom'])
			&& $extendsField === 'user'
			&& isset($item['id_code']);
	}

	/**
	 * Check if the item uses a translated selection value.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 * @param   string  $code          The field code.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function hasTranslatedSelection(string $nameListCode, string $code): bool
	{
		return $this->selectiontranslation->exists($nameListCode . '.' . $code);
	}

	/**
	 * Check if the item resolves to a custom user field.
	 *
	 * @param   array   $item          The item array.
	 * @param   string  $extendsField  The custom extends field value.
	 * @param   string  $extendsText   The custom text value.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isCustomUserField(
		array $item,
		string $extendsField,
		string $extendsText
	): bool {
		return isset($item['custom'])
			&& ArrayHelper::check($item['custom'])
			&& ($extendsText === 'user' || $extendsField === 'user');
	}

	/**
	 * Check if the field should not be escaped.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 * @param   string  $code          The field code.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function shouldNotEscapeField(string $nameListCode, string $code): bool
	{
		return $this->donotescape->exists($nameListCode . '.' . $code);
	}

	/**
	 * Get the category title code string.
	 *
	 * @param   string  $classPointer  The class pointer.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function getCategoryTitleCode(string $classPointer): string
	{
		return $classPointer . 'escape($item->category_title)';
	}

	/**
	 * Get the translated selection code string.
	 *
	 * @param   string  $code  The field code.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function getTranslatedSelectionCode(string $code): string
	{
		return 'Joomla__'
			. '_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_($item->'
			. $code . ')';
	}

	/**
	 * Get the raw item code string.
	 *
	 * @param   string  $code  The field code.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function getRawItemCode(string $code): string
	{
		return '$item->' . $code;
	}

	/**
	 * Get the escaped item code string.
	 *
	 * @param   string  $code          The field code.
	 * @param   string  $classPointer  The class pointer.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function getEscapedItemCode(string $code, string $classPointer): string
	{
		return $classPointer . 'escape($item->' . $code . ')';
	}

	/**
	 * Get the user name lookup code string.
	 *
	 * @param   string  $code  The field code.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function getUserNameCode(string $code): string
	{
		if ((int) $this->config->get('joomla_version', 3) === 3)
		{
			return 'Joomla__'
				. '_39403062_84fb_46e0_bac4_0023f766e827___Power::getUser((int)$item->'
				. $code . ')->name';
		}

		return 'Joomla__'
			. '_39403062_84fb_46e0_bac4_0023f766e827___Power::getContainer()->'
			. 'get(Joomla__'
			. '_c2980d12_c3ef_4e23_b4a2_e6af1f5900a9___Power::class)->'
			. 'loadUserById((int) ($item->' . $code . ' ?? 0))->name';
	}
}

