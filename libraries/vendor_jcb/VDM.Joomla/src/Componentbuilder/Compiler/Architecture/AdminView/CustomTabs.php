<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminView;


use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomTabs as CustomTabsData;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Edit View Custom Tabs Class.
 * 
 * Returns the custom tab markup a view has registered for one tab number and
 * one position within that tab. A view may register several custom tabs for
 * the same slot, in which case they are emitted in registration order.
 * 
 * @since  6.1.7
 */
final class CustomTabs
{
	/**
	 * The Custom Tabs Class.
	 *
	 * @var   CustomTabsData
	 * @since 6.1.7
	 */
	protected CustomTabsData $customtabs;

	/**
	 * Constructor.
	 *
	 * @param CustomTabsData   $customtabs   The Custom Tabs Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(CustomTabsData $customtabs)
	{
		$this->customtabs = $customtabs;
	}

	/**
	 * Get the custom tabs registered for one slot of a view.
	 *
	 * @param   int     $nr           The tab number to match.
	 * @param   string  $nameSingle   The single view name.
	 * @param   int     $target       The position within the tab to match.
	 *
	 * @return  string|false  The generated markup, or false when the slot is empty.
	 *
	 * @since   6.1.7
	 */
	public function get($nr, string $nameSingle, $target)
	{
		// check if this view is having custom tabs
		if (($tabs = $this->customtabs->get($nameSingle)) !== null
			&& ArrayHelper::check($tabs))
		{
			$html = [];
			foreach ($tabs as $customTab)
			{
				if (ArrayHelper::check($customTab)
					&& isset($customTab['html']))
				{
					if ($customTab['tab'] == $nr
						&& $customTab['position'] == $target
						&& isset($customTab['html'])
						&& StringHelper::check(
							$customTab['html']
						))
					{
						$html[] = $customTab['html'];
					}
				}
			}
			// return if found
			if (ArrayHelper::check($html))
			{
				return PHP_EOL . implode(PHP_EOL, $html);
			}
		}

		return false;
	}
}

