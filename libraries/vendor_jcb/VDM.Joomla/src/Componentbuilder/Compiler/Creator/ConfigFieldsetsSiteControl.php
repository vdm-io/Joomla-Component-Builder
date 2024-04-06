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


use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HasMenuGlobal;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FrontendParams;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Request;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Config Fieldsets Site Control Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsSiteControl
{
	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 3.2.0
	 */
	protected Component $component;

	/**
	 * The ConfigFieldsets Class.
	 *
	 * @var   ConfigFieldsets
	 * @since 3.2.0
	 */
	protected ConfigFieldsets $configfieldsets;

	/**
	 * The ConfigFieldsetsCustomfield Class.
	 *
	 * @var   Customfield
	 * @since 3.2.0
	 */
	protected Customfield $customfield;

	/**
	 * The HasMenuGlobal Class.
	 *
	 * @var   HasMenuGlobal
	 * @since 3.2.0
	 */
	protected HasMenuGlobal $hasmenuglobal;

	/**
	 * The FrontendParams Class.
	 *
	 * @var   FrontendParams
	 * @since 3.2.0
	 */
	protected FrontendParams $frontendparams;

	/**
	 * The Request Class.
	 *
	 * @var   Request
	 * @since 3.2.0
	 */
	protected Request $request;

	/**
	 * Constructor.
	 *
	 * @param Component         $component         The Component Class.
	 * @param ConfigFieldsets   $configfieldsets   The ConfigFieldsets Class.
	 * @param Customfield       $customfield       The ConfigFieldsetsCustomfield Class.
	 * @param HasMenuGlobal     $hasmenuglobal     The HasMenuGlobal Class.
	 * @param FrontendParams    $frontendparams    The FrontendParams Class.
	 * @param Request           $request           The Request Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Component $component, ConfigFieldsets $configfieldsets,
		Customfield $customfield, HasMenuGlobal $hasmenuglobal,
		FrontendParams $frontendparams, Request $request)
	{
		$this->component = $component;
		$this->configfieldsets = $configfieldsets;
		$this->customfield = $customfield;
		$this->hasmenuglobal = $hasmenuglobal;
		$this->frontendparams = $frontendparams;
		$this->request = $request;
	}

	/**
	 * Set Site Control Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 3.2.0
	 */
	public function set(string $lang): void
	{
		$front_end = [];
		// do quick build of front-end views
		if ($this->component->isArray('site_views'))
		{
			// load the names only to link the page params
			foreach ($this->component->get('site_views') as $siteView)
			{
				// now load the view name to the front-end array
				$front_end[] = $siteView['settings']->name;
			}
		}

		// add frontend view stuff including menus
		if ($this->customfield->isActive())
		{
			foreach ($this->customfield->allActive() as $tab => $tabFields)
			{
				$tabCode  = StringHelper::safe($tab) . '_custom_config';
				$tabUpper = StringHelper::safe($tab, 'U');
				$tabLower = StringHelper::safe($tab);

				// load the request id setters for menu views
				$viewRequest = 'name="' . $tabLower . '_request_id';
				foreach ($tabFields as $et => $id_field)
				{
					if (strpos((string) $id_field, $viewRequest) !== false)
					{
						$this->request->set(
							$tabLower, $id_field, $viewRequest, 'id'
						);
						$this->customfield->remove("$tab.$et");
						unset($tabFields[$et]);
					}
					elseif (strpos((string) $id_field, '_request_id') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequest = GetHelper::between(
							$id_field, 'name="', '_request_id'
						);
						$searchIdKe   = 'name="' . $_viewRequest
							. '_request_id';
						$this->request->set(
							$_viewRequest, $id_field, $searchIdKe, 'id'
						);
						$this->customfield->remove("$tab.$et");
						unset($tabFields[$et]);
					}
				}

				// load the request catid setters for menu views
				$viewRequestC = 'name="' . $tabLower . '_request_catid';
				foreach ($tabFields as $ci => $catid_field)
				{
					if (strpos((string) $catid_field, $viewRequestC) !== false)
					{

						$this->request->set(
							$tabLower, $catid_field, $viewRequestC, 'catid'
						);
						$this->customfield->remove("$tab.$ci");
						unset($tabFields[$ci]);
					}
					elseif (strpos((string) $catid_field, '_request_catid') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequestC = GetHelper::between(
							$catid_field, 'name="', '_request_catid'
						);
						$searchCatidKe = 'name="' . $_viewRequestC
							. '_request_catid';
						$this->request->set(
							$_viewRequestC, $catid_field, $searchCatidKe, 'catid'
						);
						$this->customfield->remove("$tab.$ci");
						unset($tabFields[$ci]);
					}
				}

				// load the global menu setters for single fields
				$menuSetter   = $tabLower . '_menu';
				$pageSettings = [];
				foreach ($tabFields as $ct => $field)
				{
					if (strpos((string) $field, $menuSetter) !== false)
					{
						// set the values needed to insure route is done correclty
						$this->hasmenuglobal->set($tabLower, $menuSetter);
					}
					elseif (strpos((string) $field, '_menu"') !== false)
					{
						// not loaded to a tab "view" name
						$_tabLower = GetHelper::between(
							$field, 'name="', '_menu"'
						);
						// set the values needed to insure route is done correclty
						$this->hasmenuglobal->set($_tabLower, $_tabLower . '_menu');
					}
					else
					{
						$pageSettings[$ct] = $field;
					}
				}

				// insure we load the needed params
				if (in_array($tab, $front_end))
				{
					$this->frontendparams->set($tab, $pageSettings);
				}
			}
		}
	}
}

