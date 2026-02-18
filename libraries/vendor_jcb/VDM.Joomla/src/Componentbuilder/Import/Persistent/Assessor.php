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

namespace VDM\Joomla\Componentbuilder\Import\Persistent;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Import\Data;
use VDM\Joomla\Interfaces\Import\StatusInterface as Status;
use VDM\Joomla\Interfaces\Import\MessageInterface as Message;
use VDM\Joomla\Interfaces\Import\AssessorInterface;


/**
 * Import Persistent Assessor Class
 * 
 * @since  4.0.3
 */
final class Assessor implements AssessorInterface
{
	/**
	 * The Data Class.
	 *
	 * @var   Data
	 * @since 4.0.3
	 */
	protected Data $data;

	/**
	 * The Import Status Class.
	 *
	 * @var   Status
	 * @since 4.0.3
	 */
	protected Status $status;

	/**
	 * The Import Message Class.
	 *
	 * @var   Message
	 * @since 4.0.3
	 */
	protected Message $message;

	/**
	 * Constants for defining the success threshold
	 * Minimum success rate to consider the import successful
	 *
	 * @since 4.0.3
	 */
	private const SUCCESS_THRESHOLD = 0.80;

	/**
	 * Constructor.
	 *
	 * @param Data      $data      The Data Class.
	 * @param Status    $status    The Import Status Class.
	 * @param Message   $message   The Import Message Class.
	 *
	 * @since 4.0.3
	 */
	public function __construct(Data $data, Status $status, Message $message)
	{
		$this->data = $data;
		$this->status = $status;
		$this->message = $message;
	}

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
	public function evaluate(int $rowCounter, int $successCounter, int $errorCounter): void
	{
		// No rows processed case
		if ($rowCounter === 0)
		{
			$this->message->addError(Text::_('COM_COMPONENTBUILDER_NO_ROWS_WERE_PROCESSED'));

			if (($guid = $this->data->get('import.guid')) !== null)
			{
				$this->status->set(4, $guid); // Status 4 => completed with errors
			}
			return;
		}

		$successRate = $successCounter / $rowCounter;
		$errorRate = (1 - $successRate) * 100;
		$successPercentage = $successRate * 100;

		// Determine appropriate message based on success rate
		if ($successRate >= self::SUCCESS_THRESHOLD)
		{
			$this->message->addSuccess(Text::sprintf('COM_COMPONENTBUILDER_D_ROWS_PROCESSED_SUCCESS_RATE_TWOF_IMPORT_SUCCESSFUL', 
				$rowCounter, 
				$successPercentage
			));
		}
		else
		{
			$this->message->addError(Text::sprintf('COM_COMPONENTBUILDER_IMPORT_FAILED_D_ROWS_PROCESSED_WITH_ONLY_D_SUCCESSES_ERROR_RATE_TWOF', 
				$rowCounter, 
				$successCounter, 
				$errorRate
			));
		}

		if (($guid = $this->data->get('import.guid')) !== null)
		{
			// Update import status based on success rate
			$importStatus = ($successPercentage == 100) ? 3 : 4; // 3 => completed, 4 => completed with errors
			$this->status->set($importStatus, $guid);
		}
	}
}

