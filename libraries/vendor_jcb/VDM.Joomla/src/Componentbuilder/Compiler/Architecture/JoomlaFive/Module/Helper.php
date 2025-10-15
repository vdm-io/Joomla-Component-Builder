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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\HelperInterface;


/**
 * Module Helper Code Joomla 5
 * 
 * @since 5.1.2
 */
final class Helper implements HelperInterface
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.2
	 */
	protected ContentOne $contentone;

	/**
	 * Constructor.
	 *
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param ContentOne    $contentone    The ContentOne Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Placeholder $placeholder, ContentOne $contentone)
	{
		$this->placeholder = $placeholder;
		$this->contentone = $contentone;
	}

	/**
	 * Get Module Helper Class code
	 *
	 * @param  object  $module  The module object
	 *
	 * @return string  The helper class code
	 * @since  5.1.2
	 */
	public function get(object $module): string
	{
		$type = trim((string) ($module->class_helper_type ?? 'class'));
		$name = trim((string) ($module->class_helper_name ?? 'Helper'));
		$body = (string) ($module->class_helper_code ?? '');
		$implements = '';

		if ($this->usesDatabaseFeatures($body))
		{
			$implements = ' implements DatabaseAwareInterface';

			if (!str_contains($body, 'use DatabaseAwareTrait;'))
			{
				$body = Indent::_(1) . 'use DatabaseAwareTrait;' . PHP_EOL . PHP_EOL . $body;
			}
		}

		$code = PHP_EOL . $type . ' ' . $name . $implements . PHP_EOL . '{' . PHP_EOL . $body . PHP_EOL . '}' . PHP_EOL;

		return $this->placeholder->update($code, $this->contentone->allActive());
	}

	/**
	 * Get Module Helper Header code
	 *
	 * @param  object  $module  The module object
	 *
	 * @return string  The helper header code
	 * @since  5.1.2
	 */
	public function header(object $module): string
	{
		$code = (string) trim($module->class_helper_header ?? '');
		$body = trim((string) ($module->class_helper_code ?? ''));

		if ($this->usesDatabaseFeatures($body))
		{
			if ($code === '')
			{
				$code = 'use Joomla\\Database\\DatabaseAwareInterface;' .
					PHP_EOL . 'use Joomla\\Database\\DatabaseAwareTrait;';
			}
			else
			{
				if (!str_contains($code, '\\DatabaseAwareInterface;'))
				{
					$code .= PHP_EOL . 'use Joomla\\Database\\DatabaseAwareInterface;';
				}

				if (!str_contains($code, '\\DatabaseAwareTrait;'))
				{
					$code .= PHP_EOL . 'use Joomla\\Database\\DatabaseAwareTrait;';
				}
			}
		}

		if ($code === '')
		{
			return '';
		}

		return $this->placeholder->update(
			PHP_EOL . $code, $this->contentone->allActive()
		);
	}

	/**
	 * Determine if the helper body uses database features.
	 *
	 * @param  string  $body  The helper class body.
	 *
	 * @return bool
	 * @since  5.1.2
	 */
	protected function usesDatabaseFeatures(string $body): bool
	{
		if ($body === '')
		{
			return false;
		}

		return str_contains($body, '$this->getDatabase(')
			|| str_contains($body, 'use DatabaseAwareTrait;');
	}
}

