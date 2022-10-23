<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Abstraction;


use Joomla\Registry\Registry as JoomlaRegistry;


/**
 * Registry
 * 
 * So we have full control over this class
 * 
 * @since 3.2.0
 */
abstract class BaseRegistry extends JoomlaRegistry implements \JsonSerializable, \ArrayAccess, \IteratorAggregate, \Countable
{
	/**
	 * Method to iterate over any part of the registry
	 *
	 * @param   string  $path  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  \ArrayIterator  This object represented as an ArrayIterator.
	 *
	 * @since   3.4.0
	 */
	public function _($path)
	{
		$data = $this->extract($path);

		if ($data === null)
		{
			return null;
		}

		return $data->getIterator();
	}

}

