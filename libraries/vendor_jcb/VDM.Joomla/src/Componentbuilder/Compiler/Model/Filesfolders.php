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


use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Files & Folders Class
 * 
 * @since 3.2.0
 */
class Filesfolders
{
	/**
	 * Compiler Files Folders
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $keys = [
		'files' => 'files',
		'folders' => 'folders',
		'urls' => 'urls',
		'filesfullpath' => 'files',
		'foldersfullpath' => 'folders'
	];

	/**
	 * Set the file and folder data
	 *
	 * @param   object  $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		foreach ($this->keys as $target => $value)
		{
			// set the add target data
			$item->{'add' . $target} = (isset($item->{'add' . $target}) &&
				JsonHelper::check($item->{'add' . $target})) ?
					json_decode((string) $item->{'add' . $target}, true) : null;

			// only continue if there are values
			if (ArrayHelper::check($item->{'add' . $target}))
			{
				if (isset($item->{$value})
					&& ArrayHelper::check($item->{$value}))
				{
					foreach ($item->{'add' . $target} as $taget)
					{
						$item->{$value}[] = $taget;
					}
				}
				else
				{
					$item->{$value} = array_values(
						$item->{'add' . $target}
					);
				}
			}

			unset($item->{'add' . $target});
		}
	}

}

