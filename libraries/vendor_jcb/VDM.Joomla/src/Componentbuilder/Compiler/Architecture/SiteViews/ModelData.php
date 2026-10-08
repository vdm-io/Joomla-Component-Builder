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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\SiteViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\ComHelperClass\UserPermissionCheckAccess;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\GetItem;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\GetItems;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\ListQuery as DynamicListQuery;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * The site view model data, keyed on the main get type the view was given.
 * 
 * @since 6.1.7
 */
final class ModelData
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Dynamicget GetItem Class.
	 *
	 * @var   GetItem
	 * @since 6.1.7
	 */
	protected GetItem $getitem;

	/**
	 * The Dynamicget GetItems Class.
	 *
	 * @var   GetItems
	 * @since 6.1.7
	 */
	protected GetItems $getitems;

	/**
	 * The Dynamicget ListQuery Class.
	 *
	 * @var   DynamicListQuery
	 * @since 6.1.7
	 */
	protected DynamicListQuery $dynamiclistquery;

	/**
	 * The ComHelperClass UserPermissionCheckAccess Class.
	 *
	 * @var   UserPermissionCheckAccess
	 * @since 6.1.7
	 */
	protected UserPermissionCheckAccess $userpermissioncheckaccess;

	/**
	 * Constructor.
	 *
	 * @param Config                    $config                        The Config Class.
	 * @param Dispenser                 $dispenser                     The Customcode Dispenser Class.
	 * @param ContentMulti              $contentmulti                  The Content Multi Builder Class.
	 * @param GetItem                   $getitem                       The Dynamicget GetItem Class.
	 * @param GetItems                  $getitems                      The Dynamicget GetItems Class.
	 * @param DynamicListQuery          $dynamiclistquery              The Dynamicget ListQuery Class.
	 * @param UserPermissionCheckAccess $userpermissioncheckaccess     The ComHelperClass UserPermissionCheckAccess Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Dispenser $dispenser,
		ContentMulti $contentmulti,
		GetItem $getitem,
		GetItems $getitems,
		DynamicListQuery $dynamiclistquery,
		UserPermissionCheckAccess $userpermissioncheckaccess)
	{
		$this->config = $config;
		$this->dispenser = $dispenser;
		$this->contentmulti = $contentmulti;
		$this->getitem = $getitem;
		$this->getitems = $getitems;
		$this->dynamiclistquery = $dynamiclistquery;
		$this->userpermissioncheckaccess = $userpermissioncheckaccess;
	}

	/**
	 * Set the model data one site view asks for.
	 *
	 * A view built around a single item is given the get-item side of the
	 * model, one built around a list the get-items side. A view of neither
	 * get type is given no model data at all.
	 *
	 * @param   array  $view  The site view the component was given.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function set(array $view): void
	{
		if ($view['settings']->main_get->gettype == 1)
		{
			// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|USER_PERMISSION_CHECK_ACCESS',
				$this->userpermissioncheckaccess->get($view, 1)
			);

			// SITE_BEFORE_GET_ITEM <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_BEFORE_GET_ITEM',
				$this->dispenser->get(
					$this->config->build_target . '_php_before_getitem',
					$view['settings']->code, '', null, true
				)
			);

			// SITE_GET_ITEM <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_GET_ITEM',
				$this->getitem->get(
					$view['settings']->main_get,
					$view['settings']->code, Indent::_(2)
				)
			);

			// SITE_AFTER_GET_ITEM <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_AFTER_GET_ITEM',
				$this->dispenser->get(
					$this->config->build_target . '_php_after_getitem',
					$view['settings']->code, '', null, true
				)
			);
		}
		elseif ($view['settings']->main_get->gettype == 2)
		{
			// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|USER_PERMISSION_CHECK_ACCESS',
				$this->userpermissioncheckaccess->get($view, 2)
			);
			// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_GET_LIST_QUERY',
				$this->dynamiclistquery->get(
					$view['settings']->main_get, $view['settings']->code
				)
			);

			// SITE_BEFORE_GET_ITEMS <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_BEFORE_GET_ITEMS', $this->dispenser->get(
				$this->config->build_target . '_php_before_getitems',
				$view['settings']->code, PHP_EOL, null, true
			));

			// SITE_GET_ITEMS <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_GET_ITEMS',
				$this->getitems->get(
					$view['settings']->main_get, $view['settings']->code
				)
			);

			// SITE_AFTER_GET_ITEMS <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_AFTER_GET_ITEMS',
				$this->dispenser->get(
					$this->config->build_target . '_php_after_getitems',
					$view['settings']->code, PHP_EOL, null, true
				)
			);
		}
	}
}

