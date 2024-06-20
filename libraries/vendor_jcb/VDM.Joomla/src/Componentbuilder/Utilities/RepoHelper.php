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

namespace VDM\Joomla\Componentbuilder\Utilities;


use Joomla\CMS\Factory;


/**
 * Repositories Helper
 * 
 * @since 3.2.2
 */
abstract class RepoHelper
{
	/**
	 * get available repositories of target area
	 *
	 * @param int   $target    The target area
	 *
	 * @return array|null   The result set
	 * @since 3.2.0
	 **/
	public static function get(int $target): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array(
				'type',
				'base',
				'organisation',
				'repository',
				'read_branch',
				'write_branch',
				'token',
				'username',
				'target',
				'access_repo',
				'guid'
			)))
			->from($db->quoteName('#__componentbuilder_repository'))
			->where($db->quoteName('published') . ' >= 1')
			->where($db->quoteName('target') . ' = ' . $target)
			->order($db->quoteName('ordering') . ' desc');
		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			$items = $db->loadObjectList();
			$options = [];
			foreach($items as $item)
			{
				if ($item->access_repo != 1)
				{
					unset($item->username);
					unset($item->token);
				}
				unset($item->access_repo);
				$path = $item->organisation . '/' . $item->repository;
				$options[$path] =  $item;
			}
			return $options;
		}

		return null;
	}
}

