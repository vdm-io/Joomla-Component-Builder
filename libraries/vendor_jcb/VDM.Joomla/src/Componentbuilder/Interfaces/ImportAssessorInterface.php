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

namespace VDM\Joomla\Componentbuilder\Interfaces;


/**
 * Import Assessor Interface
 * 
 * @since  3.0.3
 */
interface ImportAssessorInterface
{
	/**
	 * Evaluates the import process and sets the success/error message based on the success rate.
	 *
	 * @param int $rowCounter     Total number of rows processed.
	 * @param int $successCounter Number of successfully processed rows.
	 * @param int $errorCounter   Number of rows that failed to process.
	 *
	 * @return void
	 * @since 4.0.3
	 */
	public function evaluate(int $rowCounter, int $successCounter, int $errorCounter): void;
}

