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


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder as ComponentPlaceholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Field as Field;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name as FieldName;
use VDM\Joomla\Componentbuilder\Compiler\Field\UniqueName;
use VDM\Joomla\Componentbuilder\Compiler\Model\Filesfolders;
use VDM\Joomla\Componentbuilder\Compiler\Model\Historycomponent;
use VDM\Joomla\Componentbuilder\Compiler\Model\Whmcs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sqltweaking;
use VDM\Joomla\Componentbuilder\Compiler\Model\Adminviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Siteviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customadminviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Updateserver;
use VDM\Joomla\Componentbuilder\Compiler\Model\Joomlamodules;
use VDM\Joomla\Componentbuilder\Compiler\Model\Joomlaplugins;
use VDM\Joomla\Componentbuilder\Compiler\Model\Router;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Compiler Component Data
 * 
 * @since 3.2.0
 */
final class Data
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Placeholder Class.
	 *
	 * @var   ComponentPlaceholder
	 * @since 3.2.0
	 */
	protected ComponentPlaceholder $componentplaceholder;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Gui Class.
	 *
	 * @var   Gui
	 * @since 3.2.0
	 */
	protected Gui $gui;

	/**
	 * The Field Class.
	 *
	 * @var   Field
	 * @since 3.2.0
	 */
	protected Field $field;

	/**
	 * The Name Class.
	 *
	 * @var   FieldName
	 * @since 3.2.0
	 */
	protected FieldName $fieldname;

	/**
	 * The UniqueName Class.
	 *
	 * @var   UniqueName
	 * @since 3.2.0
	 */
	protected UniqueName $uniquename;

	/**
	 * The Filesfolders Class.
	 *
	 * @var   Filesfolders
	 * @since 3.2.0
	 */
	protected Filesfolders $filesfolders;

	/**
	 * The History Component Class.
	 *
	 * @var   Historycomponent
	 * @since 3.2.0
	 */
	protected Historycomponent $history;

	/**
	 * The Whmcs Class.
	 *
	 * @var   Whmcs
	 * @since 3.2.0
	 */
	protected Whmcs $whmcs;

	/**
	 * The Sqltweaking Class.
	 *
	 * @var   Sqltweaking
	 * @since 3.2.0
	 */
	protected Sqltweaking $sqltweaking;

	/**
	 * The Adminviews Class.
	 *
	 * @var   Adminviews
	 * @since 3.2.0
	 */
	protected Adminviews $adminviews;

	/**
	 * The Siteviews Class.
	 *
	 * @var   Siteviews
	 * @since 3.2.0
	 */
	protected Siteviews $siteviews;

	/**
	 * The Customadminviews Class.
	 *
	 * @var   Customadminviews
	 * @since 3.2.0
	 */
	protected Customadminviews $customadminviews;

	/**
	 * The Updateserver Class.
	 *
	 * @var   Updateserver
	 * @since 3.2.0
	 */
	protected Updateserver $updateserver;

	/**
	 * The Joomlamodules Class.
	 *
	 * @var   Joomlamodules
	 * @since 3.2.0
	 */
	protected Joomlamodules $modules;

	/**
	 * The Joomlaplugins Class.
	 *
	 * @var   Joomlaplugins
	 * @since 3.2.0
	 */
	protected Joomlaplugins $plugins;

	/**
	 * The Router Class.
	 *
	 * @var   Router
	 * @since 3.2.0
	 */
	protected Router $router;

	/**
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * Constructor.
	 *
	 * @param Config                 $config                 The Config Class.
	 * @param Event                  $event                  The EventInterface Class.
	 * @param Placeholder            $placeholder            The Placeholder Class.
	 * @param ComponentPlaceholder   $componentplaceholder   The Placeholder Class.
	 * @param Dispenser              $dispenser              The Dispenser Class.
	 * @param Customcode             $customcode             The Customcode Class.
	 * @param Gui                    $gui                    The Gui Class.
	 * @param Field                  $field                  The Field Class.
	 * @param FieldName              $fieldname              The Name Class.
	 * @param UniqueName             $uniquename             The UniqueName Class.
	 * @param Filesfolders           $filesfolders           The Filesfolders Class.
	 * @param Historycomponent       $historycomponent       The Historycomponent Class.
	 * @param Whmcs                  $whmcs                  The Whmcs Class.
	 * @param Sqltweaking            $sqltweaking            The Sqltweaking Class.
	 * @param Adminviews             $adminviews             The Adminviews Class.
	 * @param Siteviews              $siteviews              The Siteviews Class.
	 * @param Customadminviews       $customadminviews       The Customadminviews Class.
	 * @param Updateserver           $updateserver           The Updateserver Class.
	 * @param Joomlamodules          $joomlamodules          The Joomlamodules Class.
	 * @param Joomlaplugins          $joomlaplugins          The Joomlaplugins Class.
	 * @param Router                 $router                 The Router Class.
	 * @param DatabaseInterface      $db                     The Joomla Database Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Event $event, Placeholder $placeholder,
		ComponentPlaceholder $componentplaceholder,
		Dispenser $dispenser, Customcode $customcode, Gui $gui,
		Field $field, FieldName $fieldname,
		UniqueName $uniquename, Filesfolders $filesfolders,
		Historycomponent $historycomponent, Whmcs $whmcs,
		Sqltweaking $sqltweaking, Adminviews $adminviews,
		Siteviews $siteviews, Customadminviews $customadminviews,
		Updateserver $updateserver, Joomlamodules $joomlamodules,
		Joomlaplugins $joomlaplugins, Router $router, DatabaseInterface $db)
	{
		$this->config = $config;
		$this->event = $event;
		$this->placeholder = $placeholder;
		$this->componentplaceholder = $componentplaceholder;
		$this->dispenser = $dispenser;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->field = $field;
		$this->fieldname = $fieldname;
		$this->uniquename = $uniquename;
		$this->filesfolders = $filesfolders;
		$this->history = $historycomponent;
		$this->whmcs = $whmcs;
		$this->sqltweaking = $sqltweaking;
		$this->adminviews = $adminviews;
		$this->siteviews = $siteviews;
		$this->customadminviews = $customadminviews;
		$this->updateserver = $updateserver;
		$this->modules = $joomlamodules;
		$this->plugins = $joomlaplugins;
		$this->router = $router;
		$this->db = $db;
	}

	/**
	 * get current component data
	 *
	 * @return  object|null The component data
	 * @since 3.2.0
	 */
	public function get(): ?object
	{
		// get the full query for the selected component
		$query = $this->getQuery();

		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);

		// Load the results as a stdClass objects
		$component = $this->db->loadObject();

		// make sure we got a component loaded
		if (empty($component) || !is_object($component) || !isset($component->system_name))
		{
			return null;
		}

		// Trigger Event: jcb_ce_onBeforeModelComponentData
		$this->event->trigger(
			'jcb_ce_onBeforeModelComponentData',
			[&$component]
		);

		// load the global placeholders
		$this->placeholder->active = $this->componentplaceholder->get();

		// transform and load child entities
		$this->energize($component);

		// Trigger Event: jcb_ce_onAfterModelComponentData
		$this->event->trigger(
			'jcb_ce_onAfterModelComponentData',
			[&$component]
		);

		return $component;
	}

	/**
	 * get current component data query
	 *
	 * @return  string  The component data query
	 * @since   5.0.4
	 */
	private function getQuery()
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// selection
		$selection = [
			'b.addadmin_views'                    => 'addadmin_views',
			'b.id'                                => 'addadmin_views_id',
			'h.addconfig'                         => 'addconfig',
			'd.addcustom_admin_views'             => 'addcustom_admin_views',
			'g.addcustommenus'                    => 'addcustommenus',
			'j.addfiles'                          => 'addfiles',
			'j.addfolders'                        => 'addfolders',
			'j.addfilesfullpath'                  => 'addfilesfullpath',
			'j.addfoldersfullpath'                => 'addfoldersfullpath',
			'c.addsite_views'                     => 'addsite_views',
			'l.addjoomla_plugins'                 => 'addjoomla_plugins',
			'k.addjoomla_modules'                 => 'addjoomla_modules',
			'i.dashboard_tab'                     => 'dashboard_tab',
			'i.php_dashboard_methods'             => 'php_dashboard_methods',
			'i.params'                            => 'dashboard_params',
			'i.id'                                => 'component_dashboard_id',
			'f.sql_tweak'                         => 'sql_tweak',
			'e.version_update'                    => 'version_update',
			'e.id'                                => 'version_update_id',
			'm.mode_constructor_before_parent'    => 'router_mode_constructor_before_parent',
			'm.mode_constructor_after_parent'     => 'router_mode_constructor_after_parent',
			'm.mode_methods'                      => 'router_mode_methods',
			'm.constructor_before_parent_code'    => 'router_constructor_before_parent_code',
			'm.constructor_before_parent_manual'  => 'router_constructor_before_parent_manual',
			'm.constructor_after_parent_code'     => 'router_constructor_after_parent_code',
			'm.methods_code'                      => 'router_methods_code'
		];
		$query->select('a.*');
		$query->select(
			$this->db->quoteName(
				array_keys($selection), array_values($selection)
			)
		);

		// from this table
		$query->from('#__componentbuilder_joomla_component AS a');

		// jointer-map
		$joiners = [
			'b' => 'component_admin_views',
			'c' => 'component_site_views',
			'd' => 'component_custom_admin_views',
			'e' => 'component_updates',
			'f' => 'component_mysql_tweaks',
			'g' => 'component_custom_admin_menus',
			'h' => 'component_config',
			'i' => 'component_dashboard',
			'j' => 'component_files_folders',
			'k' => 'component_modules',
			'l' => 'component_plugins',
			'm' => 'component_router'
		];

		// load the joins
		foreach ($joiners as $as => $join)
		{
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_' . $join, $as)
				. ' ON (' . $this->db->quoteName('a.guid') . ' = '
				. $this->db->quoteName($as . '.joomla_component') . ')'
			);
		}
		$query->where(
			$this->db->quoteName('a.id') . ' = ' . (int) $this->config->component_id
		);

		// Trigger Event: jcb_ce_onBeforeQueryComponentData
		$this->event->trigger(
			'jcb_ce_onBeforeQueryComponentData', [&$query, &$this->db]
		);

		return $query;
	}

	/**
	 * Transform the current component data by loading all children.
	 *
	 * This method orchestrates various transformations and settings
	 * on the `$component` object. Since objects in PHP are passed
	 * by reference, all changes to `$component` inside helper
	 * methods directly update the same instance.
	 *
	 * @param  object  $component  The component object containing all the necessary data.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function energize(object $component)
	{
		$this->setComponentNames($component);
		$this->setVersion($component);
		$this->setImagePath($component);
		$this->setGlobalConfig($component);
		$this->setFilesFolders($component);
		$this->setUiKit($component);
		$this->setWhmcs($component);
		$this->setFootable($component);
		$this->setCustomMenus($component);
		$this->setSqlTweaks($component);
		$this->setViews($component);
		$this->setConfigData($component);
		$this->setContributors($component);
		$this->setUpdateServer($component);
		$this->setBuildDate($component);
		$this->setHistory($component);
		$this->setDispenserConfigs($component);
		$this->setSql($component);
		$this->setBom($component);
		$this->setReadMe($component);
		$this->setDashboardMethods($component);
		$this->setServers($component);
		$this->setIgnoreFolders($component);
		$this->setModules($component);
		$this->setPlugins($component);
		$this->setRouter($component);
	}

	/**
	 * Sets the sales name and name code of the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setComponentNames(object $component): void
	{
		$component->sales_name = StringHelper::safe($component->system_name);
		$component->name_code = StringHelper::safe($component->name_code);
	}

	/**
	 * Ensures the component version naming is correct.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setVersion(object $component): void
	{
		$this->config->set(
			'component_version',
			preg_replace('/^v/i', '', (string) $component->component_version)
		);
	}

	/**
	 * Ensures the image field contains only the image path.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setImagePath(object $component): void
	{
		if (strpos($component->image, '#') !== false)
		{
			$component->image = strstr($component->image, '#', true);
		}
	}

	/**
	 * Sets the global configuration for the project website and author.
	 *
	 * Defaults are provided if the website or author fields are not set.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setGlobalConfig(object $component): void
	{
		$this->config->set('project_website', $component->website ?? 'https://dev.vdm.io');
		$this->config->set('project_author', $component->author ?? 'VDM');
	}

	/**
	 * Sets the files and folders configuration for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setFilesFolders(object $component): void
	{
		$this->filesfolders->set($component);
	}

	/**
	 * Configures the UIkit switch for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setUiKit(object $component): void
	{
		$this->config->set('uikit', $component->adduikit);
	}

	/**
	 * Configures WHMCS links for the component if applicable.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setWhmcs(object $component): void
	{
		$this->whmcs->set($component);
	}

	/**
	 * Configures Footable settings for the component.
	 *
	 * If `addfootable` is greater than 0, Footable is enabled, and its version
	 * is set to either 2 or 3 based on the value of `addfootable`.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setFootable(object $component): void
	{
		if ($component->addfootable > 0)
		{
			$this->config->set('footable', true);
			$this->config->set('footable_version', ($component->addfootable == 3) ? 3 : 2);
		}
	}

	/**
	 * Configures custom menus for the component.
	 *
	 * If `addcustommenus` is a valid JSON string, it is decoded and set as
	 * an array in the `custommenus` property. Otherwise, it is unset.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setCustomMenus(object $component): void
	{
		$component->addcustommenus = (isset($component->addcustommenus) && JsonHelper::check($component->addcustommenus))
			? json_decode((string)$component->addcustommenus, true)
			: null;

		if (ArrayHelper::check($component->addcustommenus))
		{
			$component->custommenus = array_values($component->addcustommenus);
		}

		unset($component->addcustommenus);
	}

	/**
	 * Applies SQL tweaking configurations to the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setSqlTweaks(object $component): void
	{
		$this->sqltweaking->set($component);
	}

	/**
	 * Configures admin, site, and custom admin views for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setViews(object $component): void
	{
		$this->adminviews->set($component);
		$this->siteviews->set($component);
		$this->customadminviews->set($component);
	}

	/**
	 * Processes additional configuration data for the component.
	 *
	 * If `addconfig` is a valid JSON string, it is decoded and stored in the `config` property.
	 * Fields are processed and validated, and unique names are set for each field.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setConfigData(object $component): void
	{
		$component->addconfig = (isset($component->addconfig) && JsonHelper::check($component->addconfig))
			? json_decode((string) $component->addconfig, true)
			: null;

		if (ArrayHelper::check($component->addconfig)) {
			$component->config = array_map(function ($field) {
				$field['alias'] = 0;
				$field['title'] = 0;
				$this->field->set($field);
				$this->uniquename->set($field['base_name'], 'configs');
				return $field;
			}, array_values($component->addconfig));

			foreach ($component->config as $field)
			{
				$this->fieldname->get($field, 'configs');
			}

			unset($component->addconfig);
		}
	}

	/**
	 * Processes and sets contributors for the component.
	 *
	 * If `addcontributors` is a valid JSON string, it is decoded and stored in the `contributors` property.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setContributors(object $component): void
	{
		$component->addcontributors = (isset($component->addcontributors) && JsonHelper::check($component->addcontributors))
			? json_decode((string)$component->addcontributors, true)
			: null;

		if (ArrayHelper::check($component->addcontributors))
		{
			$this->config->set('add_contributors', true);
			$component->contributors = array_values(
				$component->addcontributors
			);
		}

		unset($component->addcontributors);
	}

	/**
	 * Configures the update server details for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setUpdateServer(object $component): void
	{
		$this->updateserver->set($component);
	}

	/**
	 * Sets the build date for the component based on creation or modification date.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setBuildDate(object $component): void
	{
		if ($this->config->get('add_build_date', 1) == 3)
		{
			$buildDate = empty($this->component->modified) ||
			$this->component->modified == '0000-00-00' ||
			$this->component->modified == '0000-00-00 00:00:00'
				? $this->component->created
				: $this->component->modified;

			$this->config->set('build_date', $buildDate);
		}
	}

	/**
	 * Applies the history configuration to the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setHistory(object $component): void
	{
		$this->history->set($component);
	}

	/**
	 * Configures dispenser settings for the component.
	 *
	 * This includes settings for JavaScript, CSS, PHP, and SQL files.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setDispenserConfigs(object $component): void
	{
		$gui_mapper = $this->initializeGuiMapper();

		$this->configureJavaScript($component, $gui_mapper);
		$this->configureGlobalCss($component);
		$this->configurePhpScripts($component, $gui_mapper);
		$this->configurePhpHelpers($component, $gui_mapper);
		$this->configureAdminAndSiteEvents($component, $gui_mapper);
	}

	/**
	 * Initializes the GUI mapper configuration.
	 *
	 * @return array The GUI mapper array.
	 * @since  5.0.4
	 */
	private function initializeGuiMapper(): array
	{
		return [
			'table' => 'joomla_component',
			'id'	=> (int) $this->config->component_id,
			'field' => 'javascript',
			'type'  => 'js',
		];
	}

	/**
	 * Configures JavaScript settings for the component.
	 *
	 * @param  object  $component  The component object.
	 * @param  array   $guiMapper  The GUI mapper configuration.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function configureJavaScript(object $component, array $guiMapper): void
	{
		if ($component->add_javascript == 1)
		{
			$this->dispenser->set(
				$component->javascript,
				'component_js',
				null,
				null,
				$guiMapper
			);
		}
		else
		{
			$this->dispenser->hub['component_js'] = '';
		}

		unset($component->javascript);
	}

	/**
	 * Configures global CSS settings for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function configureGlobalCss(object $component): void
	{
		$areas = ['admin', 'site'];

		foreach ($areas as $area)
		{
			$cssKey = 'css_' . $area;
			$addCssKey = 'add_css_' . $area;

			if (isset($component->$addCssKey) && $component->$addCssKey == 1 &&
				isset($component->$cssKey) && StringHelper::check($component->$cssKey))
			{
				$this->dispenser->set($component->$cssKey, 'component_css_' . $area);
			}
			else
			{
				$this->dispenser->hub['component_css_' . $area] = '';
			}

			unset($component->$cssKey);
		}
	}

	/**
	 * Configures PHP script settings for the component.
	 *
	 * @param  object  $component  The component object.
	 * @param  array   $guiMapper  The GUI mapper configuration.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function configurePhpScripts(object $component, array $guiMapper): void
	{
		$scriptMethods = ['php_preflight', 'php_postflight', 'php_method'];
		$scriptTypes = ['install', 'update', 'uninstall'];

		$guiMapper['type'] = 'php';

		foreach ($scriptMethods as $scriptMethod)
		{
			foreach ($scriptTypes as $scriptType)
			{
				$key = $scriptMethod . '_' . $scriptType;
				$addKey = 'add_' . $key;

				if (isset($component->$addKey) && $component->$addKey == 1 &&
					StringHelper::check($component->$key))
				{
					$guiMapper['field'] = $key;

					$this->dispenser->set(
						$component->$key,
						$scriptMethod,
						$scriptType,
						null,
						$guiMapper
					);
				}
				else
				{
					$this->dispenser->hub[$scriptMethod][$scriptType] = '';
				}

				unset($component->$key);
			}
		}
	}

	/**
	 * Configures PHP helper settings for the component.
	 *
	 * @param  object  $component  The component object.
	 * @param  array   $guiMapper  The GUI mapper configuration.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function configurePhpHelpers(object $component, array $guiMapper): void
	{
		$helperConfigurations = [
			'admin' => 'php_helper_admin',
			'both' => 'php_helper_both',
			'site' => 'php_helper_site',
		];

		foreach ($helperConfigurations as $target => $field)
		{
			$addKey = 'add_' . $field;

			if (isset($component->$addKey) && $component->$addKey == 1 &&
				StringHelper::check($component->$field))
			{
				$this->config->lang_target = $target;
				$guiMapper['field'] = $field;
				$guiMapper['prefix'] = PHP_EOL . PHP_EOL;

				$this->dispenser->set(
					$component->$field,
					'component_' . $field,
					null,
					null,
					$guiMapper
				);

				unset($guiMapper['prefix']);
			}
			else
			{
				$this->dispenser->hub['component_' . $field] = '';
			}

			unset($component->$field);
		}
	}

	/**
	 * Configures admin and site events for the component.
	 *
	 * @param  object  $component  The component object.
	 * @param  array   $guiMapper  The GUI mapper configuration.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function configureAdminAndSiteEvents(object $component, array $guiMapper): void
	{
		$eventConfigurations = [
			'admin' => 'php_admin_event',
			'site' => 'php_site_event',
		];

		foreach ($eventConfigurations as $target => $field)
		{
			$addKey = 'add_' . $field;

			if (isset($component->$addKey) && $component->$addKey == 1 &&
				StringHelper::check($component->$field))
			{
				$this->config->lang_target = $target;
				$guiMapper['field'] = $field;

				$this->dispenser->set(
					$component->$field,
					'component_' . $field,
					null,
					null,
					$guiMapper
				);
			}
			else
			{
				$this->dispenser->hub['component_' . $field] = '';
			}

			unset($component->$field);
		}
	}

	/**
	 * Processes the SQL for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setSql(object $component): void
	{
		// add_sql
		if ($component->add_sql == 1)
		{
			$this->dispenser->set(
				$component->sql,
				'sql',
				'component_sql'
			);
		}
		unset($component->sql);

		// add_sql_uninstall
		if ($component->add_sql_uninstall == 1)
		{
			$this->dispenser->set(
				$component->sql_uninstall,
				'sql_uninstall'
			);
		}
		unset($component->sql_uninstall);
	}

	/**
	 * Processes the bom for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setBom(object $component): void
	{
		if (StringHelper::check($component->bom))
		{
			$this->config->set('bom_path',
				$this->config->get('compiler_path', JPATH_ADMINISTRATOR . '/components/com_componentbuilder/compiler') . '/' . $component->bom
			);
		}
		unset($component->bom);
	}

	/**
	 * Processes the readme for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setReadMe(object $component): void
	{
		$component->readme = $component->addreadme
			? $this->customcode->update(
				base64_decode((string) $component->readme)
			)
			: '';
	}

	/**
	 * Processes dashboard-related methods and configurations for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setDashboardMethods(object $component): void
	{
		// set lang now
		$nowLang    = $this->config->lang_target;
		$this->config->lang_target = 'admin';

		// dashboard methods
		$component->dashboard_tab = (isset($component->dashboard_tab) && JsonHelper::check($component->dashboard_tab))
			? json_decode((string) $component->dashboard_tab, true)
			: null;

		if (ArrayHelper::check($component->dashboard_tab))
		{
			$component->dashboard_tab = array_map(
				function ($array) {
					$array['html'] = $this->customcode->update($array['html']);

					return $array;
				}, array_values($component->dashboard_tab)
			);
		}
		else
		{
			$component->dashboard_tab = '';
		}

		// add the php of the dashboard if set
		if (isset($component->php_dashboard_methods)
			&& StringHelper::check(
				$component->php_dashboard_methods
			))
		{
			// load the php for the dashboard model
			$component->php_dashboard_methods = $this->gui->set(
				$this->customcode->update(
					base64_decode((string) $component->php_dashboard_methods)
				),
				[
					'table' => 'component_dashboard',
					'field' => 'php_dashboard_methods',
					'id'    => (int) $component->component_dashboard_id,
					'type'  => 'php'
				]
			);
		}
		else
		{
			$component->php_dashboard_methods = '';
		}

		// reset back to now lang
		$this->config->lang_target = $nowLang;
	}

	/**
	 * Configure the component's server settings.
	 *
	 * This method coordinates URL validation (including XML filename extraction)
	 * and protocol configuration for update, changelog, and sales servers.
	 *
	 * @param  object  $component  The component object (passed by reference).
	 *
	 * @return void
	 * @since  5.2.1
	 */
	private function setServers(object $component): void
	{
		$this->normalizeServerUrls($component);
		$this->configureServerProtocols($component);
	}

	/**
	 * Validate and normalize the update and changelog server URLs.
	 *
	 * - Ensures URLs are well-formed (contain 'http' and pass StringHelper::check()).
	 * - If valid, extracts the XML filename using extractXmlFilename().
	 * - If invalid, resets the URL, target, and add flags appropriately.
	 *
	 * @param  object  $component  The component object (passed by reference).
	 *
	 * @return void
	 * @since  5.2.1
	 */
	private function normalizeServerUrls(object $component): void
	{
		$serverTypes = ['update_server', 'changelog_server'];

		foreach ($serverTypes as $server)
		{
			$urlProperty = "{$server}_url";
			$addProperty = "add_{$server}";
			$targetProperty = "{$server}_target";
			$xmlNameProperty = "{$server}_xml_file_name";
			$nameProperty = "{$server}_file_name";

			$url = $component->{$urlProperty} ?? '';

			// Validate URL presence & format
			if (empty($component->{$addProperty}) ||
				empty($url) ||
				(
					$component->{$addProperty} == 1 &&
					$component->{$targetProperty} != 3 &&
					(!StringHelper::check($url) || strpos($url, 'http') === false)
				)
			)
			{
				$component->{$addProperty} = 0;
				$component->{$targetProperty} = 3;
				$component->{$urlProperty} = '';
				$component->{$xmlNameProperty} = '';
				$component->{$nameProperty} = '';
				continue;
			}

			// URL seems valid → extract XML filename if possible
			$name = $this->extractXmlFilename($url);

			if ($name !== null)
			{
				$component->{$xmlNameProperty} = $name;
				$component->{$nameProperty} = $this->stripXmlExtension($name);
			}
			else
			{
				// URL is present but invalid XML filename
				$component->{$urlProperty} = '';
				$component->{$xmlNameProperty} = '';
				$component->{$nameProperty} = '';
			}
		}
	}

	/**
	 * Configure protocols for update, changelog, and sales servers.
	 *
	 * - If the server ID is numeric and > 0, fetches its protocol using GetHelper::var().
	 * - Otherwise, resets the server ID and protocol to 0.
	 * - For the sales server, also resets the "add_sales_server" flag.
	 *
	 * @param  object  $component  The component object (passed by reference).
	 *
	 * @return void
	 * @since  5.2.1
	 */
	private function configureServerProtocols(object $component): void
	{
		$serverTypes = ['update_server', 'sales_server', 'changelog_server'];

		foreach ($serverTypes as $server)
		{
			$id = $component->{$server} ?? 0;
			$addProperty = "add_{$server}";
			$protocolProperty = "{$server}_protocol";

			if (($component->{$addProperty} ?? 0) == 1 && is_numeric($id) && $id > 0)
			{
				$component->{$protocolProperty} = GetHelper::var('server', (int) $id, 'id', 'protocol');
			}
			else
			{
				$component->{$server} = 0;
				if ($server === 'sales_server')
				{
					$component->{$addProperty} = 0;
				}
				$component->{$protocolProperty} = 0;
			}
		}
	}

	/**
	 * Extract the XML filename from a given update server URL.
	 *
	 * This method:
	 * - Parses the URL using parse_url().
	 * - First looks for any query parameter whose value ends with ".xml" (case-insensitive).
	 * - If none is found, it falls back to the last path segment if it ends with ".xml".
	 * - Ignores query strings, fragments, and trailing slashes safely.
	 * - Returns the filename with its original case preserved.
	 *
	 * @param  string  $url  The full update server URL.
	 *
	 * @return string|null  The extracted XML filename, or null if none found.
	 * @since  5.2.1
	 */
	private function extractXmlFilename(string $url): ?string
	{
		// Trim and short-circuit on empty input
		$url = trim($url);

		if ($url === '')
		{
			return null;
		}

		// Use parse_url for robust URL parsing
		$parts = parse_url($url);

		// 1. Look for a query parameter with a value ending in ".xml"
		if (!empty($parts['query']))
		{
			$queryParams = [];
			parse_str($parts['query'], $queryParams);

			foreach ($queryParams as $value)
			{
				// Compare in lowercase, but return original case if match
				if (str_ends_with(strtolower($value), '.xml'))
				{
					return basename($value);
				}
			}
		}

		// 2. Fallback: use the last path segment
		if (!empty($parts['path']))
		{
			$filename = basename($parts['path']);

			if (str_ends_with(strtolower($filename), '.xml'))
			{
				return $filename;
			}
		}

		// No valid XML filename found
		return null;
	}

	/**
	 * Strip the ".xml" extension from a filename.
	 *
	 * This method:
	 * - Only strips the extension if it ends with ".xml" (case-insensitive).
	 * - Preserves the original case of the filename.
	 * - Safely handles filenames without ".xml" (returns unchanged).
	 *
	 * @param  string  $filename  The filename to process.
	 *
	 * @return string  The filename without the ".xml" extension.
	 * @since  5.2.1
	 */
	private function stripXmlExtension(string $filename): string
	{
		// Trim to avoid accidental whitespace issues
		$filename = trim($filename);

		// Case-insensitive check for ".xml" at the end
		if (str_ends_with(strtolower($filename), '.xml'))
		{
			return substr($filename, 0, -4);
		}

		return $filename;
	}

	/**
	 * Configures the list of folders to ignore for the repository.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setIgnoreFolders(object $component): void
	{
		if (isset($component->toignore) && StringHelper::check($component->toignore))
		{
			$component->toignore = strpos((string)$component->toignore, ',') !== false
				? array_map('trim', explode(',', (string)$component->toignore))
				: [trim((string)$component->toignore)];
		}
		else
		{
			$component->toignore = ['.git'];
		}
	}

	/**
	 * Configures all modules for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setModules(object $component): void
	{
		$this->modules->set($component);
	}

	/**
	 * Configures all plugins for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setPlugins(object $component): void
	{
		$this->plugins->set($component);
	}

	/**
	 * Configures the site router for the component.
	 *
	 * @param  object  $component  The component object.
	 *
	 * @return void
	 * @since  5.0.4
	 */
	private function setRouter(object $component): void
	{
		$this->router->set($component);
	}
}

