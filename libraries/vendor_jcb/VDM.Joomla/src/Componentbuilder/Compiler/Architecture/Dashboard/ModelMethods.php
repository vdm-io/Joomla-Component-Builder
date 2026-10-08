<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Dashboard;


use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Dashboard Model Methods Class.
 * 
 * The dashboard model carries whatever methods the component was built with,
 * and the dashboard view reads back whatever those methods get.
 * 
 * The two belong together: reading the methods is what tells this which data
 * the view has to ask for.
 * 
 * @since 6.1.7
 */
final class ModelMethods
{
	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The names of the methods that load data to the view.
	 *
	 * Null until the methods have been read.
	 *
	 * @var   array|null
	 * @since 6.1.7
	 */
	protected ?array $customData = null;

	/**
	 * Constructor.
	 *
	 * @param Component            $component   The Component Class.
	 * @param Placeholder $placeholder The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Component $component,
		Placeholder $placeholder)
	{
		$this->component = $component;
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the methods the dashboard model was built with.
	 *
	 * A component that was given none gets none, and nothing to read back.
	 *
	 * @return  string  The methods.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		if ($this->component->isString('php_dashboard_methods'))
		{
			// get hte value
			$php_dashboard_methods = $this->component->get('php_dashboard_methods');
			// get all the mothods that should load date to the view
			$this->customData
				= GetHelper::allBetween(
				$php_dashboard_methods,
				'public function get', '()'
			);

			// return the methods
			return PHP_EOL . PHP_EOL . $this->placeholder->update_(
					$php_dashboard_methods
				);
		}

		return '';
	}

	/**
	 * Build the custom data the dashboard was built to show.
	 *
	 * Every method found above is asked for its data, once.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	public function customData(): string
	{
		if ($this->customData !== null
			&& ArrayHelper::check(
				$this->customData
			))
		{
			// gets array reset
			$gets = [];
			// set dashboard gets
			foreach ($this->customData as $get)
			{
				$string = StringHelper::safe($get);
				$gets[] = "\$this->" . $string . " = \$this->get('" . $get
					. "');";
			}

			// return the gets
			return PHP_EOL . Indent::_(2) . implode(
					PHP_EOL . Indent::_(2), $gets
				);
		}

		return '';
	}

	/**
	 * The names of the methods that load data to the view.
	 *
	 * @return  array|null  The names, or null when they have not been read.
	 *
	 * @since   6.1.7
	 */
	public function names(): ?array
	{
		return $this->customData;
	}
}

