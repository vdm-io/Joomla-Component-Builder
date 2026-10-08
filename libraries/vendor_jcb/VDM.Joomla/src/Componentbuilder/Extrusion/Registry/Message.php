<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * The extrusion message bus.
 * 
 * An extrusion run rarely fails outright and rarely succeeds completely: it works
 * with whatever the source gave it and falls short wherever the source was thin.
 * That makes "what did this achieve" the only question worth answering, and this
 * is where the answer accumulates.
 * 
 * Messages are gathered, never rendered. Each one is stored as plain data under a
 * level, so the caller decides what becomes a Joomla enqueue, what becomes HTML,
 * and what is merely logged. No formatting belongs in here.
 * 
 * @since 6.1.6
 */
final class Message extends Registry implements Registryinterface
{
	/**
	 * Something was achieved.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const SUCCESS = 'success';

	/**
	 * Something worth knowing, which did not stop the run.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const NOTICE = 'notice';

	/**
	 * The run continued but the outcome is thinner than it could have been.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const WARNING = 'warning';

	/**
	 * Something the run needed was missing or refused.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	public const ERROR = 'error';

	/**
	 * Every level, in the order a reader should be shown them.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	public const LEVELS = [self::ERROR, self::WARNING, self::NOTICE, self::SUCCESS];

	/**
	 * Record a message at one level.
	 *
	 * Named record() rather than add() because the registry this extends already
	 * defines add() for appending to a path, and shadowing it would be both a
	 * signature clash and a lie about what this does.
	 *
	 * @param   string  $level    One of the level constants.
	 * @param   string  $message  The plain, unformatted message.
	 * @param   string  $subject  Optional subject the message is about.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function record(string $level, string $message, string $subject = ''): self
	{
		$level = in_array($level, self::LEVELS, true) ? $level : self::NOTICE;
		$message = trim($message);

		if ($message === '')
		{
			return $this;
		}

		$entry = ['message' => $message];

		if ($subject !== '')
		{
			$entry['subject'] = $subject;
		}

		$existing = $this->get($level);
		$existing = is_array($existing) ? $existing : [];

		foreach ($existing as $known)
		{
			$known = (array) $known;

			if (($known['message'] ?? null) === $message
				&& ($known['subject'] ?? '') === ($entry['subject'] ?? ''))
			{
				return $this;
			}
		}

		$existing[] = $entry;

		return $this->set($level, $existing);
	}

	/**
	 * Record something the run achieved.
	 *
	 * @param   string  $message  The plain message.
	 * @param   string  $subject  Optional subject.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function success(string $message, string $subject = ''): self
	{
		return $this->record(self::SUCCESS, $message, $subject);
	}

	/**
	 * Record something worth knowing that did not stop the run.
	 *
	 * @param   string  $message  The plain message.
	 * @param   string  $subject  Optional subject.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function notice(string $message, string $subject = ''): self
	{
		return $this->record(self::NOTICE, $message, $subject);
	}

	/**
	 * Record that the outcome is thinner than the source could have allowed.
	 *
	 * @param   string  $message  The plain message.
	 * @param   string  $subject  Optional subject.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function warning(string $message, string $subject = ''): self
	{
		return $this->record(self::WARNING, $message, $subject);
	}

	/**
	 * Record that something the run needed was missing or refused.
	 *
	 * @param   string  $message  The plain message.
	 * @param   string  $subject  Optional subject.
	 *
	 * @return  self  For method chaining.
	 * @since   6.1.6
	 */
	public function error(string $message, string $subject = ''): self
	{
		return $this->record(self::ERROR, $message, $subject);
	}

	/**
	 * Every message at one level.
	 *
	 * @param   string  $level  One of the level constants.
	 *
	 * @return  array<int, array{message: string, subject?: string}>  The messages.
	 * @since   6.1.6
	 */
	public function level(string $level): array
	{
		$messages = $this->get($level);

		if (!is_array($messages))
		{
			return [];
		}

		$clean = [];

		foreach ($messages as $entry)
		{
			$clean[] = (array) $entry;
		}

		return $clean;
	}

	/**
	 * Every message, keyed by level, in reading order.
	 *
	 * This is the array a caller hands to its own presentation layer.
	 *
	 * @return  array<string, array<int, array{message: string, subject?: string}>>  The messages.
	 * @since   6.1.6
	 */
	public function all(): array
	{
		$all = [];

		foreach (self::LEVELS as $level)
		{
			$messages = $this->level($level);

			if ($messages !== [])
			{
				$all[$level] = $messages;
			}
		}

		return $all;
	}

	/**
	 * How many messages were recorded, optionally at one level.
	 *
	 * @param   string|null  $level  A level, or null for every level.
	 *
	 * @return  int  The message count.
	 * @since   6.1.6
	 */
	public function total(?string $level = null): int
	{
		if ($level !== null)
		{
			return count($this->level($level));
		}

		$total = 0;

		foreach (self::LEVELS as $known)
		{
			$total += count($this->level($known));
		}

		return $total;
	}

	/**
	 * Whether anything the run needed was missing or refused.
	 *
	 * @return  bool  True when at least one error was recorded.
	 * @since   6.1.6
	 */
	public function failed(): bool
	{
		return $this->total(self::ERROR) > 0;
	}
}

