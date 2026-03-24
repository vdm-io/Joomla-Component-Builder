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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\ItemCode;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\Link;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\LinkAuthority;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\LinkLogic;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * List Item Class
 * 
 * @since 5.1.5
 */
final class ListItem
{
	/**
	 * The ItemCode Class.
	 *
	 * @var   ItemCode
	 * @since 5.1.5
	 */
	protected ItemCode $itemcode;

	/**
	 * The Link Class.
	 *
	 * @var   Link
	 * @since 5.1.5
	 */
	protected Link $link;

	/**
	 * The LinkAuthority Class.
	 *
	 * @var   LinkAuthority
	 * @since 5.1.5
	 */
	protected LinkAuthority $linkauthority;

	/**
	 * The LinkLogic Class.
	 *
	 * @var   LinkLogic
	 * @since 5.1.5
	 */
	protected LinkLogic $linklogic;

	/**
	 * Constructor.
	 *
	 * @param  ItemCode       $itemcode        The ItemCode Class.
	 * @param  Link           $link            The Link Class.
	 * @param  LinkAuthority  $linkauthority   The LinkAuthority Class.
	 * @param  LinkLogic      $linklogic       The LinkLogic Class.
	 *
	 * @since  5.1.5
	 */
	public function __construct(
		ItemCode $itemcode,
		Link $link,
		LinkAuthority $linkauthority,
		LinkLogic $linklogic
	) {
		$this->itemcode = $itemcode;
		$this->link = $link;
		$this->linkauthority = $linkauthority;
		$this->linklogic = $linklogic;
	}

	/**
	 * Get the list item row value.
	 *
	 * @param  array        $item            The item array.
	 * @param  string       $nameSingleCode  The single view code name.
	 * @param  string       $nameListCode    The list view code name.
	 * @param  string       &$itemClass      The table row default class.
	 * @param  bool         $doNotEscape     The do not escape global switch.
	 * @param  bool         $class           The div class adding switch.
	 * @param  string|null  $ref             The link referral string.
	 * @param  string       $classPointer    The class pointer.
	 * @param  string       $user            The user code name.
	 * @param  string|null  $refview         The override of the referral view code name.
	 *
	 * @return string  The single item value for the table row.
	 * @since  5.1.5
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
	): string {
		$itemCode = $this->itemcode->get(
			$item,
			$nameListCode,
			$doNotEscape,
			$classPointer
		);

		if (!$this->shouldRenderLinkedItem($item, $refview))
		{
			return $this->getPlainListItemOutput($itemCode);
		}

		return $this->getLinkedListItemOutput(
			$item,
			$itemCode,
			$nameSingleCode,
			$nameListCode,
			$itemClass,
			$class,
			$ref,
			$classPointer,
			$user
		);
	}

	/**
	 * Check whether the item should be rendered as a linked item.
	 *
	 * @param  array        $item     The item array.
	 * @param  string|null  $refview  The override of the referral view code name.
	 *
	 * @return bool  True if the item should be rendered as a link.
	 * @since  5.1.5
	 */
	protected function shouldRenderLinkedItem(array $item, ?string $refview = null): bool
	{
		if ($this->shouldNotUseDefaultLink($item, $refview))
		{
			return false;
		}

		$extendsField = $this->getCustomExtendsField($item);

		return (!empty($item['link']) || $extendsField === 'user');
	}

	/**
	 * Check whether the default link should not be used.
	 *
	 * @param  array        $item     The item array.
	 * @param  string|null  $refview  The override of the referral view code name.
	 *
	 * @return bool  True if the default link should not be used.
	 * @since  5.1.5
	 */
	protected function shouldNotUseDefaultLink(array $item, ?string $refview = null): bool
	{
		return StringHelper::check($refview)
			&& isset($item['custom'])
			&& isset($item['custom']['view'])
			&& $refview === $item['custom']['view'];
	}

	/**
	 * Get the custom extends field value.
	 *
	 * @param  array  $item  The item array.
	 *
	 * @return string  The custom extends field value.
	 * @since  5.1.5
	 */
	protected function getCustomExtendsField(array $item): string
	{
		return $item['custom']['extends'] ?? '';
	}

	/**
	 * Build the linked list item output.
	 *
	 * @param  array        $item            The item array.
	 * @param  string       $itemCode        The item code string.
	 * @param  string       $nameSingleCode  The single view code name.
	 * @param  string       $nameListCode    The list view code name.
	 * @param  string       &$itemClass      The table row default class.
	 * @param  bool         $class           The div class adding switch.
	 * @param  string|null  $ref             The link referral string.
	 * @param  string       $classPointer    The class pointer.
	 * @param  string       $user            The user code name.
	 *
	 * @return string  The linked list item output.
	 * @since  5.1.5
	 */
	protected function getLinkedListItemOutput(
		array $item,
		string $itemCode,
		string $nameSingleCode,
		string $nameListCode,
		string &$itemClass,
		bool $class = true,
		?string $ref = null,
		string $classPointer = '$this->',
		string $user = '$this->user'
	): string {
		$checkoutTriger = false;
		$itemClass = 'nowrap';

		$itemLink = $this->link->get(
			$item,
			$checkoutTriger,
			$nameSingleCode,
			$nameListCode,
			$ref
		);

		$itemLinkAuthority = $this->linkauthority->get(
			$item,
			$nameSingleCode,
			$nameListCode,
			$classPointer,
			$user
		);

		return $this->linklogic->get(
			$item,
			$itemCode,
			$itemLink,
			$itemLinkAuthority,
			$nameSingleCode,
			$nameListCode,
			$classPointer,
			$checkoutTriger,
			$class
		);
	}

	/**
	 * Build the plain list item output.
	 *
	 * @param  string  $itemCode  The item code string.
	 *
	 * @return string  The plain list item output.
	 * @since  5.1.5
	 */
	protected function getPlainListItemOutput(string $itemCode): string
	{
		return PHP_EOL . Indent::_(3) . "<?php echo " . $itemCode . "; ?>";
	}
}

