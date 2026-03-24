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
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * List Item Link Authority Class
 * 
 * @since 5.1.5
 */
final class LinkAuthority
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.5
	 */
	protected Config $config;

	/**
	 * The CategoryCode Class.
	 *
	 * @var   CategoryCode
	 * @since 5.1.5
	 */
	protected CategoryCode $categorycode;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 5.1.5
	 */
	protected Permission $permission;

	/**
	 * Constructor.
	 *
	 * @param   Config         $config         The Config Class.
	 * @param   CategoryCode   $categorycode   The CategoryCode Class.
	 * @param   Permission     $permission     The Permission Class.
	 *
	 * @since   5.1.5
	 */
	public function __construct(
		Config $config,
		CategoryCode $categorycode,
		Permission $permission
	) {
		$this->config = $config;
		$this->categorycode = $categorycode;
		$this->permission = $permission;
	}

	/**
	 * Get the list item link authority.
	 *
	 * @param   array   $item            The item array.
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $classPointer    The class pointer.
	 * @param   string  $user            The user code name.
	 *
	 * @return  string  The single item link authority string.
	 * @since   5.1.5
	 */
	public function get(
		array $item,
		string $nameSingleCode,
		string $nameListCode,
		string $classPointer = '$this->',
		string $user = '$this->user'
	): string {
		$isModal = $this->getModalAuthorityPrefix($classPointer);

		if ($this->isCategoryItemWithoutTitle($item))
		{
			return $this->getCategoryItemAuthority(
				$item,
				$nameSingleCode,
				$isModal,
				$user
			);
		}

		if ($this->isUserItemWithoutTitle($item))
		{
			return $this->getUserItemAuthority($isModal, $user);
		}

		if ($this->isCustomNonUserItemWithoutTitle($item))
		{
			return $this->getCustomItemAuthority($item, $isModal, $user);
		}

		if ($this->isCustomUserItemWithoutTitle($item))
		{
			return $this->getUserItemAuthority($isModal, $user);
		}

		return $this->getDefaultItemAuthority($nameSingleCode, $isModal);
	}

	/**
	 * Get the modal authority prefix.
	 *
	 * @param   string  $classPointer  The class pointer.
	 *
	 * @return  string  The modal authority prefix or an empty string.
	 * @since   5.1.5
	 */
	protected function getModalAuthorityPrefix(string $classPointer): string
	{
		if ($this->config->get('joomla_version', 3) === 3)
		{
			return '';
		}

		return "!{$classPointer}isModal && ";
	}

	/**
	 * Check if the item is a category item without a title.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool  True if the item is a category item without a title.
	 * @since   5.1.5
	 */
	protected function isCategoryItemWithoutTitle(array $item): bool
	{
		return isset($item['type'], $item['title'])
			&& $item['type'] === 'category'
			&& !$item['title'];
	}

	/**
	 * Check if the item is a user item without a title.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool  True if the item is a user item without a title.
	 * @since   5.1.5
	 */
	protected function isUserItemWithoutTitle(array $item): bool
	{
		return isset($item['type'], $item['title'])
			&& $item['type'] === 'user'
			&& !$item['title'];
	}

	/**
	 * Check if the item is a custom non-user item without a title.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool  True if the item is a custom non-user item without a title.
	 * @since   5.1.5
	 */
	protected function isCustomNonUserItemWithoutTitle(array $item): bool
	{
		return $this->hasValidCustomItem($item)
			&& $item['custom']['extends'] !== 'user';
	}

	/**
	 * Check if the item is a custom user item without a title.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool  True if the item is a custom user item without a title.
	 * @since   5.1.5
	 */
	protected function isCustomUserItemWithoutTitle(array $item): bool
	{
		return $this->hasValidCustomItem($item)
			&& $item['custom']['extends'] === 'user';
	}

	/**
	 * Check if the item contains a valid custom definition.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool  True if the item contains a valid custom definition.
	 * @since   5.1.5
	 */
	protected function hasValidCustomItem(array $item): bool
	{
		return isset($item['custom'], $item['title'], $item['id_code'])
			&& ArrayHelper::check($item['custom'])
			&& !$item['title'];
	}

	/**
	 * Get the category item authority string.
	 *
	 * @param   array   $item            The item array.
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $isModal         The modal authority prefix.
	 * @param   string  $user            The user code name.
	 *
	 * @return  string  The category item authority string.
	 * @since   5.1.5
	 */
	protected function getCategoryItemAuthority(
		array $item,
		string $nameSingleCode,
		string $isModal,
		string $user
	): string {
		$otherView = $this->categorycode->getString(
			"{$nameSingleCode}.view",
			'error'
		);

		return $isModal . $user . "->authorise('core.edit', 'com_"
			. $this->config->component_code_name . "."
			. $otherView
			. ".category.' . (int) (\$item->" . $item['code'] . " ?? 0))";
	}

	/**
	 * Get the user item authority string.
	 *
	 * @param   string  $isModal  The modal authority prefix.
	 * @param   string  $user     The user code name.
	 *
	 * @return  string  The user item authority string.
	 * @since   5.1.5
	 */
	protected function getUserItemAuthority(string $isModal, string $user): string
	{
		return $isModal . $user . "->authorise('core.edit', 'com_users')";
	}

	/**
	 * Get the custom item authority string.
	 *
	 * @param   array   $item     The item array.
	 * @param   string  $isModal  The modal authority prefix.
	 * @param   string  $user     The user code name.
	 *
	 * @return  string  The custom item authority string.
	 * @since   5.1.5
	 */
	protected function getCustomItemAuthority(
		array $item,
		string $isModal,
		string $user
	): string {
		$view = $item['custom']['view'];
		$action = $this->permission->getAction($view, 'core.edit');
		$idCode = $this->getCustomItemIdCode($item);

		return $isModal . $user . "->authorise('"
			. $action . "', 'com_" . $this->config->component_code_name . "."
			. $view . ".' . (int) (\$item->" . $idCode . " ?? 0))";
	}

	/**
	 * Get the custom item ID code.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  string  The custom item ID code.
	 * @since   5.1.5
	 */
	protected function getCustomItemIdCode(array $item): string
	{
		if (isset($item['custom']['id']) && $item['custom']['id'] !== 'id')
		{
			return $item['id_code'] . '_id';
		}

		return $item['id_code'];
	}

	/**
	 * Get the default item authority string.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $isModal         The modal authority prefix.
	 *
	 * @return  string  The default item authority string.
	 * @since   5.1.5
	 */
	protected function getDefaultItemAuthority(
		string $nameSingleCode,
		string $isModal
	): string {
		return $isModal . "\$canDo->get('"
			. $this->permission->getGlobal($nameSingleCode, 'core.edit')
			. "')";
	}
}

