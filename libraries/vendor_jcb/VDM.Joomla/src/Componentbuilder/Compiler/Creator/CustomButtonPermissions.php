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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionComponent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Custom Button Permissions Creator Class
 * 
 * @since 3.2.0
 */
final class CustomButtonPermissions
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The PermissionComponent Class.
	 *
	 * @var   PermissionComponent
	 * @since 3.2.0
	 */
	protected PermissionComponent $permissioncomponent;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Constructor.
	 *
	 * @param Config                $config                The Config Class.
	 * @param Language              $language              The Language Class.
	 * @param PermissionComponent   $permissioncomponent   The PermissionComponent Class.
	 * @param Counter               $counter               The Counter Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language,
		PermissionComponent $permissioncomponent,
		Counter $counter)
	{
		$this->config = $config;
		$this->language = $language;
		$this->permissioncomponent = $permissioncomponent;
		$this->counter = $counter;
	}

	/**
	 * Add Custom Button Permissions
	 *
	 * @param object    $settings    The view settings
	 * @param string    $nameView    The view name
	 * @param string    $code        The view code name.
	 *
	 * @since 3.2.0
	 */
	public function add(object $settings, string $nameView, string $code): void
	{
		// add the custom permissions to use the buttons of this view
		if (isset($settings->custom_buttons)
			&& ArrayHelper::check($settings->custom_buttons))
		{
			foreach ($settings->custom_buttons as $custom_buttons)
			{
				$customButtonName  = $custom_buttons['name'];
				$customButtonCode  = StringHelper::safe(
					$customButtonName
				);
				$customButtonTitle = $this->config->lang_prefix . '_'
					. StringHelper::safe(
						$nameView . ' ' . $customButtonName . ' Button Access',
						'U'
					);
				$customButtonDesc  = $this->config->lang_prefix . '_'
					. StringHelper::safe(
						$nameView . ' ' . $customButtonName . ' Button Access',
						'U'
					) . '_DESC';
				$sortButtonKey     = StringHelper::safe(
					$nameView . ' ' . $customButtonName . ' Button Access'
				);

				$this->language->set(
					'bothadmin', $customButtonTitle,
					$nameView . ' ' . $customButtonName . ' Button Access'
				);

				$this->language->set(
					'bothadmin', $customButtonDesc,
					' Allows the users in this group to access the '
					. StringHelper::safe($customButtonName, 'w')
					. ' button.'
				);

				$this->permissioncomponent->set($sortButtonKey, [
					'name' => "$code.$customButtonCode",
					'title' => $customButtonTitle,
					'description' => $customButtonDesc
				]);

				// the size needs increase
				$this->counter->accessSize++;
			}
		}
	}
}

