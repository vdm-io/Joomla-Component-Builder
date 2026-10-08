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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\Placeholders as ViewPlaceholders;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Helper as CreatorHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Every admin view the component was given.
 * 
 * @since 6.1.7
 */
final class Loop
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Creator Helper Class.
	 *
	 * @var   CreatorHelper
	 * @since 6.1.7
	 */
	protected CreatorHelper $creatorhelper;

	/**
	 * The AdminViews EditView Class.
	 *
	 * @var   EditView
	 * @since 6.1.7
	 */
	protected EditView $editview;

	/**
	 * The AdminViews ListView Class.
	 *
	 * @var   ListView
	 * @since 6.1.7
	 */
	protected ListView $listview;

	/**
	 * The AdminViews Shared Class.
	 *
	 * @var   Shared
	 * @since 6.1.7
	 */
	protected Shared $shared;

	/**
	 * The AdminViews ListLink Class.
	 *
	 * @var   ListLink
	 * @since 6.1.7
	 */
	protected ListLink $listlink;

	/**
	 * The View Placeholders Class.
	 *
	 * @var   ViewPlaceholders
	 * @since 6.1.7
	 */
	protected ViewPlaceholders $viewplaceholders;

	/**
	 * Constructor.
	 *
	 * @param Config           $config               The Config Class.
	 * @param Component        $component            The Component Class.
	 * @param CreatorHelper    $creatorhelper        The Creator Helper Class.
	 * @param EditView         $editview             The AdminViews EditView Class.
	 * @param ListView         $listview             The AdminViews ListView Class.
	 * @param Shared           $shared               The AdminViews Shared Class.
	 * @param ListLink         $listlink             The AdminViews ListLink Class.
	 * @param ViewPlaceholders $viewplaceholders     The View Placeholders Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Component $component,
		CreatorHelper $creatorhelper,
		EditView $editview,
		ListView $listview,
		Shared $shared,
		ListLink $listlink,
		ViewPlaceholders $viewplaceholders)
	{
		$this->config = $config;
		$this->component = $component;
		$this->creatorhelper = $creatorhelper;
		$this->editview = $editview;
		$this->listview = $listview;
		$this->shared = $shared;
		$this->listlink = $listlink;
		$this->viewplaceholders = $viewplaceholders;
	}

	/**
	 * Build every admin view the component was given.
	 *
	 * @return  array  The view map and the site edit views, as the
	 *                 component-wide build reads them back.
	 * @since   6.1.7
	 */
	public function build(): array
	{
		// reset view array
		$viewarray            = [];
		$site_edit_view_array = [];
		// start dynamic build
		foreach ($this->component->get('admin_views') as $view)
		{
			// set the target
			$this->config->build_target = 'admin';
			$this->config->lang_target = 'admin';

			// set local names
			$nameSingleCode = $view['settings']->name_single_code;
			$nameListCode   = $view['settings']->name_list_code;

			// set the view placeholders
			$this->viewplaceholders->set($view['settings']);

			// set site edit view array
			if (isset($view['edit_create_site_view'])
				&& is_numeric(
					$view['edit_create_site_view']
				)
				&& $view['edit_create_site_view'] > 0)
			{
				$site_edit_view_array[$nameSingleCode] = $nameListCode;
				$this->config->lang_target = 'both';
				// insure site view does not get removed
				$this->config->remove_site_edit_folder = false;
			}

			// check if help is being loaded
			$this->creatorhelper->set($nameSingleCode);

			// set custom admin view list links
			$this->listlink->set(
				$view, $nameListCode
			);

			// set view array
			$viewarray[] = Indent::_(4) . "'"
				. $nameSingleCode . "' => '"
				. $nameListCode . "'";
			// the edit view of this admin view
			$this->editview->build(
				$view, $nameSingleCode, $nameListCode
			);

			// the list view of this admin view
			$this->listview->build(
				$view, $nameSingleCode, $nameListCode
			);

			// the pieces both views of this admin view share
			$this->shared->build(
				$view, $nameSingleCode, $nameListCode
			);
		}

		// the two arrays the component-wide build reads back
		return [$viewarray, $site_edit_view_array];
	}
}

