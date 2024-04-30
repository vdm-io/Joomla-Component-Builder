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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Componentbuilder\Compiler\Power\Injector as Power;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaPower\Injector as JoomlaPower;
use VDM\Joomla\Utilities\MathHelper;


/**
 * File Injector
 *    Thanks to http://stackoverflow.com/a/16813550/1429677
 * 
 * @since 3.2.0
 */
final class FileInjector
{
	/**
	 * The Injector Class.
	 *
	 * @var   Power
	 * @since 3.2.0
	 */
	protected Power $power;

	/**
	 * The Joomla Injector Class.
	 *
	 * @var   JoomlaPower
	 * @since 3.2.1
	 */
	protected JoomlaPower $joomla;

	/**
	 * The power pattern to get the powers
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	protected string $powerPattern = '/Super_'.'_'.'_[a-zA-Z0-9_]+_'.'_'.'_Power/';

	/**
	 * The Joomla power pattern to get the powers
	 *
	 * @var    string
	 * @since 3.2.1
	 **/
	protected string $joomlaPattern = '/Joomla_'.'_'.'_[a-zA-Z0-9_]+_'.'_'.'_Power/';

	/**
	 * Constructor.
	 *
	 * @param Power        $power    The Injector Class.
	 * @param JoomlaPower  $joomla   The Joomla Injector Class.
	 *
	 * @since 3.2.1
	 */
	public function __construct(Power $power, JoomlaPower $joomla)
	{
		$this->power = $power;
		$this->joomla = $joomla;
	}

	/**
	 * Inserts or replaces data in a file at a specific position.
	 *
	 * @param string    $file      The path of the file to modify.
	 * @param string    $data      The data to insert or replace.
	 * @param int       $position  The position in the file where the data should be inserted or replaced.
	 * @param int|null  $replace   The number of bytes to replace; if null, data will be inserted.
	 *
	 * @return void
	 * @throws \RuntimeException	      If unable to open or modify the file.
	 * @throws \InvalidArgumentException  If the position is negative.
	 * @since 3.2.0
	 */
	public function add(string $file, string $data, int $position, ?int $replace = null): void
	{
		if ($position < 0)
		{
			throw new \InvalidArgumentException('Position cannot be negative.');
		}

		$found_joomla_powers = preg_match($this->joomlaPattern, $data);
		$found_super_powers = preg_match($this->powerPattern, $data);

		$actual_file = $this->openFileWithLock($file);

		try
		{
			$temp_file = fopen('php://temp', "rw+");
			if ($temp_file === false)
			{
				throw new \RuntimeException("Unable to open temporary file.");
			}

			$this->processFile($actual_file, $temp_file, $data, $position, $replace);

			if ($found_joomla_powers)
			{
				$this->injectJoomlaPowers($actual_file);
			}

			if ($found_super_powers)
			{
				$this->injectSuperPowers($actual_file);
			}
		}
		finally
		{
			flock($actual_file, LOCK_UN);
			fclose($actual_file);
			if (isset($temp_file))
			{
				fclose($temp_file);
			}
		}
	}

	/**
	 * Opens a file and acquires an exclusive lock on it.
	 *
	 * @param string $file The file path to open.
	 *
	 * @return resource The file handle.
	 * @throws \RuntimeException If the file cannot be opened or locked.
	 * @since 3.2.0
	 */
	private function openFileWithLock(string $file)
	{
		$actual_file = fopen($file, "rw+");
		if ($actual_file === false || !flock($actual_file, LOCK_EX))
		{
			throw new \RuntimeException("Unable to open and lock the file: {$file}");
		}
		return $actual_file;
	}

	/**
	 * Processes the file for data insertion and copying the remaining data.
	 *
	 * @param resource  $actual_file The file handle of the actual file.
	 * @param resource  $temp_file   The file handle of the temporary file.
	 * @param string    $data        The data to be inserted.
	 * @param int       $position    The position in the file for the data insertion.
	 * @param int|null  $replace     The number of bytes to replace; if null, data will be inserted.
	 * 
	 * @return void
	 * @since 3.2.0
	 */
	private function processFile($actual_file, $temp_file, string $data, int $position, ?int $replace): void
	{
		// Make a copy of the file in the temporary stream
		stream_copy_to_stream($actual_file, $temp_file);

		// Move to the position where the data should be added
		fseek($actual_file, $position);

		// Add the data
		fwrite($actual_file, $data);

		$this->truncateIfNeeded($actual_file, $data, $position);
		$this->copyRemainingData($actual_file, $temp_file, $position, $replace);
	}

	/**
	 * Truncates the file after data insertion if necessary.
	 *
	 * @param resource  $actual_file The file handle.
	 * @param string    $data        The data that was inserted.
	 * @param int       $position    The position where data was inserted.
	 * 
	 * @return void
	 * @since 3.2.0
	 */
	private function truncateIfNeeded($actual_file, string $data, int $position): void
	{
		// Truncate the file at the end of the added data if replacing
		$data_length = mb_strlen($data, '8bit');
		$remove = MathHelper::bc('add', $position, $data_length);
		ftruncate($actual_file, $remove);
	}

	/**
	 * Copies the remaining data from the temporary stream to the actual file.
	 *
	 * @param resource  $actual_file The file handle of the actual file.
	 * @param resource  $temp_file   The file handle of the temporary file.
	 * @param int       $position    The position in the file where data insertion finished.
	 * @param int|null  $replace     The number of bytes that were replaced; if null, data was inserted.
	 * 
	 * @return void
	 * @since 3.2.0
	 */
	private function copyRemainingData($actual_file, $temp_file, int $position, ?int $replace): void
	{
		// check if this was a replacement of data
		$position = MathHelper::bc('add', $position, $replace ?: 0);

		// Move to the position of the remaining data in the temporary stream
		fseek($temp_file, $position);

		// Copy the remaining data from the temporary stream to the file
		stream_copy_to_stream($temp_file, $actual_file);
	}

	/**
	 * Injects super powers into the file content, if found, and updates the file.
	 *
	 * @param resource  $actual_file   The file handle of the actual file.
	 * 
	 * @return void
	 * @since 3.2.0
	 */
	private function injectSuperPowers($actual_file): void
	{
		rewind($actual_file);

		$power_data = $this->power->power(
			stream_get_contents($actual_file)
		);

		ftruncate($actual_file, 0);
		rewind($actual_file);

		fwrite($actual_file, $power_data);
	}

	/**
	 * Injects Joomla powers into the file content, if found, and updates the file.
	 *
	 * @param resource  $actual_file   The file handle of the actual file.
	 * 
	 * @return void
	 * @since 3.2.1
	 */
	private function injectJoomlaPowers($actual_file): void
	{
		rewind($actual_file);

		$power_data = $this->joomla->power(
			stream_get_contents($actual_file)
		);

		ftruncate($actual_file, 0);
		rewind($actual_file);

		fwrite($actual_file, $power_data);
	}
}

