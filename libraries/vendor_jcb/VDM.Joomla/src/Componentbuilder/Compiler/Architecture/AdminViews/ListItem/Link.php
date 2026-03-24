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


use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * List Item Link Class
 * 
 * @since 5.1.5
 */
final class Link
{
	/**
	 * The Category Class.
	 *
	 * @var   Category
	 * @since 5.1.5
	 */
	protected Category $category;

	/**
	 * Constructor.
	 *
	 * @param   Category  $category  The Category Class.
	 *
	 * @since   5.1.5
	 */
	public function __construct(Category $category)
	{
		$this->category = $category;
	}

	/**
	 * Get the list item link.
	 *
	 * @param   array        $item             The item array.
	 * @param   bool         &$checkoutTriger  The checkout trigger switch.
	 * @param   string       $nameSingleCode   The single view code name.
	 * @param   string       $nameListCode     The list view code name.
	 * @param   string|null  $ref              The link referral string.
	 *
	 * @return  string  The single item link.
	 * @since   5.1.5
	 */
	public function get(
		array $item,
		bool &$checkoutTriger,
		string $nameSingleCode,
		string $nameListCode,
		?string $ref = null
	): string
	{
		[$ref, $referal] = $this->resolveReferral($ref);

		if ($this->isCategoryLink($item))
		{
			return $this->buildCategoryLink($item, $nameListCode);
		}

		if ($this->isDirectUserLink($item))
		{
			return $this->buildUserLink($item['code']);
		}

		if ($this->isCustomNonUserLink($item))
		{
			return $this->buildCustomLink($item, $ref);
		}

		if ($this->isCustomUserLink($item))
		{
			return $this->buildUserLink($item['id_code']);
		}

		$checkoutTriger = true;

		return $this->buildDefaultItemLink($referal);
	}

	/**
	 * Resolve the referral values.
	 *
	 * @param   string|null  $ref  The incoming referral string.
	 *
	 * @return  array{0:string,1:string}  The resolved ref and referal values.
	 * @since   5.1.5
	 */
	protected function resolveReferral(?string $ref): array
	{
		$referal = '';

		if (!$ref)
		{
			$ref = '&return=<?php echo $this->return_here; ?>';
		}
		else
		{
			$referal = $ref;
		}

		return [$ref, $referal];
	}

	/**
	 * Check if the item should link to a category edit page.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isCategoryLink(array $item): bool
	{
		return isset($item['type'], $item['title'], $item['code'])
			&& $item['type'] === 'category'
			&& !$item['title'];
	}

	/**
	 * Build the category edit link.
	 *
	 * @param   array   $item          The item array.
	 * @param   string  $nameListCode  The list view code name.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function buildCategoryLink(array $item, string $nameListCode): string
	{
		return 'index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->'
			. $item['code'] . '; ?>&extension='
			. $this->category->get("{$nameListCode}.extension", 'error');
	}

	/**
	 * Check if the item should link directly to a user edit page.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isDirectUserLink(array $item): bool
	{
		return isset($item['type'], $item['title'], $item['code'])
			&& $item['type'] === 'user'
			&& !$item['title'];
	}

	/**
	 * Check if the item should link to a custom non-user target.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isCustomNonUserLink(array $item): bool
	{
		return isset($item['custom'], $item['title'], $item['id_code'])
			&& ArrayHelper::check($item['custom'])
			&& $item['custom']['extends'] != 'user'
			&& !$item['title'];
	}

	/**
	 * Check if the item should link to a custom user target.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  bool
	 * @since   5.1.5
	 */
	protected function isCustomUserLink(array $item): bool
	{
		return isset($item['custom'], $item['title'], $item['id_code'])
			&& ArrayHelper::check($item['custom'])
			&& $item['custom']['extends'] === 'user'
			&& !$item['title'];
	}

	/**
	 * Build the user edit link.
	 *
	 * @param   string  $code  The item code field.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function buildUserLink(string $code): string
	{
		return 'index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'
			. $code . ' ?>';
	}

	/**
	 * Build the custom item edit link.
	 *
	 * @param   array   $item  The item array.
	 * @param   string  $ref   The resolved referral string.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function buildCustomLink(array $item, string $ref): string
	{
		$idField = $this->getCustomLinkIdField($item);

		return 'index.php?option=' . $item['custom']['component'] . '&view='
			. $item['custom']['views'] . '&task=' . $item['custom']['view']
			. '.edit&id=<?php echo $item->' . $idField . '; ?>'
			. $ref;
	}

	/**
	 * Get the ID field to use for a custom link.
	 *
	 * @param   array  $item  The item array.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function getCustomLinkIdField(array $item): string
	{
		if (isset($item['custom']['id']) && $item['custom']['id'] !== 'id')
		{
			return $item['id_code'] . '_id';
		}

		return $item['id_code'];
	}

	/**
	 * Build the default item edit link.
	 *
	 * @param   string  $referal  The referral string for linked tab/view handling.
	 *
	 * @return  string
	 * @since   5.1.5
	 */
	protected function buildDefaultItemLink(string $referal): string
	{
		return '<?php echo $edit; ?>&id=<?php echo $item->id; ?>' . $referal;
	}
}

