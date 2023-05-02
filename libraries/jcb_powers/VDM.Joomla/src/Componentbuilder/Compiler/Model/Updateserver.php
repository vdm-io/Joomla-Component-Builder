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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Joomla Update Server Class
 * 
 * @since 3.2.0
 */
class Updateserver
{
	/**
	 * Set version updates
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		// set the version updates
		$item->version_update = (isset($item->version_update)
			&& JsonHelper::check($item->version_update))
			? json_decode((string) $item->version_update, true) : null;
		if (ArrayHelper::check($item->version_update))
		{
			$item->version_update = array_values(
				$item->version_update
			);

			// set  the change log details
			$this->changelog($item);
		}
	}

	/**
	 * Set changelog values to component changelog
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function changelog(object &$item)
	{
		// set the version updates
		$bucket = [];
		foreach ($item->version_update as $update)
		{
			if (isset($update['change_log']) && StringHelper::check($update['change_log'])
				&& isset($update['version']) && StringHelper::check($update['version']))
			{
				$bucket[] = '# v' . $update['version'] . PHP_EOL . PHP_EOL . $update['change_log'];
			}
		}

		if (ArrayHelper::check($bucket))
		{
			$item->changelog = implode(PHP_EOL . PHP_EOL, $bucket);
		}
	}

}

