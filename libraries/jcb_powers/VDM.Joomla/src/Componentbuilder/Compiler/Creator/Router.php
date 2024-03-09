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


use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Request;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Router as Builder;
use VDM\Joomla\Componentbuilder\Compiler\Creator\RouterConstructorDefault as DefaultConstructor;
use VDM\Joomla\Componentbuilder\Compiler\Creator\RouterConstructorManual as ManualConstructor;
use VDM\Joomla\Componentbuilder\Compiler\Creator\RouterMethodsDefault as DefaultMethods;
use VDM\Joomla\Componentbuilder\Compiler\Creator\RouterMethodsManual as ManualMethods;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Router Creator Class
 * 
 * @since 3.2.0
 */
final class Router
{
	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * The Request Class.
	 *
	 * @var   Request
	 * @since 3.2.0
	 */
	protected Request $request;

	/**
	 * The Router Class.
	 *
	 * @var   Builder
	 * @since 3.2.0
	 */
	protected Builder $builder;

	/**
	 * The RouterConstructorDefault Class.
	 *
	 * @var   DefaultConstructor
	 * @since 3.2.0
	 */
	protected DefaultConstructor $defaultconstructor;

	/**
	 * The RouterConstructorManual Class.
	 *
	 * @var   ManualConstructor
	 * @since 3.2.0
	 */
	protected ManualConstructor $manualconstructor;

	/**
	 * The RouterMethodsDefault Class.
	 *
	 * @var   DefaultMethods
	 * @since 3.2.0
	 */
	protected DefaultMethods $defaultmethods;

	/**
	 * The RouterMethodsManual Class.
	 *
	 * @var   ManualMethods
	 * @since 3.2.0
	 */
	protected ManualMethods $manualmethods;

	/**
	 * The Router Build Mode Before Parent Construct.
	 *
	 * @var   int|null
	 * @since 3.2.0
	 */
	protected ?int $mode_before = null;

	/**
	 * The Router Build Mode Methods.
	 *
	 * @var   int|null
	 * @since 3.2.0
	 */
	protected ?int $mode_method = null;

	/**
	 * Constructor.
	 *
	 * @param Dispenser            $dispenser            The Dispenser Class.
	 * @param Request              $request              The Request Class.
	 * @param Builder              $builder              The Router Class.
	 * @param DefaultConstructor   $defaultconstructor   The RouterConstructorDefault Class.
	 * @param ManualConstructor    $manualconstructor    The RouterConstructorManual Class.
	 * @param DefaultMethods       $defaultmethods       The RouterMethodsDefault Class.
	 * @param ManualMethods        $manualmethods        The RouterMethodsManual Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Dispenser $dispenser, Request $request,
		Builder $builder, DefaultConstructor $defaultconstructor,
		ManualConstructor $manualconstructor,
		DefaultMethods $defaultmethods,
		ManualMethods $manualmethods)
	{
		$this->dispenser = $dispenser;
		$this->request = $request;
		$this->builder = $builder;
		$this->defaultconstructor = $defaultconstructor;
		$this->manualconstructor = $manualconstructor;
		$this->defaultmethods = $defaultmethods;
		$this->manualmethods = $manualmethods;
	}

	/**
	 * Get Constructor Before Parent Call
	 *
	 * @return  string
	 * @since   3.2.0
	 */
	public function getConstructor(): string
	{
		$this->init();

		if ($this->mode_before == 3)
		{
			return $this->dispenser->get(
				'_site_router_', 'constructor_before_parent',
				PHP_EOL . PHP_EOL, null, true
			);
		}

		if ($this->mode_before == 2)
		{
			return $this->manualconstructor->get();
		}

		return $this->defaultconstructor->get();
	}

	/**
	 * Get Constructor After Parent Call
	 *
	 * @return  string
	 * @since   3.2.0
	 */
	public function getConstructorAfterParent(): string
	{
		return $this->dispenser->get(
			'_site_router_', 'constructor_after_parent',
			PHP_EOL . PHP_EOL, null, true
		);
	}

	/**
	 * Get Methods
	 *
	 * @return  string
	 * @since   3.2.0
	 */
	public function getMethods(): string
	{
		$this->init();

		if ($this->mode_method == 0)
		{
			return '';
		}

		if ($this->mode_method == 3)
		{
			return $this->dispenser->get(
				'_site_router_', 'methods',
				PHP_EOL . PHP_EOL, null, true
			);
		}

		if ($this->mode_before == 2 && $this->mode_method == 1)
		{
			return $this->manualmethods->get();
		}

		if ($this->mode_method == 1)
		{
			return $this->defaultmethods->get();
		}

		return '';
	}

	/**
	 * Get Constructor Before Parent Call
	 *
	 * @return  void
	 * @since   3.2.0
	 */
	private function init(): void
	{
		if ($this->mode_before === null)
		{
			$this->mode_before = (int) $this->builder->get('mode_before', 0);
			$this->mode_method = (int) $this->builder->get('mode_method', 0);

			$this->updateKeys();
		}
	}

	/**
	 * Update the keys
	 *
	 * @return  void
	 * @since   3.2.0
	 */
	private function updateKeys(): void
	{
		if (($requests = $this->request->allActive()) === [] ||
			($views = $this->builder->get('views')) === null)
		{
			return;
		}

		foreach ($views as &$router)
		{
			// if the key is null, and not 'id'
			// then we must not update it
			// since this is a list view and
			// should not add an ID as key value
			if ($router->key === 'id')
			{
				foreach ($requests as $key => $request)
				{
					if (isset($request[$router->view]))
					{
						$router->key = $key;
					}
				}
			}
		}

		unset($router);

		$this->request->set('views', $views);
	}
}

