<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder;


/**
 * Adds Tabs
 * 
 * @since 3.1.5
 */
trait Tab
{
	/**
	 * Tab/spacer bucket (to speed-up the build)
	 * 
	 * @var   array
	 * @since 3.1.5
	 */
	protected $tabSpacerBucket = array();

	/**
	 * Set tab/spacer
	 * 
	 * @var   string
	 * @since 3.1.5
	 */
	protected $tabSpacer = "\t";

	/**
	 * Set the tab/space
	 * 
	 * @param   int   $nr  The number of tag/space
	 * 
	 * @return  string
	 * @since 3.1.5
	 */
	public function _t(int $nr) : string
	{
		// check if we already have the string
		if (!isset($this->tabSpacerBucket[$nr]))
		{
			// get the string
			$this->tabSpacerBucket[$nr] = str_repeat($this->tabSpacer, (int) $nr);
		}
		// return stored string
		return $this->tabSpacerBucket[$nr];
	}
}

