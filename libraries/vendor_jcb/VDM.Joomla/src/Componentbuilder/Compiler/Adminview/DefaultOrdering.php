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

namespace VDM\Joomla\Componentbuilder\Compiler\Adminview;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ViewsDefaultOrdering;
use VDM\Joomla\Componentbuilder\Compiler\Field\DatabaseName;


/**
 * Admin View Default Ordering Class
 * 
 * @since 5.1.4
 */
final class DefaultOrdering
{
	/**
	 * The Views Default Ordering Class.
	 *
	 * @var   ViewsDefaultOrdering
	 * @since 5.1.4
	 */
	protected ViewsDefaultOrdering $viewsdefaultordering;

	/**
	 * The Database Name Class.
	 *
	 * @var   DatabaseName
	 * @since 5.1.4
	 */
	protected DatabaseName $databasename;

	/**
	 * Constructor.
	 *
	 * @param ViewsDefaultOrdering   $viewsdefaultordering   The Views Default Ordering Class.
	 * @param DatabaseName           $databasename           The Database Name Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(ViewsDefaultOrdering $viewsdefaultordering,
		DatabaseName $databasename)
	{
		$this->viewsdefaultordering = $viewsdefaultordering;
		$this->databasename = $databasename;
	}

	/**
	 * Get list view default ordering configuration.
	 *
	 * @param   string  $nameListCode
	 *
	 * @return  array{name:string,direction:string}
	 * @since   5,1,4
	 */
	public function get(string $nameListCode): array
	{
		if ($this->viewsdefaultordering->get("{$nameListCode}.add_admin_ordering", 0) == 1)
		{
			foreach ($this->viewsdefaultordering->get("{$nameListCode}.admin_ordering_fields", []) as $order)
			{
				$field = $this->databasename->get($nameListCode, $order['field']);

				if ($field !== false)
				{
					return [
						'name'      => $field,
						'direction' => $order['direction'],
					];
				}
			}
		}

		return [
			'name'      => 'a.id',
			'direction' => 'DESC',
		];
	}
}

