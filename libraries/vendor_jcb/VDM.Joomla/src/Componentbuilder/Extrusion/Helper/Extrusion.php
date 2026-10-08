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

namespace VDM\Joomla\Componentbuilder\Extrusion\Helper;


use Joomla\CMS\Factory as JoomlaFactory;
use VDM\Joomla\Componentbuilder\Extrusion\Factory;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Message;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * The dump-driven extrusion entry point.
 * 
 * This is the seam the component form has always called: saving a component with
 * a pasted schema dump builds its views and fields. It no longer carries any
 * parsing or writing of its own. It resolves the extrusion engine from the
 * container, hands it the dump and the component it belongs to, and surfaces what
 * the engine reported.
 * 
 * Keeping one engine behind both entry points is the point. The dump path and the
 * folder path now share every reader, resolver and writer, so an improvement to
 * one is an improvement to both, and they cannot quietly disagree about the same
 * dump.
 * 
 * @since 3.2.0
 */
class Extrusion
{
	/**
	 * How the message levels map onto Joomla's own enqueue types.
	 *
	 * @var    array<string, string>
	 * @since  6.1.6
	 */
	private const ENQUEUE = [
		Message::ERROR => 'error',
		Message::WARNING => 'warning',
		Message::NOTICE => 'notice',
		Message::SUCCESS => 'message'
	];

	/**
	 * Whether the run reached its writing step.
	 *
	 * @var    bool
	 * @since  6.1.6
	 */
	protected bool $completed = false;

	/**
	 * Everything the run had to say, by level.
	 *
	 * @var    array<string, array<int, array{message: string, subject?: string}>>
	 * @since  6.1.6
	 */
	protected array $messages = [];

	/**
	 * Constructor.
	 *
	 * The signature is preserved because the component model has always
	 * constructed this directly, and the build values are still cleared out of the
	 * data so a pasted dump is never persisted.
	 *
	 * @param   array  $data  The component data being saved.
	 *
	 * @since   3.2.0
	 */
	public function __construct(&$data)
	{
		if (!ArrayHelper::check($data) || empty($data['id']) || (int) $data['id'] < 1)
		{
			$this->enqueue(
				'error',
				'A component id is needed before a schema dump can be extruded, so save '
				. 'the component first and then extrude.'
			);

			return;
		}

		$dump = isset($data['buildcompsql'])
			? base64_decode((string) $data['buildcompsql'])
			: '';

		$data['buildcomp'] = 0;
		$data['buildcompsql'] = '';

		if (trim($dump) === '')
		{
			$this->enqueue('error', 'No schema dump was supplied to extrude.');

			return;
		}

		$this->run($dump, (int) $data['id'], (string) ($data['name_code'] ?? ''));
	}

	/**
	 * Whether the run reached its writing step.
	 *
	 * @return  bool  True when the extrusion completed.
	 * @since   6.1.6
	 */
	public function completed(): bool
	{
		return $this->completed;
	}

	/**
	 * Everything the run had to say, by level.
	 *
	 * @return  array<string, array<int, array{message: string, subject?: string}>>  The messages.
	 * @since   6.1.6
	 */
	public function messages(): array
	{
		return $this->messages;
	}

	/**
	 * Hand the dump to the extrusion engine and surface its report.
	 *
	 * @param   string  $dump      The schema text.
	 * @param   int     $component The JCB component id.
	 * @param   string  $codeName  The component code name, when the form knows it.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function run(string $dump, int $component, string $codeName): void
	{
		$extruder = Factory::_('Extruder');
		$report = $extruder->reset()
			->dump($dump)
			->component($component)
			->codeName($codeName)
			->extrude();

		$this->completed = (bool) $report->get('completed', false);
		$this->messages = $extruder->messages();

		foreach ($this->messages as $level => $messages)
		{
			foreach ($messages as $entry)
			{
				$entry = (array) $entry;
				$this->enqueue(
					self::ENQUEUE[$level] ?? 'notice',
					(string) ($entry['message'] ?? '')
				);
			}
		}
	}

	/**
	 * Show one message to the user.
	 *
	 * Presentation is the caller's job everywhere below this class; this is the one
	 * place that is allowed to speak to the application, because it is the entry
	 * point the component form calls directly.
	 *
	 * @param   string  $type     The Joomla enqueue type.
	 * @param   string  $message  The plain message.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function enqueue(string $type, string $message): void
	{
		if ($message === '')
		{
			return;
		}

		try
		{
			$application = JoomlaFactory::getApplication();
		}
		catch (\Throwable $exception)
		{
			// Without an application there is nobody to show a message to. The
			// messages are still gathered on the bus and readable by any caller, so
			// losing the presentation must never lose the run.
			return;
		}

		if (method_exists($application, 'enqueueMessage'))
		{
			$application->enqueueMessage($message, $type);
		}
	}
}

