<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\CustomView;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\DisplayMethod as ExtendingDisplayMethod;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView\DisplayMethodInterface;


/**
 * Custom View Display Method Class for Joomla 3.
 * 
 * @since  6.1.7
 */
final class DisplayMethod extends ExtendingDisplayMethod implements DisplayMethodInterface
{
	/**
	 * Get the generated event-dispatcher initialization lines.
	 *
	 * @return  string  The generated dispatcher lines.
	 *
	 * @since   6.1.7
	 */
	protected function getDispatcherInit(): string
	{
		return $this->getLegacyDispatcherInit();
	}

	/**
	 * Get the generated single-item retrieval line.
	 *
	 * Joomla 3 retrieves through the view's own get() proxy.
	 *
	 * @return  string  The generated item line.
	 *
	 * @since   6.1.7
	 */
	protected function getItem(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$this->item = \$this->get('Item');";
	}

	/**
	 * Get the generated list-items retrieval line.
	 *
	 * @return  string  The generated items line.
	 *
	 * @since   6.1.7
	 */
	protected function getItems(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$this->items = \$this->get('Items');";
	}

	/**
	 * Get the generated pagination retrieval line.
	 *
	 * @return  string  The generated pagination line.
	 *
	 * @since   6.1.7
	 */
	protected function getPagination(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$this->pagination = \$this->get('Pagination');";
	}

	/**
	 * Get the generated custom Dynamic Get retrieval line.
	 *
	 * @param   string  $name    The custom get name without its get prefix.
	 * @param   string  $method  The complete custom get method name.
	 *
	 * @return  string  The generated custom get line.
	 *
	 * @since   6.1.7
	 */
	protected function getCustomGet(string $name, string $method): string
	{
		return PHP_EOL . Indent::_(2) . "\$this->"
			. StringHelper::safe($name)
			. " = \$this->get('" . $name . "');";
	}

	/**
	 * Get the generated custom-admin document lines.
	 *
	 * @return  string  The generated document lines.
	 *
	 * @since   6.1.7
	 */
	protected function getSetDocument(): string
	{
		$method = PHP_EOL . PHP_EOL . Indent::_(2) . "//"
			. Line::_(__Line__, __Class__) . " set the document";
		$method .= PHP_EOL . Indent::_(2) . "\$this->setDocument();";

		return $method;
	}

	/**
	 * Get the generated error-check condition line.
	 *
	 * @return  string  The generated error-check line.
	 *
	 * @since   6.1.7
	 */
	protected function getErrorsCheck(): string
	{
		return PHP_EOL . Indent::_(2)
			. "if (count(\$errors = \$model->get('Errors')))";
	}

	/**
	 * Get the generated content plugin event trigger lines.
	 *
	 * @param   string  $pluginEvent  The plugin event name.
	 * @param   string  $context      The view context.
	 *
	 * @return  string  The generated event trigger lines.
	 *
	 * @since   6.1.7
	 */
	protected function getPluginEvent(string $pluginEvent, string $context): string
	{
		return $this->getLegacyPluginEvent($pluginEvent, $context);
	}
}

