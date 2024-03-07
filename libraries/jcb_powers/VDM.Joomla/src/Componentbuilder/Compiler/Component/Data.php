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
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
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
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Compiler Event
	 *
	 * @var    EventInterface
	 * @since 3.2.0
	 */
	protected EventInterface $event;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Compiler Component Placeholder
	 *
	 * @var    ComponentPlaceholder
	 * @since 3.2.0
	 **/
	protected ComponentPlaceholder $componentPlaceholder;

	/**
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Field
	 *
	 * @var    Field
	 * @since 3.2.0
	 */
	protected Field $field;

	/**
	 * Compiler field name
	 *
	 * @var    FieldName
	 * @since 3.2.0
	 */
	protected FieldName $fieldName;

	/**
	 * Compiler Field Unique Name
	 *
	 * @var    UniqueName
	 * @since 3.2.0
	 **/
	protected UniqueName $uniqueName;

	/**
	 * Compiler Files Folders
	 *
	 * @var    Filesfolders
	 * @since 3.2.0
	 */
	protected Filesfolders $filesFolders;

	/**
	 * The modelling component history
	 *
	 * @var    Historycomponent
	 * @since 3.2.0
	 */
	protected Historycomponent $history;

	/**
	 * The modelling whmcs
	 *
	 * @var    Whmcs
	 * @since 3.2.0
	 */
	protected Whmcs $whmcs;

	/**
	 * The modelling Sql Tweaking
	 *
	 * @var    Sqltweaking
	 * @since 3.2.0
	 */
	protected Sqltweaking $sqltweaking;

	/**
	 * The modelling Admin Views
	 *
	 * @var    Adminviews
	 * @since 3.2.0
	 */
	protected Adminviews $adminviews;

	/**
	 * The modelling Site Views
	 *
	 * @var    Siteviews
	 * @since 3.2.0
	 */
	protected Siteviews $siteviews;

	/**
	 * The modelling Custom Admin Views
	 *
	 * @var    Customadminviews
	 * @since 3.2.0
	 */
	protected Customadminviews $customadminviews;

	/**
	 * The modelling Update Server
	 *
	 * @var    Updateserver
	 * @since 3.2.0
	 */
	protected Updateserver $updateserver;

	/**
	 * The modelling Joomla Modules
	 *
	 * @var    Joomlamodules
	 * @since 3.2.0
	 */
	protected Joomlamodules $modules;

	/**
	 * The modelling Joomla Plugins
	 *
	 * @var    Joomlaplugins
	 * @since 3.2.0
	 */
	protected Joomlaplugins $plugins;

	/**
	 * The modelling Joomla Site Router
	 *
	 * @var    Router
	 * @since 3.2.0
	 */
	protected Router $router;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config                The compiler config object.
	 * @param EventInterface|null       $event                 The compiler event api object.
	 * @param Placeholder|null          $placeholder           The compiler placeholder object.
	 * @param ComponentPlaceholder|null $componentPlaceholder  The compiler component placeholder object.
	 * @param Dispenser|null            $dispenser             The compiler customcode dispenser object.
	 * @param Customcode|null           $customcode            The compiler customcode object.
	 * @param Gui|null                  $gui                   The compiler customcode gui.
	 * @param Field|null                $field                 The compiler field object.
	 * @param FieldName|null            $fieldName             The compiler field name object.
	 * @param UniqueName|null           $uniqueName            The compiler field unique name object.
	 * @param Filesfolders|null         $filesFolders          The compiler files folders object.
	 * @param Historycomponent|null     $history               The modelling component history object.
	 * @param Whmcs|null                $whmcs                 The modelling whmcs object.
	 * @param Sqltweaking|null          $sqltweaking           The modelling sql tweaking object.
	 * @param Adminviews|null           $adminviews            The modelling adminviews object.
	 * @param Siteviews|null            $siteviews             The modelling siteviews object.
	 * @param Customadminviews|null     $customadminviews      The modelling customadminviews object.
	 * @param Updateserver|null         $updateserver          The modelling update server object.
	 * @param Joomlamodules|null        $modules               The modelling modules object.
	 * @param Joomlaplugins|null        $plugins               The modelling plugins object.
	 * @param Router|null              $router                 The modelling router object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?EventInterface $event = null,
		?Placeholder $placeholder = null, ?ComponentPlaceholder $componentPlaceholder = null,
		?Dispenser $dispenser = null, ?Customcode $customcode = null, ?Gui $gui = null,
		?Field $field = null, ?FieldName $fieldName = null, ?UniqueName $uniqueName = null,
		?Filesfolders $filesFolders = null, ?Historycomponent $history = null, ?Whmcs $whmcs = null,
		?Sqltweaking $sqltweaking = null, ?Adminviews $adminviews = null, ?Siteviews $siteviews = null,
		?Customadminviews $customadminviews = null, ?Updateserver $updateserver = null,
		?Joomlamodules $modules = null, ?Joomlaplugins $plugins = null, ?Router $router = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->event = $event ?: Compiler::_('Event');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->componentPlaceholder = $componentPlaceholder ?: Compiler::_('Component.Placeholder');
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->field = $field ?: Compiler::_('Field');
		$this->fieldName = $fieldName ?: Compiler::_('Field.Name');
		$this->uniqueName = $uniqueName ?: Compiler::_('Field.Unique.Name');
		$this->filesFolders = $filesFolders ?: Compiler::_('Model.Filesfolders');
		$this->history = $history ?: Compiler::_('Model.Historycomponent');
		$this->whmcs = $whmcs ?: Compiler::_('Model.Whmcs');
		$this->sqltweaking = $sqltweaking ?: Compiler::_('Model.Sqltweaking');
		$this->adminviews = $adminviews ?: Compiler::_('Model.Adminviews');
		$this->siteviews = $siteviews ?: Compiler::_('Model.Siteviews');
		$this->customadminviews = $customadminviews ?: Compiler::_('Model.Customadminviews');
		$this->updateserver = $updateserver ?: Compiler::_('Model.Updateserver');
		$this->modules = $modules ?: Compiler::_('Model.Joomlamodules');
		$this->plugins = $plugins ?: Compiler::_('Model.Joomlaplugins');
		$this->router = $router ?: Compiler::_('Model.Router');
		$this->db = Factory::getDbo();
	}

	/**
	 * get current component data
	 *
	 * @return  object|null The component data
	 * @since 3.2.0
	 */
	public function get(): ?object
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
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
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

		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);

		// Load the results as a list of stdClass objects
		$component = $this->db->loadObject();

		// make sure we got a component loaded
		if (!is_object($component) || !isset($component->system_name))
		{
			return null;
		}

		// Trigger Event: jcb_ce_onBeforeModelComponentData
		$this->event->trigger(
			'jcb_ce_onBeforeModelComponentData', [&$component]
		);

		// load the global placeholders
		$this->placeholder->active = $this->componentPlaceholder->get();

		// set component sales name
		$component->sales_name = StringHelper::safe(
			$component->system_name
		);

		// set the component name_code
		$component->name_code = StringHelper::safe(
			$component->name_code
		);

		// ensure version naming is correct
		$this->config->set('component_version', preg_replace(
				'/^v/i', '', (string) $component->component_version
			)
		);

		// set the website and autor for global use (default to VDM if not found)
		$this->config->set('project_website', $component->website ?? 'https://dev.vdm.io');
		$this->config->set('project_author', $component->author ?? 'VDM');

		// set the files and folders
		$this->filesFolders->set($component);

		// set the uikit switch
		$this->config->set('uikit', $component->adduikit);

		// set whmcs links if needed
		$this->whmcs->set($component);

		// set the footable switch
		if ($component->addfootable > 0)
		{
			// force add footable
			$this->config->set('footable', true);
			// add the version
			$this->config->set('footable_version', (3 == $component->addfootable) ? 3 : 2);
		}

		// set the addcustommenus data
		$component->addcustommenus = (isset($component->addcustommenus)
			&& JsonHelper::check($component->addcustommenus))
			? json_decode((string) $component->addcustommenus, true) : null;
		if (ArrayHelper::check($component->addcustommenus))
		{
			$component->custommenus = array_values($component->addcustommenus);
		}
		unset($component->addcustommenus);

		// set the sql tweak data
		$this->sqltweaking->set($component);

		// set the admin view data
		$this->adminviews->set($component);

		// set the site view data
		$this->siteviews->set($component);

		// set the custom_admin_views data
		$this->customadminviews->set($component);

		// set the config data
		$component->addconfig = (isset($component->addconfig)
			&& JsonHelper::check($component->addconfig))
			? json_decode((string) $component->addconfig, true) : null;
		if (ArrayHelper::check($component->addconfig))
		{
			$component->config = array_map(
				function ($field) {
					// make sure the alias and title is 0
					$field['alias'] = 0;
					$field['title'] = 0;
					// set the field details
					$this->field->set($field);
					// set unique name counter
					$this->uniqueName->set($field['base_name'], 'configs');

					// return field
					return $field;
				}, array_values($component->addconfig)
			);

			// do some house cleaning (for fields)
			foreach ($component->config as $field)
			{
				// so first we lock the field name in
				$this->fieldName->get($field, 'configs');
			}
			// unset original value
			unset($component->addconfig);
		}

		// set the add contributors
		$component->addcontributors = (isset($component->addcontributors)
			&& JsonHelper::check($component->addcontributors))
			? json_decode((string) $component->addcontributors, true) : null;
		if (ArrayHelper::check($component->addcontributors))
		{
			$this->config->set('add_contributors', true);
			$component->contributors = array_values(
				$component->addcontributors
			);
		}
		unset($component->addcontributors);

		// set the version updates
		$this->updateserver->set($component);

		// build the build date
		if ($this->config->get('add_build_date', 1) == 3)
		{
			if (empty($this->component->modified) ||
				$this->component->modified == '0000-00-00' ||
				$this->component->modified == '0000-00-00 00:00:00')
			{
				$this->config->set('build_date', $this->component->created);
			}
			else
			{
				$this->config->set('build_date', $this->component->modified);
			}
		}

		// build update SQL
		$this->history->set($component);

		// set GUI mapper
		$guiMapper = [
			'table' => 'joomla_component',
			'id'    => (int) $this->config->component_id,
			'field' => 'javascript',
			'type' => 'js'
		];

		// add_javascript
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

		// add global CSS
		$addGlobalCss = ['admin', 'site'];
		foreach ($addGlobalCss as $area)
		{
			// add_css if found
			if (isset($component->{'add_css_' . $area})
				&& $component->{'add_css_' . $area} == 1
				&& isset($component->{'css_' . $area})
				&& StringHelper::check(
					$component->{'css_' . $area}
				))
			{
				$this->dispenser->set(
					$component->{'css_' . $area},
					'component_css_' . $area
				);
			}
			else
			{
				$this->dispenser->hub['component_css_' . $area] = '';
			}
			unset($component->{'css_' . $area});
		}

		// set the lang target
		$this->config->lang_target = 'admin';

		// add PHP in ADMIN
		$addScriptMethods = [
			'php_preflight',
			'php_postflight',
			'php_method'
		];
		$addScriptTypes = [
			'install',
			'update',
			'uninstall'
		];
		// update GUI mapper
		$guiMapper['type'] = 'php';
		foreach ($addScriptMethods as $scriptMethod)
		{
			foreach ($addScriptTypes as $scriptType)
			{
				if (isset($component->{'add_' . $scriptMethod . '_' . $scriptType})
					&& $component->{'add_' . $scriptMethod . '_' . $scriptType} == 1
					&& StringHelper::check(
						$component->{$scriptMethod . '_' . $scriptType}
					))
				{
					// set GUI mapper field
					$guiMapper['field'] = $scriptMethod . '_' . $scriptType;
					$this->dispenser->set(
						$component->{$scriptMethod . '_' . $scriptType},
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
				unset($component->{$scriptMethod . '_' . $scriptType});
			}
		}

		// add_php_helper
		if ($component->add_php_helper_admin == 1
			&& StringHelper::check(
				$component->php_helper_admin
			))
		{
			$this->config->lang_target = 'admin';
			// update GUI mapper
			$guiMapper['field']  = 'php_helper_admin';
			$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
			$this->dispenser->set(
				$component->php_helper_admin,
				'component_php_helper_admin',
				null,
				null,
				$guiMapper
			);
			unset($guiMapper['prefix']);
		}
		else
		{
			$this->dispenser->hub['component_php_helper_admin'] = '';
		}
		unset($component->php_helper);

		// add_admin_event
		if ($component->add_admin_event == 1
			&& StringHelper::check($component->php_admin_event))
		{
			$this->config->lang_target = 'admin';
			// update GUI mapper field
			$guiMapper['field'] = 'php_admin_event';
			$this->dispenser->set(
				$component->php_admin_event,
				'component_php_admin_event',
				null,
				null,
				$guiMapper
			);
		}
		else
		{
			$this->dispenser->hub['component_php_admin_event'] = '';
		}
		unset($component->php_admin_event);

		// add_php_helper_both
		if ($component->add_php_helper_both == 1
			&& StringHelper::check($component->php_helper_both))
		{
			$this->config->lang_target = 'both';
			// update GUI mapper field
			$guiMapper['field']  = 'php_helper_both';
			$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
			$this->dispenser->set(
				$component->php_helper_both,
				'component_php_helper_both',
				null,
				null,
				$guiMapper
			);
			unset($guiMapper['prefix']);
		}
		else
		{
			$this->dispenser->hub['component_php_helper_both'] = '';
		}

		// add_php_helper_site
		if ($component->add_php_helper_site == 1
			&& StringHelper::check($component->php_helper_site))
		{
			$this->config->lang_target = 'site';
			// update GUI mapper field
			$guiMapper['field']  = 'php_helper_site';
			$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
			$this->dispenser->set(
				$component->php_helper_site,
				'component_php_helper_site',
				null,
				null,
				$guiMapper
			);
			unset($guiMapper['prefix']);
		}
		else
		{
			$this->dispenser->hub['component_php_helper_site'] = '';
		}
		unset($component->php_helper);

		// add_site_event
		if ($component->add_site_event == 1
			&& StringHelper::check($component->php_site_event))
		{
			$this->config->lang_target = 'site';
			// update GUI mapper field
			$guiMapper['field'] = 'php_site_event';
			$this->dispenser->set(
				$component->php_site_event,
				'component_php_site_event',
				null,
				null,
				$guiMapper
			);
		}
		else
		{
			$this->dispenser->hub['component_php_site_event'] = '';
		}
		unset($component->php_site_event);

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

		// bom
		if (StringHelper::check($component->bom))
		{
			$this->config->set('bom_path',
				$this->config->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/' . $component->bom
			);
		}
		unset($component->bom);

		// README
		$component->readme =
			$component->addreadme ?
				$this->customcode->update(
					base64_decode((string) $component->readme)
				) : '';

		// set lang now
		$nowLang    = $this->config->lang_target;
		$this->config->lang_target = 'admin';

		// dashboard methods
		$component->dashboard_tab = (isset($component->dashboard_tab)
			&& JsonHelper::check($component->dashboard_tab))
			? json_decode((string) $component->dashboard_tab, true) : null;
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

		// catch empty URL to update server TODO: we need to fix this in  better way later
		if (empty($component->add_update_server) || ($component->add_update_server == 1 && $component->update_server_target != 3
			&& (
				!StringHelper::check($component->update_server_url)
				|| strpos($component->update_server_url, 'http') === false
			)))
		{
			// we fall back to other, since we can't work with an empty update server URL
			$component->add_update_server = 0;
			$component->update_server_target = 3;
			$component->update_server_url = '';
		}

		// add the update/sales server FTP details if that is the expected protocol
		$serverArray = array('update_server', 'sales_server');
		foreach ($serverArray as $server)
		{
			if ($component->{'add_' . $server} == 1
				&& is_numeric($component->{$server})
				&& $component->{$server} > 0)
			{
				// get the server protocol
				$component->{$server . '_protocol'}
					= GetHelper::var(
					'server', (int) $component->{$server}, 'id', 'protocol'
				);
			}
			else
			{
				$component->{$server} = 0;
				// only change this for sales server (update server can be added loacaly to the zip file)
				if ('sales_server' === $server)
				{
					$component->{'add_' . $server} = 0;
				}
				$component->{$server . '_protocol'} = 0;
			}
		}

		// set the ignore folders for repo if found
		if (isset($component->toignore)
			&& StringHelper::check(
				$component->toignore
			))
		{
			if (strpos((string) $component->toignore, ',') !== false)
			{
				$component->toignore = array_map(
					'trim', (array) explode(',', (string) $component->toignore)
				);
			}
			else
			{
				$component->toignore = array(trim((string) $component->toignore));
			}
		}
		else
		{
			// the default is to ignore the repo folder
			$component->toignore = array('.git');
		}

		// set all modules
		$this->modules->set($component);

		// set all plugins
		$this->plugins->set($component);

		// set the site router
		$this->router->set($component);

		// Trigger Event: jcb_ce_onAfterModelComponentData
		$this->event->trigger(
			'jcb_ce_onAfterModelComponentData',
			[&$component]
		);

		// return found component data
		return $component;
	}
}

