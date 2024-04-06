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

namespace VDM\Joomla\Componentbuilder\Power;


use VDM\Joomla\Componentbuilder\Power\Generator\ClassInjectorBuilder as ClassInjector;
use VDM\Joomla\Componentbuilder\Power\Generator\ServiceProviderBuilder as ServiceProvider;


/**
 * Power code Generator of JCB
 * 
 * @since 3.2.0
 */
final class Generator
{
	/**
	 * The ClassInjectorBuilder Class.
	 *
	 * @var   ClassInjector
	 * @since 3.2.0
	 */
	protected ClassInjector $classinjector;

	/**
	 * The ServiceProviderBuilder Class.
	 *
	 * @var   ServiceProvider
	 * @since 3.2.0
	 */
	protected ServiceProvider $serviceprovider;

	/**
	 * Constructor.
	 *
	 * @param ClassInjector     $classinjector     The ClassInjectorBuilder Class.
	 * @param ServiceProvider   $serviceprovider   The ServiceProviderBuilder Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(ClassInjector $classinjector, ServiceProvider $serviceprovider)
	{
		$this->classinjector = $classinjector;
		$this->serviceprovider = $serviceprovider;
	}

	/**
	 * Get the class code.
	 *
	 * @param array        $power    The power being saved
	 *
	 * @return string|null
	 * @since 3.2.0
	 */
	public function get(array $power): ?string
	{
		// create dependency injection (when the main_class_code is empty)
		if (empty($power['main_class_code']) && !empty($power['use_selection']) && is_array($power['use_selection']))
		{
			if (strpos($power['implements_custom'], 'ServiceProviderInterface') !== false)
			{
				if (($code = $this->serviceprovider->getCode($power)) !== null)
				{
					return $code;
				}
			}
			elseif (($code = $this->classinjector->getCode($power)) !== null)
			{
				return $code;
			}
		}

		return null;
	}
}

