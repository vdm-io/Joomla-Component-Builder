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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Builder\Router;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Router Constructor Default Creator Class
 * 
 * @since 3.2.0
 */
final class RouterConstructorManual
{
	/**
	 * The Router Class.
	 *
	 * @var   Router
	 * @since 3.2.0
	 */
	protected Router $router;

	/**
	 * Constructor.
	 *
	 * @param Router    $router    The Router Class.
	 *
	 * @since  3.2.0
	 */
	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	/**
	 * Get Construct Code (SOON)
	 *
	 * @return  string
	 * @since   3.2.0
	 */
	public function get(): string
	{
		$views = $this->router->get('views');
		if ($views !== null)
		{
			$code = [];
			foreach ($views as $view)
			{
				$code[] = '';
				$code[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Add the ({$view->view}:view) router configuration";
				$code[] = Indent::_(2) . "\${$view->view} = new RouterViewConfiguration('{$view->view}');";
				// add key only if we have one see: ...Compiler\Creator\Router->updateKeys();
				if (!empty($view->key) && !empty($view->alias))
				{
					$code[] = Indent::_(2) . "\${$view->view}->setKey('{$view->key}');";
				}
				$code[] = Indent::_(2) . "\$this->registerView(\${$view->view});";
			}
			return PHP_EOL . implode(PHP_EOL, $code);
		}
		return '';
	}
}

