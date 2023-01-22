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

namespace VDM\Joomla\Componentbuilder\Compiler\Adminview;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customtabs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Tabs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Fields;
use VDM\Joomla\Componentbuilder\Compiler\Model\Historyadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Permissions;
use VDM\Joomla\Componentbuilder\Compiler\Model\Conditions;
use VDM\Joomla\Componentbuilder\Compiler\Model\Relations;
use VDM\Joomla\Componentbuilder\Compiler\Model\Linkedviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Javascriptadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Cssadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Phpadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Custombuttons;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customimportscripts;
use VDM\Joomla\Componentbuilder\Compiler\Model\Ajaxadmin;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customalias;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sql;
use VDM\Joomla\Componentbuilder\Compiler\Model\Mysqlsettings;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Admin View Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * Admin views
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $data;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

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
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * The modelling customtabs
	 *
	 * @var    Customtabs
	 * @since 3.2.0
	 */
	protected Customtabs $customtabs;

	/**
	 * The modelling tabs
	 *
	 * @var    Tabs
	 * @since 3.2.0
	 */
	protected Tabs $tabs;

	/**
	 * The modelling fields
	 *
	 * @var    Fields
	 * @since 3.2.0
	 */
	protected Fields $fields;

	/**
	 * The modelling admin view history
	 *
	 * @var    Historyadminview
	 * @since 3.2.0
	 */
	protected Historyadminview $history;

	/**
	 * The modelling permissions
	 *
	 * @var    Permissions
	 * @since 3.2.0
	 */
	protected Permissions $permissions;

	/**
	 * The modelling conditions
	 *
	 * @var    Conditions
	 * @since 3.2.0
	 */
	protected Conditions $conditions;

	/**
	 * The modelling relations
	 *
	 * @var    Relations
	 * @since 3.2.0
	 */
	protected Relations $relations;

	/**
	 * The modelling linked views
	 *
	 * @var    Linkedviews
	 * @since 3.2.0
	 */
	protected Linkedviews $linkedviews;

	/**
	 * The modelling javascript
	 *
	 * @var    Javascriptadminview
	 * @since 3.2.0
	 */
	protected Javascriptadminview $javascript;

	/**
	 * The modelling css
	 *
	 * @var    Cssadminview
	 * @since 3.2.0
	 */
	protected Cssadminview $css;

	/**
	 * The modelling php admin view
	 *
	 * @var    Phpadminview
	 * @since 3.2.0
	 */
	protected Phpadminview $php;

	/**
	 * The modelling custom buttons
	 *
	 * @var    Custombuttons
	 * @since 3.2.0
	 */
	protected Custombuttons $custombuttons;

	/**
	 * The modelling custom import scripts
	 *
	 * @var    Customimportscripts
	 * @since 3.2.0
	 */
	protected Customimportscripts $customimportscripts;

	/**
	 * The modelling ajax
	 *
	 * @var    Ajaxadmin
	 * @since 3.2.0
	 */
	protected Ajaxadmin $ajax;

	/**
	 * The modelling custom alias
	 *
	 * @var    Customalias
	 * @since 3.2.0
	 */
	protected Customalias $customalias;

	/**
	 * The modelling sql
	 *
	 * @var    Sql
	 * @since 3.2.0
	 */
	protected Sql $sql;

	/**
	 * The modelling mysql settings
	 *
	 * @var    Mysqlsettings
	 * @since 3.2.0
	 */
	protected Mysqlsettings $mysqlsettings;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Constructor
	 *
	 * @param Config|null                 $config                 The compiler config object.
	 * @param Registry|null               $registry               The compiler registry object.
	 * @param EventInterface|null         $event                  The compiler event api object.
	 * @param Placeholder|null            $placeholder            The compiler placeholder object.
	 * @param Dispenser|null              $dispenser              The compiler customcode dispenser object.
	 * @param Customtabs|null             $customtabs             The modelling customtabs object.
	 * @param Tabs|null                   $tabs                   The modelling tabs object.
	 * @param Fields|null                 $fields                 The modelling fields object.
	 * @param Historyadminview|null       $history                The modelling admin view history object.
	 * @param Permissions|null            $permissions            The modelling permissions object.
	 * @param Conditions|null             $conditions             The modelling conditions object.
	 * @param Relations|null              $relations              The modelling relations object.
	 * @param Linkedviews|null            $linkedviews            The modelling linked views object.
	 * @param Javascriptadminview|null    $javascript             The modelling javascript object.
	 * @param Cssadminview|null           $css                    The modelling css object.
	 * @param Phpadminview|null           $php                    The modelling php admin view object.
	 * @param Custombuttons|null          $custombuttons          The modelling custom buttons object.
	 * @param Customimportscripts|null    $customimportscripts    The modelling custom import scripts object.
	 * @param Ajaxadmin|null              $ajax                   The modelling ajax object.
	 * @param Customalias|null            $customalias            The modelling custom alias object.
	 * @param Sql|null                    $sql                    The modelling sql object.
	 * @param Mysqlsettings|null          $mysqlsettings          The modelling mysql settings object.
	 * @param \JDatabaseDriver|null       $db                     The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?EventInterface $event = null, ?Placeholder $placeholder = null, ?Dispenser $dispenser = null,
		?Customtabs $customtabs = null, ?Tabs $tabs = null, ?Fields $fields = null,
		?Historyadminview $history = null, ?Permissions $permissions = null,
		?Conditions $conditions = null, Relations $relations = null, ?Linkedviews $linkedviews = null,
		?Javascriptadminview $javascript = null, ?Cssadminview $css = null, ?Phpadminview $php = null,
		?Custombuttons $custombuttons = null, ?Customimportscripts $customimportscripts = null,
		?Ajaxadmin $ajax = null, ?Customalias $customalias = null, ?Sql $sql = null,
		?Mysqlsettings $mysqlsettings = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->event = $event ?: Compiler::_('Event');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
		$this->customtabs = $customtabs ?: Compiler::_('Model.Customtabs');
		$this->tabs = $tabs ?: Compiler::_('Model.Tabs');
		$this->fields = $fields ?: Compiler::_('Model.Fields');
		$this->history = $history ?: Compiler::_('Model.Historyadminview');
		$this->permissions = $permissions ?: Compiler::_('Model.Permissions');
		$this->conditions = $conditions ?: Compiler::_('Model.Conditions');
		$this->relations = $relations ?: Compiler::_('Model.Relations');
		$this->linkedviews = $linkedviews ?: Compiler::_('Model.Linkedviews');
		$this->javascript = $javascript ?: Compiler::_('Model.Javascriptadminview');
		$this->css = $css ?: Compiler::_('Model.Cssadminview');
		$this->php = $php ?: Compiler::_('Model.Phpadminview');
		$this->custombuttons = $custombuttons ?: Compiler::_('Model.Custombuttons');
		$this->customimportscripts = $customimportscripts ?: Compiler::_('Model.Customimportscripts');
		$this->ajax = $ajax ?: Compiler::_('Model.Ajaxadmin');
		$this->customalias = $customalias ?: Compiler::_('Model.Customalias');
		$this->sql = $sql ?: Compiler::_('Model.Sql');
		$this->mysqlsettings = $mysqlsettings ?: Compiler::_('Model.Mysqlsettings');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get Admin View Data
	 *
	 * @param   int  $id  The view ID
	 *
	 * @return  object|null The view data
	 * @since 3.2.0
	 */
	public function get(int $id): ?object
	{
		if (!isset($this->data[$id]))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'b.addfields',
						'b.id',
						'c.addconditions',
						'c.id',
						'r.addrelations',
						't.tabs'
					), array(
						'addfields',
						'addfields_id',
						'addconditions',
						'addconditions_id',
						'addrelations',
						'customtabs'
					)
				)
			);

			$query->from('#__componentbuilder_admin_view AS a');
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_admin_fields', 'b')
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('b.admin_view') . ')'
			);

			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_fields_conditions', 'c'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('c.admin_view') . ')'
			);

			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_fields_relations', 'r'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('r.admin_view') . ')'
			);

			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_custom_tabs', 't'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('t.admin_view') . ')'
			);

			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

			// for plugin event TODO change event api signatures
			$component_context = $this->config->component_context;
			// Trigger Event: jcb_ce_onBeforeQueryViewData
			$this->event->trigger(
				'jcb_ce_onBeforeQueryViewData',
				array(&$component_context, &$id, &$query, &$this->db)
			);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$view = $this->db->loadObject();

			// setup single view code names to use in storing the data
			$view->name_single_code = 'oops_hmm_' . $id;
			if (isset($view->name_single) && $view->name_single != 'null')
			{
				$view->name_single_code = StringHelper::safe(
					$view->name_single
				);
			}

			// setup list view code name to use in storing the data
			$view->name_list_code = 'oops_hmmm_' . $id;
			if (isset($view->name_list) && $view->name_list != 'null')
			{
				$view->name_list_code = StringHelper::safe(
					$view->name_list
				);
			}

			// check the length of the view name (+5 for com_ and _)
			$name_length = $this->config->component_code_name_length + strlen(
					(string) $view->name_single_code
				) + 5;
			// when the name is larger than 49 we need to add the assets' table name fix
			if ($name_length > 49)
			{
				$this->config->set('add_assets_table_name_fix', true);
			}

			// setup token check
			if (!isset($this->dispenser->hub['token']))
			{
				$this->dispenser->hub['token'] = [];
			}
			$this->dispenser->hub['token'][$view->name_single_code] = false;
			$this->dispenser->hub['token'][$view->name_list_code] = false;

			// set some placeholders
			$this->placeholder->set('view', $view->name_single_code);
			$this->placeholder->set('views', $view->name_list_code);
			$this->placeholder->set('View', StringHelper::safe(
				$view->name_single, 'F'
			));
			$this->placeholder->set('Views', StringHelper::safe(
				$view->name_list, 'F'
			));
			$this->placeholder->set('VIEW', StringHelper::safe(
				$view->name_single, 'U'
			));
			$this->placeholder->set('VIEWS', StringHelper::safe(
				$view->name_list, 'U'
			));

			// for plugin event TODO change event api signatures
			$placeholders = $this->placeholder->active;
			$component_context = $this->config->component_context;

			// Trigger Event: jcb_ce_onBeforeModelViewData
			$this->event->trigger(
				'jcb_ce_onBeforeModelViewData',
				array(&$component_context, &$view, &$placeholders)
			);
			unset($placeholders);

			// add the tables
			$view->addtables = (isset($view->addtables)
				&& JsonHelper::check($view->addtables))
				? json_decode((string) $view->addtables, true) : null;
			if (ArrayHelper::check($view->addtables))
			{
				$view->tables = array_values($view->addtables);
			}
			unset($view->addtables);

			// set custom tabs
			$this->customtabs->set($view);

			// set the local tabs
			$this->tabs->set($view);

			// set permissions
			$this->permissions->set($view);

			// set fields
			$this->fields->set($view);

			// build update SQL
			$this->history->set($view);

			// set the conditions
			$this->conditions->set($view);

			// set the relations
			$this->relations->set($view);

			// set linked views
			$this->linkedviews->set($view);

			// set the lang target
			$this->config->lang_target = 'admin';
			if ($this->registry->get('builder.site_edit_view.' . $id, false))
			{
				$this->config->lang_target = 'both';
			}

			// set javascript
			$this->javascript->set($view);

			// set css
			$this->css->set($view);

			// set php
			$this->php->set($view);

			// set custom buttons
			$this->custombuttons->set($view);

			// set custom import scripts
			$this->customimportscripts->set($view);

			// set Ajax for this view
			$this->ajax->set($view);

			// activate alias builder
			$this->customalias->set($view);

			// set sql
			$this->sql->set($view);

			// set mySql Table Settings
			$this->mysqlsettings->set($view);

			// for plugin event TODO change event api signatures
			$placeholders = $this->placeholder->active;

			// Trigger Event: jcb_ce_onAfterModelViewData
			$this->event->trigger(
				'jcb_ce_onAfterModelViewData',
				array(&$component_context, &$view, &$placeholders)
			);

			// clear placeholders
			$this->placeholder->remove('view');
			$this->placeholder->remove('views');
			$this->placeholder->remove('View');
			$this->placeholder->remove('Views');
			$this->placeholder->remove('VIEW');
			$this->placeholder->remove('VIEWS');

			// store this view to class object
			$this->data[$id] = $view;
		}

		// return the found view data
		return $this->data[$id];
	}

}

