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

namespace VDM\Joomla\Componentbuilder\Compiler\Component;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Component Dynamic Dashboard
 * 
 * @since 3.2.0
 */
class Dashboard
{
	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Component
	 *
	 * @var    Component
	 * @since 3.2.0
	 **/
	protected Component $component;

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor
	 *
	 * @param Registry|null           $registry     The compiler registry object.
	 * @param Component|null          $component    The component class.
	 * @param CMSApplication|null     $app          The app object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Registry $registry = null, ?Component $component = null,
		?CMSApplication $app = null)
	{
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->component = $component ?: Compiler::_('Component');
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Set the Dynamic Dashboard
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set()
	{
		// only add the dynamic dashboard if all checks out
		if ($this->component->get('dashboard_type', 0) == 2
			&& ($dashboard_ = $this->component->get('dashboard')) !== null
			&& StringHelper::check($dashboard_)
			&& strpos((string) $dashboard_, '_') !== false)
		{
			// set the default view
			$getter = explode('_', (string) $dashboard_);
			if (count((array) $getter) == 2 && is_numeric($getter[1]))
			{
				// the pointers
				$t  = StringHelper::safe($getter[0], 'U');
				$id = (int) $getter[1];

				// the dynamic stuff
				$targets = array('A' => 'admin_views',
				                 'C' => 'custom_admin_views');
				$names   = array('A' => 'admin view',
				                 'C' => 'custom admin view');
				$types   = array('A' => 'adminview', 'C' => 'customadminview');
				$keys    = array('A' => 'name_list', 'C' => 'code');

				// check the target values
				if (isset($targets[$t]) && $id > 0)
				{
					// set the type name
					$type_names = StringHelper::safe(
						$targets[$t], 'w'
					);
					// set the dynamic dash
					if (($target_ = $this->component->get($targets[$t])) !== null
						&& ArrayHelper::check($target_))
					{
						// search the target views
						$dashboard = (array) array_filter(
							$target_,
							function ($view) use ($id, $t, $types) {
								if (isset($view[$types[$t]])
									&& $id == $view[$types[$t]])
								{
									return true;
								}

								return false;
							}
						);

						// set dashboard
						if (ArrayHelper::check($dashboard))
						{
							$dashboard = array_values($dashboard)[0];
						}

						// check if view was found (this should be true)
						if (isset($dashboard['settings'])
							&& isset($dashboard['settings']->{$keys[$t]}))
						{
							$this->registry->set('build.dashboard',
								StringHelper::safe(
									$dashboard['settings']->{$keys[$t]}
								)
							);
							$this->registry->set('build.dashboard.type',
								$targets[$t]
							);
						}
						else
						{
							// set massage that something is wrong
							$this->app->enqueueMessage(
								Text::_('COM_COMPONENTBUILDER_HR_HTHREEDASHBOARD_ERRORHTHREE'),
								'Error'
							);
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_BSB_IS_NOT_AVAILABLE_IN_YOUR_COMPONENT_PLEASE_INSURE_TO_ONLY_USED_S_FOR_A_DYNAMIC_DASHBOARD_THAT_ARE_STILL_LINKED_TO_YOUR_COMPONENT',
									$names[$t], $dashboard_,
									$type_names
								), 'Error'
							);
						}
					}
					else
					{
						// set massage that something is wrong
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEDASHBOARD_ERRORHTHREE'), 'Error'
						);
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_BSB_IS_NOT_AVAILABLE_IN_YOUR_COMPONENT_PLEASE_INSURE_TO_ONLY_USED_S_FOR_A_DYNAMIC_DASHBOARD_THAT_ARE_STILL_LINKED_TO_YOUR_COMPONENT',
								$names[$t], $dashboard_,
								$type_names
							), 'Error'
						);
					}
				}
				else
				{
					// the target value is wrong
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREEDASHBOARD_ERRORHTHREE'), 'Error'
					);
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_VALUE_FOR_THE_DYNAMIC_DASHBOARD_IS_INVALID',
							$dashboard_
						), 'Error'
					);
				}
			}
			else
			{
				// the target value is wrong
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREEDASHBOARD_ERRORHTHREE'), 'Error'
				);
				$this->app->enqueueMessage(
					Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_VALUE_FOR_THE_DYNAMIC_DASHBOARD_IS_INVALID',
						$dashboard_
					), 'Error'
				);
			}

			// if default was changed to dynamic dashboard the remove default tab and methods
			if ($this->registry->get('build.dashboard'))
			{
				// dynamic dashboard is used
				$this->component->remove('dashboard_tab');
				$this->component->remove('php_dashboard_methods');
			}
		}
	}

}

