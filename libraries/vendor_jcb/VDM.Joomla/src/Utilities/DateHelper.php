<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities;


/**
 * Simple Date Helper
 * 
 * @since  5.0.2
 */
abstract class DateHelper
{
	/**
	 * Convert a date to a human-readable fancy format (e.g., "1st of January 2024").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Formatted date.
	 * @since 3.0.0
	 */
	public static function fancyDate($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('jS \o\f F Y', $date);
	}

	/**
	 * Get a formatted date based on the time period (dynamic format based on age of the date).
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Formatted date.
	 * @since 3.0.0
	 */
	public static function fancyDynamicDate($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		// If older than a year, use m/d/y format.
		if (date('Y', $date) < date('Y', strtotime('-1 year')))
		{
			return date('m/d/y', $date);
		}

		// If it's the same day, return the time.
		if ($date > strtotime('-1 day'))
		{
			return date('g:i A', $date);
		}

		// Otherwise, return the month and day.
		return date('M j', $date);
	}

	/**
	 * Convert a date to a human-readable day, time, and date format (e.g., "Mon 12am 1st of January 2024").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Formatted day, time, and date.
	 * @since 3.0.0
	 */
	public static function fancyDayTimeDate($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('D gA jS \o\f F Y', $date);
	}

	/**
	 * Convert a date to a human-readable time and date format (e.g., "(12:00) 1st of January 2024").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Formatted time and date.
	 * @since 3.0.0
	 */
	public static function fancyDateTime($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('(G:i) jS \o\f F Y', $time);
	}

	/**
	 * Convert a time to a human-readable format (e.g., "12:00").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Formatted time.
	 * @since 3.0.0
	 */
	public static function fancyTime($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('G:i', $date);
	}

	/**
	 * Convert a date to the day name (e.g., "Sunday").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Day name.
	 * @since 3.0.0
	 */
	public static function setDayName($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('l', $date);
	}

	/**
	 * Convert a date to the month name (e.g., "January").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Month name.
	 * @since 3.0.0
	 */
	public static function setMonthName($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('F', $date);
	}

	/**
	 * Convert a date to the day with suffix (e.g., "1st").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Day with suffix.
	 * @since 3.0.0
	 */
	public static function setDay($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('jS', $date);
	}

	/**
	 * Convert a date to the numeric month (e.g., "5").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Numeric month.
	 * @since 3.0.0
	 */
	public static function setMonth($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('n', $date);
	}

	/**
	 * Convert a date to the full year (e.g., "2024").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Full year.
	 * @since 3.0.0
	 */
	public static function setYear($date, bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('Y', $date);
	}

	/**
	 * Convert a date to a year/month format (e.g., "2024/05").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param string      $spacer       The spacer between year and month.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Year/Month format.
	 * @since 3.0.0
	 */
	public static function setYearMonth($date, string $spacer = '/', bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('Y' . $spacer . 'm', $date);
	}

	/**
	 * Convert a date to a year/month/day format (e.g., "2024/05/03").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param string      $spacer       The spacer between year and month.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Year/Month/Day format.
	 * @since 3.0.0
	 */
	public static function setYearMonthDay($date, string $spacer = '/', bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('Y' . $spacer . 'm' . $spacer . 'd', $date);
	}

	/**
	 * Convert a date to a day/month/year format (e.g., "03/05/2024").
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param string      $spacer       The spacer between year and month.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return string Day/Month/Year format.
	 * @since 3.0.0
	 */
	public static function setDayMonthYear($date, string $spacer = '/', bool $checkStamp = true): string
	{
		$date = static::getValidTimestamp($date, $checkStamp);

		return date('d' . $spacer . 'm' . $spacer . 'Y', $date);
	}

	/**
	 * Convert a date string to a valid timestamp.
	 *
	 * @param string|int  $date         The date as a string or timestamp.
	 * @param bool        $checkStamp   Whether to check if the input is a timestamp.
	 *
	 * @return int The valid timestamp.
	 * @since 3.0.0
	 */
	public static function getValidTimestamp($date, bool $checkStamp): int
	{
		if ($checkStamp && !static::isValidTimeStamp($date))
		{
			$date = strtotime($date ?? 'Now');
		}

		return (int) $date;
	}

	/**
	 * Check if the input is a valid Unix timestamp.
	 *
	 * @param mixed $timestamp The timestamp to validate.
	 *
	 * @return bool True if valid timestamp, false otherwise.
	 * @since 3.0.0
	 */
	public static function isValidTimeStamp($timestamp): bool
	{
		return (is_numeric($timestamp) && (int) $timestamp == $timestamp && $timestamp > 0);
	}

	/**
	 * Check if a string is a valid date according to the specified format.
	 *
	 * @param string $date The date string to validate.
	 * @param string $format The format to check against (default is 'Y-m-d H:i:s').
	 *
	 * @return bool True if valid date, false otherwise.
	 * @since 3.0.0
	 */
	public static function isValidateDate($date, string $format = 'Y-m-d H:i:s'): bool
	{
		$d = \DateTime::createFromFormat($format, $date);

		return $d && $d->format($format) === $date;
	}
}

