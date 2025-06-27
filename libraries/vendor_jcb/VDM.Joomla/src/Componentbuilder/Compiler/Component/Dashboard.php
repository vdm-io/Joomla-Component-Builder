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
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Component Dynamic Dashboard
 * 
 * @since 3.2.0
 */
final class Dashboard
{
	/**
	 * Compiler Registry
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Component
	 *
	 * @var   Component
	 * @since 3.2.0
	 */
	protected Component $component;

	/**
	 * Joomla Application
	 *
	 * @var   CMSApplication
	 * @since 3.2.0
	 */
	protected CMSApplication $app;

	/**
	 * Supported Dashboard Target Types
	 *
	 * @var   array<string, array<string, string>>
	 * @since 5.1.1
	 */
	protected const DASHBOARD_TARGETS = [
		'A' => [
			'viewsKey' => 'admin_views',
			'typeKey' => 'adminview',
			'name' => 'admin view',
			'settingsKey' => 'name_list',
		],
		'C' => [
			'viewsKey' => 'custom_admin_views',
			'typeKey' => 'customadminview',
			'name' => 'custom admin view',
			'settingsKey' => 'code',
		],
	];

	/**
	 * Constructor
	 *
	 * @param Registry             $registry   The registry instance.
	 * @param Component            $component  The component instance.
	 * @param CMSApplication|null  $app        The application instance.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Registry $registry, Component $component, ?CMSApplication $app = null)
	{
		$this->registry  = $registry;
		$this->component = $component;
		$this->app	   = $app ?? Factory::getApplication();
	}

	/**
	 * Set the Dynamic Dashboard
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(): void
	{
		if (!$this->isDynamicDashboardEnabled())
		{
			return;
		}

		$rawDashboard = (string) $this->component->get('dashboard');

		if (!$this->isValidDashboardFormat($rawDashboard))
		{
			$this->notifyInvalidDashboard($rawDashboard);
			return;
		}

		[$targetKey, $identifier] = explode('_', $rawDashboard, 2);
		$targetKey = strtoupper($targetKey);

		if (!isset(self::DASHBOARD_TARGETS[$targetKey]))
		{
			$this->notifyInvalidDashboard($rawDashboard);
			return;
		}

		$this->handleDashboardTarget($targetKey, $identifier, $rawDashboard);
	}

	/**
	 * Check if dynamic dashboard is enabled.
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function isDynamicDashboardEnabled(): bool
	{
		return (int) $this->component->get('dashboard_type', 0) === 2
			&& $this->component->get('dashboard') !== null;
	}

	/**
	 * Validate the dashboard format (e.g., "A_23" or "C_abcd1234").
	 *
	 * @param string $dashboard The dashboard value.
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function isValidDashboardFormat(string $dashboard): bool
	{
		return StringHelper::check($dashboard) && strpos($dashboard, '_') !== false;
	}

	/**
	 * Process the dashboard target and attempt to set it in the registry.
	 *
	 * @param string $key		  The dashboard type key (e.g. A or C).
	 * @param string $identifier   The numeric ID or GUID string.
	 * @param string $rawDashboard The original dashboard string value.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function handleDashboardTarget(string $key, string $identifier, string $rawDashboard): void
	{
		$target = self::DASHBOARD_TARGETS[$key];

		$views = $this->component->get($target['viewsKey']);

		if (!ArrayHelper::check($views))
		{
			$this->notifyDashboardNotFound($target['name'], $rawDashboard, $target['viewsKey']);
			return;
		}

		$matchedView = $this->findViewByIdentifier((array) $views, $target['typeKey'], $identifier);

		if ($matchedView !== null && isset($matchedView['settings']->{$target['settingsKey']}))
		{
			$this->registry->set('build.dashboard', StringHelper::safe($matchedView['settings']->{$target['settingsKey']}));
			$this->registry->set('build.dashboard.type', $target['viewsKey']);

			$this->component->remove('dashboard_tab');
			$this->component->remove('php_dashboard_methods');
		}
		else
		{
			$this->notifyDashboardNotFound($target['name'], $rawDashboard, $target['viewsKey']);
		}
	}

	/**
	 * Find a matching view by numeric ID or GUID.
	 *
	 * @param array<string, mixed> $views	   List of views to search.
	 * @param string			   $field	   Field name to match (e.g. adminview or customadminview).
	 * @param string			   $identifier  ID or GUID string.
	 *
	 * @return array<string, mixed>|null
	 * @since  5.1.1
	 */
	protected function findViewByIdentifier(array $views, string $field, string $identifier): ?array
	{
		foreach ($views as $view)
		{
			if (isset($view[$field]) && (string) $view[$field] === $identifier)
			{
				return $view;
			}
		}

		return null;
	}

	/**
	 * Notify that the dashboard configuration is invalid.
	 *
	 * @param string $dashboard The invalid dashboard value.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function notifyInvalidDashboard(string $dashboard): void
	{
		$this->app->enqueueMessage(Text::_('COM_COMPONENTBUILDER_HR_HTHREEDASHBOARD_ERRORHTHREE'), 'Error');
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_VALUE_FOR_THE_DYNAMIC_DASHBOARD_IS_INVALID', $dashboard),
			'Error'
		);
	}

	/**
	 * Notify that the configured dashboard target is not found.
	 *
	 * @param string $name		Name of the dashboard type.
	 * @param string $dashboard   Dashboard value.
	 * @param string $typeKey	 The internal registry key (e.g. admin_views).
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function notifyDashboardNotFound(string $name, string $dashboard, string $typeKey): void
	{
		$this->app->enqueueMessage(Text::_('COM_COMPONENTBUILDER_HR_HTHREEDASHBOARD_ERRORHTHREE'), 'Error');
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_BSB_IS_NOT_AVAILABLE_IN_YOUR_COMPONENT_PLEASE_INSURE_TO_ONLY_USED_S_FOR_A_DYNAMIC_DASHBOARD_THAT_ARE_STILL_LINKED_TO_YOUR_COMPONENT',
				$name,
				$dashboard,
				StringHelper::safe($typeKey, 'w')
			),
			'Error'
		);
	}
}

